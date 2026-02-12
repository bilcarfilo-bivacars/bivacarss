<?php

namespace App\Providers;

use App\Services\Ai\AiClientInterface;
use App\Services\Ai\OpenAiClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AiClientInterface::class, OpenAiClient::class);
    }

    public function boot(): void
    {
    }
}
