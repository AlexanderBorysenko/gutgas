<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SeoEndpoint;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/admin.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/ajax.php';

Route::post('/mail/consultation', [MailController::class, 'consultationMail'])->name('consultationMail');
Route::post('/mail/requestCall', [MailController::class, 'requestCallMail'])->name('requestCallMail');

Route::prefix('{locale?}')->middleware(['urlLocaleHandler', 'shareSeoEntityBreadcrumbs'])->group(function () {
    Route::get('/checkout', CheckoutController::class)->name('checkout');


    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');

    Route::get('/thank-you', function () {
        return Inertia::render('ThankYou')->with('thankYouTranslations', trans('thank-you'));
    })->name('thankYou');

    Route::get('/{route?}', SeoEndpoint::class)->where('route', '.*')->name('seo-entity');
});
