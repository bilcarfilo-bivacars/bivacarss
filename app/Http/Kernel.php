<?php

namespace App\Http;

use App\Http\Middleware\AdminOnly;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareAliases = [
        'admin.only' => AdminOnly::class,
    ];
}
