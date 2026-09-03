<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExtendTokenOnUse
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $token = $user->currentAccessToken();
        $token->forceFill([
            'expires_at' => now()->addMinutes(15),
        ])->save();
        return $next($request);
    }
}