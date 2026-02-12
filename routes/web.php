<?php

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
});
