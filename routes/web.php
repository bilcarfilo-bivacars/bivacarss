<?php

use App\Http\Controllers\Admin\AiContentController;
use App\Http\Controllers\Admin\AiPromptController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/blog', [AdminBlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/yeni', [AdminBlogController::class, 'create'])->name('blog.create');
    Route::post('/blog', [AdminBlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{id}/duzenle', [AdminBlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{id}', [AdminBlogController::class, 'update'])->name('blog.update');
    Route::post('/blog/{id}/publish', [AdminBlogController::class, 'publish'])->name('blog.publish');

    Route::get('/ai-icerik', [AiContentController::class, 'index'])->name('ai.generator');
    Route::post('/ai-icerik/uret', [AiContentController::class, 'generate'])->name('ai.generate');
    Route::post('/ai-icerik/taslak', [AiContentController::class, 'createDraft'])->name('ai.create-draft');

    Route::get('/ai-promptlar', [AiPromptController::class, 'index'])->name('ai-prompts.index');
    Route::post('/ai-promptlar', [AiPromptController::class, 'store'])->name('ai-prompts.store');
    Route::put('/ai-promptlar/{id}', [AiPromptController::class, 'update'])->name('ai-prompts.update');
    Route::delete('/ai-promptlar/{id}', [AiPromptController::class, 'destroy'])->name('ai-prompts.destroy');
});
