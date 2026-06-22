<?php

namespace App\Support;

use App\Models\WebinarTestResult;

class CertificatePresenter
{
    public static function number(WebinarTestResult $result): string
    {
        $year = $result->passed_at
            ? $result->passed_at->copy()->timezone(config('app.display_timezone'))->format('Y')
            : now()->timezone(config('app.display_timezone'))->format('Y');
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
