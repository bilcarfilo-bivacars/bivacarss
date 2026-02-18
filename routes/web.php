<?php

use App\Http\Controllers\Admin\CorporateLeadAdminController;
use App\Http\Controllers\Admin\CorporateLeaseController;
use App\Http\Controllers\Admin\PartnerLeadAdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\PartnerAuthController;
use App\Http\Controllers\PartnerDashboardController;
use App\Http\Controllers\Public\CorporateLeadController;
use App\Http\Controllers\Public\PartnerLeadController;
use App\Http\Controllers\PublicWeb\CorporateRentalPageController;
use Illuminate\Support\Facades\Route;

Route::get('/kurumsal-kiralama', CorporateRentalPageController::class)->name('corporate.rental');

Route::get('/kurumsal-teklif-al', [CorporateLeadController::class, 'show'])->name('public.corporate-lead.show');
Route::post('/kurumsal-teklif-al', [CorporateLeadController::class, 'store'])->name('public.corporate-lead.store');

Route::get('/aracimi-kiraya-vermek-istiyorum', [PartnerLeadController::class, 'show'])->name('partner.investment.show');
Route::post('/aracimi-kiraya-vermek-istiyorum', [PartnerLeadController::class, 'store'])->name('partner.investment.store');

Route::redirect('/', '/admin/login');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

    Route::get('/partner/login', [PartnerAuthController::class, 'showLogin'])->name('partner.login');
    Route::post('/partner/login', [PartnerAuthController::class, 'login'])->name('partner.login.submit');
});

Route::middleware(['auth', 'statusActive', 'adminOnly'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('/leadler/partner', [PartnerLeadAdminController::class, 'index'])->name('partner-leads.index');
    Route::get('/leadler/partner/{id}', [PartnerLeadAdminController::class, 'show'])->name('partner-leads.show');
    Route::post('/leadler/partner/{id}/rescore', [PartnerLeadAdminController::class, 'rescore'])->name('partner-leads.rescore');
    Route::put('/leadler/partner/{id}/status', [PartnerLeadAdminController::class, 'update'])->name('partner-leads.update');

    Route::get('/leadler/kurumsal', [CorporateLeadAdminController::class, 'index'])->name('corporate-leads.index');
    Route::get('/leadler/kurumsal/{id}', [CorporateLeadAdminController::class, 'show'])->name('corporate-leads.show');
    Route::post('/leadler/kurumsal/{id}/rescore', [CorporateLeadAdminController::class, 'rescore'])->name('corporate-leads.rescore');
    Route::post('/leadler/kurumsal/{id}/status', [CorporateLeadAdminController::class, 'updateStatus'])->name('corporate-leads.status');

    Route::get('/kurumsal-kiralamalar', [CorporateLeaseController::class, 'index'])->name('corporate-leases.index');
    Route::get('/kurumsal-kiralamalar/create', [CorporateLeaseController::class, 'create'])->name('corporate-leases.create');
    Route::post('/kurumsal-kiralamalar', [CorporateLeaseController::class, 'store'])->name('corporate-leases.store');
    Route::get('/kurumsal-kiralamalar/{corporateLease}/edit', [CorporateLeaseController::class, 'edit'])->name('corporate-leases.edit');
    Route::put('/kurumsal-kiralamalar/{corporateLease}', [CorporateLeaseController::class, 'update'])->name('corporate-leases.update');
    Route::post('/kurumsal-kiralamalar/{corporateLease}/mark-paid', [CorporateLeaseController::class, 'markPaid'])->name('corporate-leases.mark-paid');
});

Route::middleware(['auth', 'statusActive', 'partnerOnly'])->prefix('partner')->name('partner.')->group(function () {
    Route::get('/', PartnerDashboardController::class)->name('dashboard');
    Route::post('/logout', [PartnerAuthController::class, 'logout'])->name('logout');
});
