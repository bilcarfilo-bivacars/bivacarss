<?php

use App\Http\Controllers\Admin\SeoPageAdminController;
use App\Http\Controllers\Admin\ServiceAreaAdminController;
use App\Http\Controllers\Public\ServiceAreaController;
use App\Http\Controllers\Public\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/hizmet-bolgeleri', [ServiceAreaController::class, 'index'])->name('service-areas.index');
Route::get('/hizmet-bolgeleri/{citySlug}', [ServiceAreaController::class, 'city'])->name('service-areas.city');
Route::get('/hizmet-bolgeleri/{citySlug}/{districtSlug}', [ServiceAreaController::class, 'district'])->name('service-areas.district');
Route::get('/hizmet-bolgeleri/{citySlug}/{districtSlug}/{pointSlug}', [ServiceAreaController::class, 'point'])->name('service-areas.point');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap.xml');

Route::middleware(['auth', 'adminOnly'])->prefix('admin')->group(function () {
    Route::get('/hizmet-bolgeleri', [ServiceAreaAdminController::class, 'index'])->name('admin.service-areas.index');
    Route::post('/hizmet-bolgeleri/city', [ServiceAreaAdminController::class, 'storeCity'])->name('admin.service-areas.city.store');
    Route::post('/hizmet-bolgeleri/district', [ServiceAreaAdminController::class, 'storeDistrict'])->name('admin.service-areas.district.store');
    Route::post('/hizmet-bolgeleri/point', [ServiceAreaAdminController::class, 'storePoint'])->name('admin.service-areas.point.store');
    Route::patch('/hizmet-bolgeleri/city/{city}/toggle', [ServiceAreaAdminController::class, 'toggleCity'])->name('admin.service-areas.city.toggle');
    Route::patch('/hizmet-bolgeleri/district/{district}/toggle', [ServiceAreaAdminController::class, 'toggleDistrict'])->name('admin.service-areas.district.toggle');
    Route::patch('/hizmet-bolgeleri/point/{point}/toggle', [ServiceAreaAdminController::class, 'togglePoint'])->name('admin.service-areas.point.toggle');

    Route::get('/seo-sayfalari', [SeoPageAdminController::class, 'index'])->name('admin.seo-pages.index');
    Route::post('/seo-sayfalari', [SeoPageAdminController::class, 'store'])->name('admin.seo-pages.store');
});
