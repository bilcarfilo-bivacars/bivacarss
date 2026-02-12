<?php

use Illuminate\Support\Facades\Route;

Route::post('/auth/login', fn () => response()->noContent())->middleware('throttle:login-attempts');

Route::middleware(['auth:sanctum', 'throttle:ai-generate'])->group(function () {
    Route::post('/admin/ai/generate', fn () => response()->json(['status' => 'ok']));
});
