<?php

use App\Http\Controllers\Api\Admin\AiGenerateController;
use App\Http\Controllers\Api\Admin\AiPromptApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::post('/ai/generate-blog', AiGenerateController::class);
    Route::apiResource('/ai-prompts', AiPromptApiController::class);
});
