<?php

use App\Http\Middleware\AdminOnly;
use App\Http\Middleware\PartnerOnly;
use App\Http\Middleware\StatusActive;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'status.active' => StatusActive::class,
            'admin.only' => AdminOnly::class,
            'partner.only' => PartnerOnly::class,
            'statusActive' => StatusActive::class,
            'adminOnly' => AdminOnly::class,
            'partnerOnly' => PartnerOnly::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
