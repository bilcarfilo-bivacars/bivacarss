<?php

namespace App\Services\Ai;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class OpenAiClient implements AiClientInterface
{
    public function generate(string $systemPrompt, string $userPrompt, array $options = []): string
    {
        $apiKey = config('ai.openai.api_key');

        if (blank($apiKey)) {
            throw new RuntimeException('OPENAI_API_KEY tanımlı değil.');
        }

        $payload = [
            'model' => $options['model'] ?? config('ai.default_model', 'gpt-4.1-mini'),
            'temperature' => $options['temperature'] ?? config('ai.temperature', 0.7),
            'max_completion_tokens' => $options['max_tokens'] ?? config('ai.max_tokens', 1200),
            'input' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userPrompt],
            ],
        ];

        try {
            $response = Http::withToken($apiKey)
                ->timeout(config('ai.timeout', 20))
                ->retry(config('ai.retry_times', 2), config('ai.retry_sleep_ms', 300))
                ->post('https://api.openai.com/v1/responses', $payload)
                ->throw();
        } catch (ConnectionException $e) {
            throw new RuntimeException('AI servisine bağlanılamadı: '.$e->getMessage(), 0, $e);
        }

        $text = data_get($response->json(), 'output.0.content.0.text');

        if (blank($text)) {
            throw new RuntimeException('AI cevabı boş döndü veya beklenen formatta değil.');
        }

        return trim($text);
    }
}
