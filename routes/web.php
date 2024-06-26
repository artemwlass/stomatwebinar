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

Route::get('/blog', \App\Livewire\Blog\Index::class)->name('blog');
Route::get('/blog/{slug}', \App\Livewire\Blog\Post::class)->name('post');

Route::get('/account', \App\Livewire\Account\Index::class)->middleware('auth')->name('account');

Route::get('/politika-konfidentsiynosti', \App\Livewire\Politic::class)->name('politic');
Route::get('/dogovir-publichnoyi-ofereti', \App\Livewire\DogovorOferty::class)->name('dogovor');
Route::get('/payments', \App\Livewire\Payments::class)->name('payment');

Route::get('payment-form/{token}', \App\Livewire\Payment\Payment::class)->name('payment.form');

Route::get('/webinar/{slug}', App\Livewire\FreeWebinarPreorder\Index::class)->name('webinar.preorder');
Route::get('/free-webinars', \App\Livewire\FreeWebinar\Index::class)->name('free-webinar');
Route::get('/{slug}/show', \App\Livewire\Webinar\Show::class)->middleware('auth')->name('webinar.video.show');
Route::get('/{slug}', \App\Livewire\Webinar\Webinar::class)->name('webinar.show');

