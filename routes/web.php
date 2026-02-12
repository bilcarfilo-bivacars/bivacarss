<?php

use App\Http\Controllers\Admin\CorporateOfferController;
use App\Http\Controllers\PublicOfferController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'adminOnly'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('kurumsal-teklifler', [CorporateOfferController::class, 'index'])->name('corporate-offers.index');
    Route::get('kurumsal-teklifler/yeni', [CorporateOfferController::class, 'create'])->name('corporate-offers.create');
    Route::post('kurumsal-teklifler', [CorporateOfferController::class, 'store'])->name('corporate-offers.store');
    Route::get('kurumsal-teklifler/{corporateOffer}', [CorporateOfferController::class, 'show'])->name('corporate-offers.show');
    Route::post('kurumsal-teklifler/{corporateOffer}/generate-pdf', [CorporateOfferController::class, 'generatePdf'])->name('corporate-offers.generate-pdf');
    Route::post('kurumsal-teklifler/{corporateOffer}/mark-sent', [CorporateOfferController::class, 'markSent'])->name('corporate-offers.mark-sent');
});

Route::get('/offer/{corporateOffer}/pdf', [PublicOfferController::class, 'showPdf'])
    ->middleware('signed')
    ->name('public.offer.pdf');
