<?php

use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

// เข้าเว็บแล้วไป /ru อัตโนมัติ
Route::redirect('/', '/ru');

// กลุ่ม route ที่มี locale prefix
Route::group([
    'prefix' => '{locale}',
    'where'  => ['locale' => 'ru|en'],
    'middleware' => ['web'], // SetLocale จะถูกใส่ใน group web จาก Kernel อีกที
], function () {

    Route::view('/', 'landing')->name('home');

    Route::post('/lead', [LeadController::class, 'store'])
        ->name('lead.store')
        ->middleware('throttle:20,1');

    Route::view('/privacy', 'privacy')->name('privacy');

    Route::view('/thank-you', 'thankyou')->name('thankyou');

    // ✅ โหลด PDF
    Route::get('/download-pdf', [LeadController::class, 'downloadPdf'])
        ->name('lead.downloadPdf');
});