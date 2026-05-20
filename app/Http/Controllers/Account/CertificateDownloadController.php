<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\WebinarTestResult;
use App\Support\CertificatePresenter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CertificateDownloadController extends Controller
{
    public function __invoke(WebinarTestResult $result)
    {
        abort_unless($result->user_id === Auth::id(), 403);
        abort_unless($result->is_passed, 404);

        $result->loadMissing(['webinar', 'user']);

        $pdf = Pdf::loadView('pdf.certificates.default', [
            'result' => $result,
            'fileName' => CertificatePresenter::fileName($result),
            'fullName' => CertificatePresenter::fullName($result),
            'providerNumber' => config('certificates.provider_number', '2169'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download(CertificatePresenter::fileName($result));
    }
}
