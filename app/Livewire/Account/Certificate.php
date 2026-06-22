<?php

namespace App\Livewire\Account;

use App\Models\Webinar;
use App\Models\WebinarTestResult;
use App\Support\CertificatePresenter;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\Component;

class Certificate extends Component
{
    protected function groupedPassedCertificates(): Collection
    {
        return WebinarTestResult::query()
            ->with(['webinar', 'user'])
            ->where('user_id', Auth::id())
            ->where('is_passed', true)
            ->whereNotNull('passed_at')
            ->orderByDesc('passed_at')
            ->get()
            ->map(function (WebinarTestResult $result) {
                $result->certificate_file_name = CertificatePresenter::fileName($result);
                $result->download_url = route('account.certificate.download', $result);
                $result->group_label = $result->passed_at
                    ->copy()
                    ->timezone(config('app.display_timezone'))
                    ->locale('uk')
                    ->translatedFormat('F Y');

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
                    && $this->hasTests($webinar)
                    && ! $passedWebinarIds->contains($webinar->id);
            })
            ->unique('id')
            ->sortBy(function (Webinar $webinar) {
                return optional($webinar->date_preorder)->timestamp ?? now()->timestamp;
            })
            ->values()
            ->map(function (Webinar $webinar) {
                $webinar->group_label = $webinar->date_preorder
                    ? $webinar->date_preorder->copy()->timezone(config('app.display_timezone'))->locale('uk')->translatedFormat('F Y')
                    : 'Майбутні події';

                return $webinar;
            })
            ->groupBy('group_label');
    }

    protected function hasTests(Webinar $webinar): bool
    {
        return collect($webinar->tests ?? [])
            ->contains(fn ($test) => ! empty($test['question']) && ! empty($test['answers']) && is_array($test['answers']));
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
