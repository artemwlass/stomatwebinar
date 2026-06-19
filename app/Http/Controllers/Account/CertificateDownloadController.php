<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\WebinarTestResult;
use App\Support\CertificatePdf;
use App\Support\CertificatePresenter;
use Illuminate\Support\Facades\Auth;

class CertificateDownloadController extends Controller
{
    public function __invoke(WebinarTestResult $result)
    {
        abort_unless($result->user_id === Auth::id(), 403);
        abort_unless($result->is_passed, 404);

        $result->loadMissing(['webinar', 'user']);

        $fileName = CertificatePresenter::fileName($result);

        return CertificatePdf::make($result)->download($fileName);
    }
}
