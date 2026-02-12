<?php

use App\Http\Controllers\Admin\AdminMaintenanceController;
use App\Http\Controllers\Admin\AdminReferralController;
use App\Http\Controllers\Partner\PartnerGpsController;
use App\Http\Controllers\Partner\PartnerMaintenanceController;
use App\Http\Controllers\Partner\PartnerReferralController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:partner'])->prefix('partner')->name('partner.')->group(function () {
    Route::get('gps', [PartnerGpsController::class, 'index'])->name('gps.index');
    Route::get('bakim-takibi', [PartnerMaintenanceController::class, 'index'])->name('maintenance.index');

    Route::get('referral', [PartnerReferralController::class, 'index'])->name('referral.index');
    Route::post('referral', [PartnerReferralController::class, 'store'])->name('referral.store');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('bakim-takibi', [AdminMaintenanceController::class, 'index'])->name('maintenance.index');
    Route::post('bakim-takibi', [AdminMaintenanceController::class, 'store'])->name('maintenance.store');
    Route::patch('bakim-takibi/{record}/done', [AdminMaintenanceController::class, 'markDone'])->name('maintenance.done');

    Route::get('referral-talepleri', [AdminReferralController::class, 'index'])->name('referrals.index');
    Route::put('referral-talepleri/{claim}/approve', [AdminReferralController::class, 'approve'])->name('referrals.approve');
    Route::put('referral-talepleri/{claim}/reject', [AdminReferralController::class, 'reject'])->name('referrals.reject');
});
