<?php

use App\Http\Controllers\Api\Admin\CorporateModelController;
use App\Http\Controllers\Api\Admin\KmPackageController;
use App\Http\Controllers\Api\Admin\PopupSettingController;
use App\Http\Controllers\Api\Admin\PriceChangeRequestController;
use App\Http\Controllers\Api\Admin\VehicleApprovalController;
use App\Http\Controllers\Api\Partner\PaymentController;
use App\Http\Controllers\Api\Partner\PriceRequestController;
use App\Http\Controllers\Api\Partner\VehicleController as PartnerVehicleController;
use App\Http\Controllers\Api\Public\DirectoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('public')->group(function () {
    Route::get('corporate/models', [DirectoryController::class, 'corporateModels']);
    Route::get('km-packages', [DirectoryController::class, 'kmPackages']);
    Route::get('vehicles/featured', [DirectoryController::class, 'featuredVehicles']);
});

Route::middleware('auth:sanctum')->prefix('partner')->group(function () {
    Route::get('vehicles', [PartnerVehicleController::class, 'index']);
    Route::post('vehicles', [PartnerVehicleController::class, 'store']);
    Route::put('vehicles/{vehicle}', [PartnerVehicleController::class, 'update']);
    Route::post('vehicles/{vehicle}/price-request', [PriceRequestController::class, 'store']);
    Route::get('payments', [PaymentController::class, 'index']);
});

Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::get('vehicles', [VehicleApprovalController::class, 'index']);
    Route::put('vehicles/{vehicle}/approve', [VehicleApprovalController::class, 'approve']);
    Route::put('vehicles/{vehicle}/reject', [VehicleApprovalController::class, 'reject']);

    Route::get('price-requests', [PriceChangeRequestController::class, 'index']);
    Route::put('price-requests/{priceRequest}/approve', [PriceChangeRequestController::class, 'approve']);
    Route::put('price-requests/{priceRequest}/reject', [PriceChangeRequestController::class, 'reject']);

    Route::get('km-packages', [KmPackageController::class, 'index']);
    Route::post('km-packages', [KmPackageController::class, 'store']);
    Route::put('km-packages/{kmPackage}', [KmPackageController::class, 'update']);
    Route::put('km-packages/{kmPackage}/toggle-active', [KmPackageController::class, 'toggle']);

    Route::get('corporate-models', [CorporateModelController::class, 'index']);
    Route::post('corporate-models', [CorporateModelController::class, 'store']);
    Route::put('corporate-models/{corporateModel}', [CorporateModelController::class, 'update']);
    Route::put('corporate-models/{corporateModel}/toggle-active', [CorporateModelController::class, 'toggle']);

    Route::get('settings/popup', [PopupSettingController::class, 'show']);
    Route::put('settings/popup', [PopupSettingController::class, 'update']);
});
