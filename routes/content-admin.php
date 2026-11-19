<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminContentController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminLeadController;
use App\Http\Middleware\RequireContentAccess;
use App\Http\Middleware\AuthenticateContentSession;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/login', 'admin.login')->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1')->name('login.submit');
    Route::get('/setup', [AdminAuthController::class, 'setup'])->middleware(['signed', 'throttle:5,1'])->name('setup');
    Route::post('/setup', [AdminAuthController::class, 'storeSetup'])->middleware(['signed', 'throttle:5,1'])->name('setup.store');
    Route::middleware([RequireContentAccess::class, AuthenticateContentSession::class])->group(function () {
        Route::get('/', [AdminContentController::class, 'dashboard'])->name('dashboard');
        Route::get('/leads/dashboard', [AdminLeadController::class, 'dashboard'])->name('leads.dashboard');
        Route::get('/leads/export', [AdminLeadController::class, 'export'])->middleware('throttle:10,1')->name('leads.export');
        Route::get('/leads', [AdminLeadController::class, 'index'])->name('leads.index');
        Route::get('/leads/{lead}', [AdminLeadController::class, 'show'])->name('leads.show');
        Route::patch('/leads/{lead}', [AdminLeadController::class, 'update'])->name('leads.update');
        Route::get('/projects', [AdminContentController::class, 'projects'])->name('projects.index');
        Route::get('/projects/create', [AdminContentController::class, 'createProject'])->name('projects.create');
        Route::post('/projects', [AdminContentController::class, 'storeProject'])->name('projects.store');
        Route::get('/projects/{project}/edit', [AdminContentController::class, 'editProject'])->name('projects.edit');
        Route::put('/projects/{project}', [AdminContentController::class, 'updateProject'])->name('projects.update');
        Route::delete('/projects/{project}', [AdminContentController::class, 'destroyProject'])->name('projects.destroy');
        Route::post('/projects/{project}/restore', [AdminContentController::class, 'restoreProject'])->withTrashed()->name('projects.restore');
        Route::get('/videos', [AdminContentController::class, 'videos'])->name('videos.index');
        Route::get('/videos/create', [AdminContentController::class, 'createVideo'])->name('videos.create');
        Route::post('/videos', [AdminContentController::class, 'storeVideo'])->name('videos.store');
        Route::get('/videos/{video}/edit', [AdminContentController::class, 'editVideo'])->name('videos.edit');
        Route::put('/videos/{video}', [AdminContentController::class, 'updateVideo'])->name('videos.update');
        Route::delete('/videos/{video}', [AdminContentController::class, 'destroyVideo'])->name('videos.destroy');
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::put('/password', [AdminUserController::class, 'password'])->name('password');
        Route::view('/guide', 'admin.guide')->name('guide');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});
