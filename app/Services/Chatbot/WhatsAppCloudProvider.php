<?php

namespace App\Services\Chatbot;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppCloudProvider implements ChatbotProviderInterface
{
    public function sendText(string $to, string $text): void
    {
        $token = config('services.whatsapp.token');
        $phoneNumberId = config('services.whatsapp.phone_number_id');
        $apiVersion = config('services.whatsapp.api_version', 'v19.0');

        if (! $token || ! $phoneNumberId) {
            Log::info('WhatsApp provider dev mode: message not sent because token or phone number id is missing.', [
                'to' => $to,
                'text' => $text,
            ]);

            return;
        }

        $url = sprintf('https://graph.facebook.com/%s/%s/messages', $apiVersion, $phoneNumberId);

        Http::withToken($token)
            ->post($url, [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'text',
                'text' => [
                    'body' => $text,
                ],
            ])
            ->throw();
    }
}
