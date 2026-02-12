<?php

use App\Http\Controllers\AdminModerationController;
use App\Http\Controllers\PartnerVehiclesController;
use App\Http\Controllers\PublicSiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicSiteController::class, 'home'])->name('home');
Route::get('/kurumsal-kiralama', [PublicSiteController::class, 'corporateRental'])->name('public.corporate-rental');

Route::prefix('partner')->group(function () {
    Route::get('/araclar', [PartnerVehiclesController::class, 'index'])->name('partner.vehicles.index');
    Route::get('/araclar/yeni', [PartnerVehiclesController::class, 'create'])->name('partner.vehicles.create');
    Route::get('/araclar/{id}/fiyat', [PartnerVehiclesController::class, 'priceRequest'])->name('partner.vehicles.price-request');
});

Route::prefix('admin')->group(function () {
    Route::get('/ilan-onaylari', [AdminModerationController::class, 'vehicleApprovals'])->name('admin.vehicle-approvals');
    Route::get('/fiyat-talepleri', [AdminModerationController::class, 'priceRequests'])->name('admin.price-requests');
});
