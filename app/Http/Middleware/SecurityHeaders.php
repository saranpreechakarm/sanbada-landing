<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $admin = $request->is('admin', 'admin/*');
        $response->headers->set('X-Frame-Options', $admin ? 'DENY' : 'SAMEORIGIN');
        if ($admin) {
            $response->headers->set('Cache-Control', 'private, no-store');
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
            $response->headers->set('Referrer-Policy', 'no-referrer');
            $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' data: blob: https://i.ytimg.com; frame-src https://www.youtube-nocookie.com https://player.vimeo.com; connect-src 'self'; object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'");
        }
        return $response;
    }
}
