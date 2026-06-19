<?php

namespace App\Livewire\Account;

use App\Models\Webinar as WebinarModel;
use Artesaos\SEOTools\Facades\SEOMeta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Webinar extends Component
{
    protected function combineDateTime($date, $time): ?Carbon
    {
        if (! $date || ! $time) {
            return null;
        }

        return Carbon::parse($date->format('Y-m-d') . ' ' . $time);
    }

    protected function formatCountdown(Carbon $target, Carbon $now): string
    {
        $targetDayStart = $target->copy()->startOfDay();

        if ($now->lt($targetDayStart)) {
            return $now->diffInDays($targetDayStart) . ' дн.';
        }

        $totalSeconds = max(0, $now->diffInSeconds($target, false));

        $hours = intdiv($totalSeconds, 3600);
        $minutes = intdiv($totalSeconds % 3600, 60);
        $seconds = $totalSeconds % 60;

        return sprintf('%02d : %02d : %02d', $hours, $minutes, $seconds);
    }

    public function render()
    {
        SEOMeta::setTitle('Вебінари у записі');
        SEOMeta::setDescription('Вебінари у записі в особистому кабінеті.');

        $userGroups = Auth::user()->groups()->with('webinar')->get();

        $accessibleWebinarIds = $userGroups->map(function ($group) {
            return optional($group->webinar)->id;
        })->filter()->values();

        $purchasedWebinars = $userGroups
            ->pluck('webinar')
            ->filter();

        $activeWebinars = WebinarModel::query()
            ->where('is_active', true)
            ->orderByDesc('order')
            ->get();

        $webinars = $purchasedWebinars
            ->merge($activeWebinars)
            ->unique('id')
            ->sortByDesc(function (WebinarModel $webinar) use ($accessibleWebinarIds) {
                return ($accessibleWebinarIds->contains($webinar->id) ? 1000000 : 0) + (int) $webinar->order;
            })
            ->values()
            ->map(function (WebinarModel $webinar) use ($accessibleWebinarIds) {
                $isPurchased = $accessibleWebinarIds->contains($webinar->id);
                $webinarStartAt = $this->combineDateTime($webinar->date_preorder, $webinar->time_preorder);
                $testingStartAt = $this->combineDateTime($webinar->date_testing_start, $webinar->time_testing_start);
                $testingEndAt = $this->combineDateTime($webinar->date_testing_end, $webinar->time_testing_end);
                $now = now();

                $webinarStatusLabel = 'Вебінар відкриється';
                $webinarStatusTarget = $webinarStartAt?->toIso8601String();
                $webinarStatusExpired = $isPurchased ? 'Відкрито' : 'Закрито';
                $webinarStatusText = $webinarStartAt
                    ? $this->formatCountdown($webinarStartAt, $now)
                    : 'Дату не вказано';

                if ($webinarStartAt && $webinarStartAt->lte($now)) {
                    $webinarStatusLabel = 'Вебінар відкритий';
                    $webinarStatusTarget = null;
                    $webinarStatusText = $isPurchased ? 'Відкрито' : 'Закрито';
                }

                $testingStatusLabel = 'Тестування відкриється';
                $testingStatusTarget = $testingStartAt?->toIso8601String();
                $testingStatusExpired = 'Недоступно';
                $testingStatusText = $testingStartAt
                    ? $this->formatCountdown($testingStartAt, $now)
                    : 'Тестування закрито';

                if ($testingStartAt && $testingStartAt->lte($now) && $testingEndAt && $testingEndAt->gt($now)) {
                    $testingStatusLabel = 'Тестування завершиться';
                    $testingStatusTarget = $testingEndAt->toIso8601String();
                    $testingStatusExpired = 'Завершено';
                    $testingStatusText = $this->formatCountdown($testingEndAt, $now);
                } elseif ($testingEndAt && $testingEndAt->lte($now)) {
                    $testingStatusLabel = 'Тестування завершено';
                    $testingStatusTarget = null;
                    $testingStatusText = 'Завершено';
                }

                $webinar->is_purchased = $isPurchased;
                $webinar->video_url = $isPurchased && $webinarStartAt && $webinarStartAt->lte($now)
                    ? route('webinar.video.show', $webinar->slug)
                    : '#';
                $webinar->landing_url = route('webinar.show', $webinar->slug);
                $webinar->display_lecturers = collect($webinar->lecturers ?? [])
                    ->pluck('name')
                    ->filter()
                    ->values()
                    ->all();
                $webinar->webinar_status_label = $webinarStatusLabel;
                $webinar->webinar_status_target = $webinarStatusTarget;
                $webinar->webinar_status_target_ts = $webinarStartAt?->getTimestampMs();
                $webinar->webinar_status_day_start_ts = $webinarStartAt?->copy()->startOfDay()->getTimestampMs();
                $webinar->webinar_status_expired = $webinarStatusExpired;
                $webinar->webinar_status_text = $webinarStatusText;
                $webinar->testing_status_label = $testingStatusLabel;
                $webinar->testing_status_target = $testingStatusTarget;
                $webinar->testing_status_target_ts = $testingStatusTarget ? ($testingStartAt && $testingStartAt->lte($now) && $testingEndAt ? $testingEndAt->getTimestampMs() : $testingStartAt?->getTimestampMs()) : null;
                $webinar->testing_status_day_start_ts = $testingStatusTarget
                    ? ($testingStartAt && $testingStartAt->lte($now) && $testingEndAt
                        ? $testingEndAt->copy()->startOfDay()->getTimestampMs()
                        : $testingStartAt?->copy()->startOfDay()->getTimestampMs())
                    : null;
                $webinar->testing_status_expired = $testingStatusExpired;
                $webinar->testing_status_text = $testingStatusText;

                return $webinar;
            });

        return view('livewire.account.webinar', compact('webinars'))
            ->layout('components.layouts.account');
    }
}
