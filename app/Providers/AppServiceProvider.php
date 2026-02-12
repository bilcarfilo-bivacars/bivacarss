<?php

namespace App\Providers;

use App\Services\Chatbot\ChatbotProviderInterface;
use App\Services\Chatbot\WhatsAppCloudProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ChatbotProviderInterface::class, WhatsAppCloudProvider::class);
    }

    public function boot(): void
    {
    }
}
