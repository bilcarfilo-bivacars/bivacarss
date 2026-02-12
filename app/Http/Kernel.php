<?php

namespace App\Http;

use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'web' => [
            SecurityHeaders::class,
        ],

        'api' => [
            'throttle:api',
        ],
    ];

    protected $routeMiddleware = [
        'security.headers' => SecurityHeaders::class,
    ];
}
