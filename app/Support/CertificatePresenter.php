<?php

namespace App\Support;

use App\Models\WebinarTestResult;

class CertificatePresenter
{
    public static function number(WebinarTestResult $result): string
    {
        $year = (string) optional($result->passed_at)->format('Y') ?: now()->format('Y');
        $providerNumber = (string) config('certificates.provider_number', '2169');
        $courseId = (string) ($result->webinar->certificate_course_id ?: '0000000');
        $uniqueNumber = (string) ($result->certificate_number ?: '000000');

        return "{$year}-{$providerNumber}-{$courseId}-{$uniqueNumber}";
    }

    public static function fileName(WebinarTestResult $result): string
    {
        return self::number($result) . '.pdf';
    }

    public static function fullName(WebinarTestResult $result): string
    {
        return trim(implode(' ', array_filter([
            $result->user?->surname,
            $result->user?->name,
        ])));
    }
}
