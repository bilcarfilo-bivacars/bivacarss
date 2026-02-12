<?php

use App\Http\Controllers\Admin\CorporateLeaseController;
use App\Http\Controllers\PublicWeb\CorporateRentalPageController;
use Illuminate\Support\Facades\Route;

Route::get('/kurumsal-kiralama', CorporateRentalPageController::class)->name('corporate.rental');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/kurumsal-kiralamalar', [CorporateLeaseController::class, 'index'])->name('admin.corporate-leases.index');
    Route::get('/kurumsal-kiralamalar/create', [CorporateLeaseController::class, 'create'])->name('admin.corporate-leases.create');
    Route::get('/kurumsal-kiralamalar/{corporateLease}/edit', [CorporateLeaseController::class, 'edit'])->name('admin.corporate-leases.edit');
});
