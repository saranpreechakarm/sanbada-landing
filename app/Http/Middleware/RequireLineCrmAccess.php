<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequireLineCrmAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return redirect()->route('crm.login');
        }
        abort_unless($request->user()->can_access_line_crm, 403);

        $response = $next($request);
        $response->headers->set('Cache-Control', 'private, no-store');
        return $response;
    }
}
