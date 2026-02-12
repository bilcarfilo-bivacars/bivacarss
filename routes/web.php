<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\PartnerAuthController;
use App\Http\Controllers\PartnerDashboardController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/login');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

    Route::get('/partner/login', [PartnerAuthController::class, 'showLogin'])->name('partner.login');
    Route::post('/partner/login', [PartnerAuthController::class, 'login'])->name('partner.login.submit');
});

Route::middleware(['auth', 'status.active', 'admin.only'])->group(function () {
    Route::get('/admin', AdminDashboardController::class)->name('admin.dashboard');
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['auth', 'status.active', 'partner.only'])->group(function () {
    Route::get('/partner', PartnerDashboardController::class)->name('partner.dashboard');
    Route::post('/partner/logout', [PartnerAuthController::class, 'logout'])->name('partner.logout');
});
