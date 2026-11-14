<?php

use App\Http\Controllers\LineCrmController;
use App\Http\Controllers\LineCrmSetupController;
use App\Http\Controllers\LineWebhookController;
use App\Http\Middleware\RequireLineCrmAccess;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Route;

// Only the signed LINE endpoint is exempt from CSRF. CRM forms retain CSRF protection.
Route::post('/api/line/webhook', LineWebhookController::class)
    ->withoutMiddleware([ValidateCsrfToken::class]);

Route::view('/crm/login', 'crm.login')->name('crm.login');
Route::post('/crm/login', [LineCrmController::class, 'login'])->middleware('throttle:5,1');
Route::get('/crm/setup', [LineCrmSetupController::class, 'show'])->middleware(['signed', 'throttle:5,1'])->name('crm.setup');
Route::post('/crm/setup', [LineCrmSetupController::class, 'store'])->middleware(['signed', 'throttle:5,1']);
Route::middleware(RequireLineCrmAccess::class)->group(function () {
    Route::get('/crm', [LineCrmController::class, 'index'])->name('crm.index');
    Route::patch('/crm/customers/{customer}', [LineCrmController::class, 'update'])->name('crm.update');
    Route::post('/crm/logout', [LineCrmController::class, 'logout'])->name('crm.logout');
});
