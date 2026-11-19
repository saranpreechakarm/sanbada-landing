<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequireContentAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return redirect()->route('admin.login');
        }
        abort_unless($request->user()->can_manage_content, 403);
        $response = $next($request);
        $response->headers->set('Cache-Control', 'private, no-store');
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        return $response;
    }
}
