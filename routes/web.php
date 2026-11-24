<?php

use App\Http\Controllers\LeadController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/line-crm.php';
require __DIR__.'/content-admin.php';
require __DIR__.'/seo.php';

// เข้าเว็บแล้วไป /ru อัตโนมัติ
Route::redirect('/', '/ru');

// Range-aware delivery also supports seeking on the local PHP development server.
Route::get('/media/sanbada/{quality}.mp4', \App\Http\Controllers\HeroVideoController::class)
    ->where('quality', '480p|720p')->name('hero.video');

// กลุ่ม route ที่มี locale prefix
Route::group([
    'prefix' => '{locale}',
    'where'  => ['locale' => 'ru|en'],
    'middleware' => ['web'], // SetLocale จะถูกใส่ใน group web จาก Kernel อีกที
], function () {

    Route::get('/', LandingController::class)->name('home');

    Route::post('/lead', [LeadController::class, 'store'])
        ->name('lead.store')
        ->middleware([\App\Http\Middleware\LimitLeadPayload::class, 'throttle:lead-submissions']);

    Route::view('/privacy', 'privacy')->name('privacy');

    Route::view('/thank-you', 'thankyou')->name('thankyou');

    // ✅ โหลด PDF
    Route::get('/download-pdf', [LeadController::class, 'downloadPdf'])
        ->name('lead.downloadPdf');
});
