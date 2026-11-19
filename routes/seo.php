<?php

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::prefix('{locale}')->where(['locale' => 'en|ru'])->group(function () {
    Route::get('/projects', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/condominiums', [PropertyController::class, 'index'])->name('properties.condos');
    Route::get('/villas', [PropertyController::class, 'index'])->name('properties.villas');
    Route::get('/projects/{project}/{slug}', [PropertyController::class, 'show'])->whereNumber('project')->where('slug', '[a-z0-9-]+')->name('properties.show');
});
