<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Webinar;
use App\Support\WebinarCertificatesExport;

class WebinarCertificatesExportController extends Controller
{
    public function __invoke(Webinar $webinar)
    {
        abort_unless((bool) auth()->user()?->is_admin, 403);

        return WebinarCertificatesExport::download($webinar);
    }
}
