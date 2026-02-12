<?php

use App\Http\Controllers\Admin\ChatbotFlowController;
use App\Http\Controllers\Admin\ChatbotMessageController;
use App\Http\Controllers\Webhooks\WhatsAppWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/webhooks/whatsapp', [WhatsAppWebhookController::class, 'verify']);
Route::post('/webhooks/whatsapp', [WhatsAppWebhookController::class, 'receive'])->middleware('throttle:60,1');

Route::middleware(['auth', 'admin.only'])->prefix('admin/chatbot')->name('admin.chatbot.')->group(function () {
    Route::get('/', [ChatbotFlowController::class, 'index'])->name('flows.index');
    Route::patch('/flows/{flow}/toggle', [ChatbotFlowController::class, 'toggle'])->name('flows.toggle');

    Route::get('/{flow}/mesajlar', [ChatbotMessageController::class, 'index'])->name('messages.index');
    Route::post('/{flow}/mesajlar', [ChatbotMessageController::class, 'store'])->name('messages.store');
    Route::patch('/{flow}/mesajlar/{message}', [ChatbotMessageController::class, 'update'])->name('messages.update');
});
