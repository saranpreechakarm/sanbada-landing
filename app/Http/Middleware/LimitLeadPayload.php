<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LimitLeadPayload
{
    public function handle(Request $request, Closure $next)
    {
        abort_if((int) $request->server('CONTENT_LENGTH', 0) > 32768 || $request->allFiles(), 413);
        return $next($request);
    }
}
