<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Admin\CorporateLeaseController;
use App\Http\Controllers\Api\Admin\DashboardApiController;
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

    Route::middleware(['auth:sanctum', 'statusActive'])->group(function () {
        Route::post('/logout', [ApiAuthController::class, 'logout']);
        Route::get('/me', [ApiAuthController::class, 'me']);
    });
});

/*
|--------------------------------------------------------------------------
| Admin (Sanctum)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth:sanctum', 'statusActive', 'adminOnly'])->group(function () {
    Route::get('/corporate-leases', [CorporateLeaseController::class, 'index']);
    Route::post('/corporate-leases', [CorporateLeaseController::class, 'store']);
    Route::put('/corporate-leases/{corporateLease}', [CorporateLeaseController::class, 'update']);
    Route::post('/corporate-leases/{corporateLease}/mark-paid', [CorporateLeaseController::class, 'markPaid']);
    Route::get('/dashboard/metrics', [DashboardApiController::class, 'metrics']);
    Route::get('/dashboard/recent-leads', [DashboardApiController::class, 'recentLeads']);
    Route::get('/dashboard/recent-leases', [DashboardApiController::class, 'recentLeases']);
});
