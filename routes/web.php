<?php

codex/implement-partner-lead-module-9ufv7a
use App\Http\Controllers\Admin\PartnerLeadAdminController;
use App\Http\Controllers\Public\PartnerLeadController;
use Illuminate\Support\Facades\Route;

Route::get('/aracimi-kiraya-vermek-istiyorum', [PartnerLeadController::class, 'show'])
    ->name('partner.investment.show');
Route::post('/aracimi-kiraya-vermek-istiyorum', [PartnerLeadController::class, 'store'])
    ->name('partner.investment.store');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/partner-leads', [PartnerLeadAdminController::class, 'index'])->name('partner-leads.index');
    Route::get('/partner-leads/{id}', [PartnerLeadAdminController::class, 'show'])->name('partner-leads.show');
    Route::put('/partner-leads/{id}/status', [PartnerLeadAdminController::class, 'update'])->name('partner-leads.update');
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
  main
});
