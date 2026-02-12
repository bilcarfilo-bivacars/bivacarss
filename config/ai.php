<?php

return [
    'provider' => env('AI_PROVIDER', 'openai'),
    'default_model' => env('AI_DEFAULT_MODEL', 'gpt-4.1-mini'),
    'temperature' => (float) env('AI_TEMPERATURE', 0.7),
    'max_tokens' => (int) env('AI_MAX_TOKENS', 1200),
    'timeout' => (int) env('AI_TIMEOUT', 20),
    'retry_times' => (int) env('AI_RETRY_TIMES', 2),
    'retry_sleep_ms' => (int) env('AI_RETRY_SLEEP_MS', 300),

    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
    ],
];
