<?php

namespace App\Http\Middleware;

use App\Support\Seo;
use Closure;
use Illuminate\Http\Request;

class SearchIndexing
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $public = $request->routeIs('home', 'properties.*') && $response->isSuccessful();
        if (!$public || !app(Seo::class)->canIndex()) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        }
        return $response;
    }
}
