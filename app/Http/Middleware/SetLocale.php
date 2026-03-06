<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // ✅ ใช้ segment แรก: /ru/... หรือ /en/...
        $locale = $request->segment(1);

        if (!in_array($locale, ['ru', 'en'])) {
            $locale = config('app.locale', 'ru');
        }

        App::setLocale($locale);

        return $next($request);
    }
}