<?php

use App\Http\Controllers\Admin\CorporateLeaseController;
use App\Http\Controllers\PublicApi\CorporatePricingController;
use Illuminate\Support\Facades\Route;

Route::get('/public/corporate/pricing', CorporatePricingController::class);

Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/corporate-leases', [CorporateLeaseController::class, 'index']);
    Route::post('/corporate-leases', [CorporateLeaseController::class, 'store']);
    Route::put('/corporate-leases/{corporateLease}', [CorporateLeaseController::class, 'update']);
    Route::post('/corporate-leases/{corporateLease}/mark-paid', [CorporateLeaseController::class, 'markPaid']);
});
