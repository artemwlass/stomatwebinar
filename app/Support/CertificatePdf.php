<?php

namespace App\Support;

use App\Models\WebinarTestResult;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPdf;

class CertificatePdf
{
    public static function make(WebinarTestResult $result): DomPdf
    {
        $result->loadMissing(['webinar', 'user']);

        return Pdf::loadView('pdf.certificates.default', [
            'result' => $result,
            'fileName' => CertificatePresenter::fileName($result),
            'certificateNumber' => CertificatePresenter::number($result),
            'fullName' => CertificatePresenter::fullName($result),
            'courseTitle' => $result->webinar->title,
            'specialty' => $result->user->specialty ?: 'Спеціальність не вказана',
            'issuedAt' => $result->passed_at
                ? $result->passed_at->copy()->timezone(config('app.display_timezone'))->format('d.m.Y')
                : '—',
            'issuedNextDayAt' => $result->passed_at
                ? $result->passed_at->copy()->timezone(config('app.display_timezone'))->addDay()->format('d.m.Y')
                : '—',
            'providerNumber' => config('certificates.provider_number', '2169'),
            'providerName' => config('certificates.provider_name', 'ТОВ "АКАДЕМІЯ СУЧАСНОЇ СТОМАТОЛОГІЇ"'),
        ])->setPaper('a4', 'landscape');
    }
}
