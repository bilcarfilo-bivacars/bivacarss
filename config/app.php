<?php

return [
    'name' => env('APP_NAME', 'BivaCars'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'UTC',
    'locale' => env('APP_LOCALE', 'tr'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
    'faker_locale' => env('APP_FAKER_LOCALE', 'tr_TR'),
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
];
