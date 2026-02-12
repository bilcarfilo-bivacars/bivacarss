<?php

use App\Http\Controllers\Admin\CorporateOfferController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'adminOnly'])->prefix('admin')->group(function () {
    Route::get('/corporate-offers', [CorporateOfferController::class, 'index']);
    Route::post('/corporate-offers', [CorporateOfferController::class, 'store']);
    Route::post('/corporate-offers/{corporateOffer}/generate-pdf', [CorporateOfferController::class, 'generatePdf']);
    Route::post('/corporate-offers/{corporateOffer}/mark-sent', [CorporateOfferController::class, 'markSent']);
});
