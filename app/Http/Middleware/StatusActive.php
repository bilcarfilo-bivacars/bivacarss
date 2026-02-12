<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->status !== 'active') {
            auth()->logout();

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Hesap pasif durumda.'], 403);
            }

            return redirect()->route('admin.login')->withErrors([
                'phone' => 'Hesabınız pasif durumda.',
            ]);
        }

        return $next($request);
    }
}
