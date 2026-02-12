<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PartnerOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role !== 'partner') {
            abort(403, 'Sadece partner erişebilir.');
        }

        return $next($request);
    }
}
