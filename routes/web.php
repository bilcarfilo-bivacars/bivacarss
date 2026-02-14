<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PartnerDashboardController;

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\PartnerAuthController;

use App\Http\Controllers\Public\PartnerLeadController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Admin\PartnerLeadAdminController;

use App\Http\Controllers\PublicWeb\CorporateRentalPageController;
use App\Http\Controllers\Admin\CorporateLeaseController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

// Corporate rental public page
Route::get('/kurumsal-kiralama', CorporateRentalPageController::class)->name('corporate.rental');

// Partner investment / lead page (Ahmet-Hasan)
Route::get('/aracimi-kiraya-vermek-istiyorum', [PartnerLeadController::class, 'show'])
    ->name('partner.investment.show');

Route::post('/aracimi-kiraya-vermek-istiyorum', [PartnerLeadController::class, 'store'])
    ->name('partner.investment.store');

Route::get('/iletisim', [ContactController::class, 'show'])->name('public.contact');


/*
|--------------------------------------------------------------------------
| Auth pages (guest)
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/admin/login');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

    Route::get('/partner/login', [PartnerAuthController::class, 'showLogin'])->name('partner.login');
    Route::post('/partner/login', [PartnerAuthController::class, 'login'])->name('partner.login.submit');
});


/*
|--------------------------------------------------------------------------
| Admin area
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'status.active', 'admin.only'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Partner leads (admin)
    Route::get('/partner-leads', [PartnerLeadAdminController::class, 'index'])->name('partner-leads.index');
    Route::get('/partner-leads/{id}', [PartnerLeadAdminController::class, 'show'])->name('partner-leads.show');
    Route::put('/partner-leads/{id}/status', [PartnerLeadAdminController::class, 'update'])->name('partner-leads.update');

    // Corporate leases (admin)
    Route::get('/kurumsal-kiralamalar', [CorporateLeaseController::class, 'index'])->name('corporate-leases.index');
    Route::get('/kurumsal-kiralamalar/create', [CorporateLeaseController::class, 'create'])->name('corporate-leases.create');
    Route::post('/kurumsal-kiralamalar', [CorporateLeaseController::class, 'store'])->name('corporate-leases.store');
    Route::get('/kurumsal-kiralamalar/{corporateLease}/edit', [CorporateLeaseController::class, 'edit'])->name('corporate-leases.edit');
    Route::put('/kurumsal-kiralamalar/{corporateLease}', [CorporateLeaseController::class, 'update'])->name('corporate-leases.update');
    Route::post('/kurumsal-kiralamalar/{corporateLease}/mark-paid', [CorporateLeaseController::class, 'markPaid'])->name('corporate-leases.mark-paid');
});


/*
|--------------------------------------------------------------------------
| Partner area
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'status.active', 'partner.only'])->prefix('partner')->name('partner.')->group(function () {
    Route::get('/', PartnerDashboardController::class)->name('dashboard');
    Route::post('/logout', [PartnerAuthController::class, 'logout'])->name('logout');
});

