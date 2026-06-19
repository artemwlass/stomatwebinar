<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CertificateMail;
use App\Models\WebinarTestResult;
use App\Support\CertificatePdf;
use App\Support\CertificatePresenter;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class CertificateController extends Controller
{
    public function view(WebinarTestResult $result): Response
    {
        $this->authorizeAdmin();
        $this->ensureCertificateExists($result);

        $fileName = CertificatePresenter::fileName($result);

        return CertificatePdf::make($result)->stream($fileName);
    }

    public function download(WebinarTestResult $result): Response
    {
        $this->authorizeAdmin();
        $this->ensureCertificateExists($result);

        return CertificatePdf::make($result)->download(CertificatePresenter::fileName($result));
    }

    public function send(WebinarTestResult $result): RedirectResponse
    {
        $this->authorizeAdmin();
        $this->ensureCertificateExists($result);
        $result->loadMissing(['user', 'webinar']);

        if (blank($result->user?->email)) {
            Notification::make()
                ->title('У пользователя не указан email')
                ->danger()
                ->send();

            return back();
        }

        Mail::to($result->user->email)->send(new CertificateMail($result));

        Notification::make()
            ->title('Сертификат отправлен')
            ->body($result->user->email)
            ->success()
            ->send();

        return back();
    }

    public function destroy(WebinarTestResult $result): RedirectResponse
    {
        $this->authorizeAdmin();
        $this->ensureCertificateExists($result);

        $result->forceFill([
            'is_passed' => false,
            'passed_at' => null,
            'certificate_number' => null,
        ])->save();

        Notification::make()
            ->title('Сертификат удален')
            ->success()
            ->send();

        return back();
    }

    private function authorizeAdmin(): void
    {
        abort_unless((bool) auth()->user()?->is_admin, 403);
    }

    private function ensureCertificateExists(WebinarTestResult $result): void
    {
        abort_unless($result->is_passed && filled($result->certificate_number), 404);
    }
}
