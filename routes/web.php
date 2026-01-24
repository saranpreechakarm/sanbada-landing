<?php

use App\Http\Controllers\LeadController;

Route::view('/', 'landing')->name('home');
Route::post('/lead', [LeadController::class, 'store'])->name('lead.store');
Route::view('/privacy', 'privacy')->name('privacy'); // политика конфиденциальности
Route::view('/thank-you', 'thankyou')->name('thankyou');

Route::post('/lead', [LeadController::class, 'store'])
  ->name('lead.store')
  ->middleware('throttle:20,1');