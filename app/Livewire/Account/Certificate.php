<?php

namespace App\Livewire\Account;

use App\Models\Webinar;
use App\Models\WebinarTestResult;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\Component;

class Certificate extends Component
{
    protected function certificateFileName(WebinarTestResult $result): string
    {
        $year = (string) optional($result->passed_at)->format('Y') ?: now()->format('Y');
        $providerNumber = (string) config('certificates.provider_number', '2169');
        $courseId = (string) ($result->webinar->certificate_course_id ?: '0000000');
        $uniqueNumber = (string) ($result->certificate_number ?: '000000');

        return "{$year}-{$providerNumber}-{$courseId}-{$uniqueNumber}.pdf";
    }

    protected function groupedPassedCertificates(): Collection
    {
        return WebinarTestResult::query()
            ->with('webinar')
            ->where('user_id', Auth::id())
            ->where('is_passed', true)
            ->whereNotNull('passed_at')
            ->orderByDesc('passed_at')
            ->get()
            ->map(function (WebinarTestResult $result) {
                $result->certificate_file_name = $this->certificateFileName($result);
                $result->group_label = $result->passed_at->translatedFormat('F Y');

                return $result;
            })
            ->groupBy('group_label');
    }

    protected function groupedFutureCertificates(): Collection
    {
        $passedWebinarIds = WebinarTestResult::query()
            ->where('user_id', Auth::id())
            ->where('is_passed', true)
            ->pluck('webinar_id');

        return Auth::user()
            ->groups()
            ->with('webinar')
            ->get()
            ->pluck('webinar')
            ->filter(function (?Webinar $webinar) use ($passedWebinarIds) {
                return $webinar
                    && ! $passedWebinarIds->contains($webinar->id);
            })
            ->unique('id')
            ->sortBy(function (Webinar $webinar) {
                return optional($webinar->date_preorder)->timestamp ?? now()->timestamp;
            })
            ->values()
            ->map(function (Webinar $webinar) {
                $webinar->group_label = optional($webinar->date_preorder)->translatedFormat('F Y') ?: 'Майбутні події';

                return $webinar;
            })
            ->groupBy('group_label');
    }

    public function render()
    {
        SEOMeta::setTitle('Мої сертифікати');
        SEOMeta::setDescription('Мої сертифікати та майбутні події в особистому кабінеті.');

        $passedCertificates = $this->groupedPassedCertificates();
        $futureCertificates = $this->groupedFutureCertificates();

        return view('livewire.account.certificate', compact('passedCertificates', 'futureCertificates'))
            ->layout('components.layouts.account');
    }
}
