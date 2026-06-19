<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebinarTestResult;
use App\Support\WebinarTestResultPdf;

class WebinarTestResultPdfController extends Controller
{
    public function __invoke(WebinarTestResult $result)
    {
        abort_unless((bool) auth()->user()?->is_admin, 403);

        $result->loadMissing(['user', 'webinar']);

        $fileName = sprintf(
            'webinar-%s-test-result-%s.pdf',
            $result->webinar_id,
            $result->getKey(),
        );

        return WebinarTestResultPdf::make($result)->download($fileName);
    }
}
