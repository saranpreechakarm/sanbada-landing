<?php

use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing')->name('home');

Route::post('/lead', [LeadController::class, 'store'])
  ->name('lead.store')
  ->middleware('throttle:20,1');

Route::view('/privacy', 'privacy')->name('privacy');

Route::view('/thank-you', 'thankyou')->name('thankyou');

// ✅ เพิ่มสำหรับโหลด PDF
Route::get('/download-pdf', [LeadController::class, 'downloadPdf'])
  ->name('lead.downloadPdf');