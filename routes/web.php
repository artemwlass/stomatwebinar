<?php

use App\Models\Webinar;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', \App\Livewire\Home\Home::class)->name('home');


Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');
Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
Route::get('/forgot-password', \App\Livewire\Auth\Forgot::class)->name('forgot');
Route::get('/reset/{token}', \App\Livewire\Auth\Reset::class)->name('reset');

Route::get('/account', \App\Livewire\Account\Index::class)->middleware('auth')->name('account');
Route::get('/account/certificate', \App\Livewire\Account\Certificate::class)->middleware('auth')->name('account.certificate');
Route::get('/account/certificate/{result}/download', \App\Http\Controllers\Account\CertificateDownloadController::class)->middleware('auth')->name('account.certificate.download');
Route::get('/account/webinar', \App\Livewire\Account\Webinar::class)->middleware('auth')->name('account.webinar');
Route::get('/account/tarif', \App\Livewire\Account\Tarif::class)->middleware('auth')->name('account.tarif');
Route::get('/account/webinar-data', \App\Livewire\Account\WebinarData::class)->middleware('auth')->name('account.webinar-data');
Route::get('/account/achievements', \App\Livewire\Account\Achievements::class)->middleware('auth')->name('account.achievements');
Route::get('/account/cases', \App\Livewire\Account\Cases::class)->middleware('auth')->name('account.cases');
Route::get('/account/cases/{case}', \App\Livewire\Account\CaseShow::class)->middleware('auth')->name('account.cases.show');
Route::get('/account/equipment', \App\Livewire\Account\Equipment::class)->middleware('auth')->name('account.equipment');
Route::get('/account/blog', \App\Livewire\Blog\Index::class)->middleware('auth')->name('blog');
Route::get('/account/blog/{slug}', \App\Livewire\Blog\Post::class)->middleware('auth')->name('post');

Route::get('/politika-konfidentsiynosti', \App\Livewire\Politic::class)->name('politic');
Route::get('/dogovir-publichnoyi-ofereti', \App\Livewire\DogovorOferty::class)->name('dogovor');
Route::get('/payments', \App\Livewire\Payments::class)->name('payment');

Route::get('payment-form/{token}', \App\Livewire\Payment\Payment::class)->name('payment.form');

Route::middleware('auth')
    ->prefix('admin/certificates')
    ->name('admin.certificates.')
    ->group(function () {
        Route::get('/webinars/{webinar}/export', \App\Http\Controllers\Admin\WebinarCertificatesExportController::class)
            ->name('webinar-export');
        Route::get('/{result}/view', [\App\Http\Controllers\Admin\CertificateController::class, 'view'])->name('view');
        Route::get('/{result}/download', [\App\Http\Controllers\Admin\CertificateController::class, 'download'])->name('download');
        Route::post('/{result}/send', [\App\Http\Controllers\Admin\CertificateController::class, 'send'])->name('send');
        Route::delete('/{result}', [\App\Http\Controllers\Admin\CertificateController::class, 'destroy'])->name('destroy');
    });

Route::middleware('auth')
    ->prefix('admin/test-results')
    ->name('admin.webinar-test-results.')
    ->group(function () {
        Route::get('/{result}/answers-pdf', \App\Http\Controllers\Admin\WebinarTestResultPdfController::class)
            ->name('answers-pdf');
    });

Route::get('/webinar/{slug}', App\Livewire\FreeWebinarPreorder\Index::class)->name('webinar.preorder');
Route::get('/free-webinars', \App\Livewire\FreeWebinar\Index::class)->name('free-webinar');
Route::get('/{slug}/show', \App\Livewire\Webinar\Show::class)->middleware('auth')->name('webinar.video.show');
Route::get('/{slug}', \App\Livewire\Webinar\Webinar::class)->name('webinar.show');
