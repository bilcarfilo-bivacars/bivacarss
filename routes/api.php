<?php

use App\Http\Controllers\Admin\AdminMaintenanceController;
use App\Http\Controllers\Admin\AdminReferralController;
use App\Http\Controllers\Partner\PartnerGpsController;
use App\Http\Controllers\Partner\PartnerMaintenanceController;
use App\Http\Controllers\Partner\PartnerReferralController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:partner'])->prefix('partner')->group(function () {
    Route::get('gps', [PartnerGpsController::class, 'apiIndex']);
    Route::get('maintenance', [PartnerMaintenanceController::class, 'apiIndex']);
    Route::post('referrals', [PartnerReferralController::class, 'apiStore']);
    Route::get('referrals', [PartnerReferralController::class, 'apiIndex']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('maintenance', [AdminMaintenanceController::class, 'apiIndex']);
    Route::post('maintenance', [AdminMaintenanceController::class, 'apiStore']);
    Route::get('maintenance/{maintenance}', [AdminMaintenanceController::class, 'apiShow']);
    Route::put('maintenance/{maintenance}', [AdminMaintenanceController::class, 'apiUpdate']);
    Route::delete('maintenance/{maintenance}', [AdminMaintenanceController::class, 'apiDestroy']);

    Route::get('referrals', [AdminReferralController::class, 'apiIndex']);
    Route::put('referrals/{id}/approve', [AdminReferralController::class, 'apiApprove']);
    Route::put('referrals/{id}/reject', [AdminReferralController::class, 'apiReject']);
});
