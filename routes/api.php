<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Admin\CorporateLeaseController;
use App\Http\Controllers\PublicApi\CorporatePricingController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/public/corporate/pricing', CorporatePricingController::class);

/*
|--------------------------------------------------------------------------
| Auth (Sanctum)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('/login', [ApiAuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'status.active'])->group(function () {
        Route::post('/logout', [ApiAuthController::class, 'logout']);
        Route::get('/me', [ApiAuthController::class, 'me']);
    });
});

/*
|--------------------------------------------------------------------------
| Admin (Sanctum)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth:sanctum', 'status.active'])->group(function () {
    Route::get('/corporate-leases', [CorporateLeaseController::class, 'index']);
    Route::post('/corporate-leases', [CorporateLeaseController::class, 'store']);
    Route::put('/corporate-leases/{corporateLease}', [CorporateLeaseController::class, 'update']);
    Route::post('/corporate-leases/{corporateLease}/mark-paid', [CorporateLeaseController::class, 'markPaid']);
});
