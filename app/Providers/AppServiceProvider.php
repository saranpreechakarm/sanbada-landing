<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        App::setLocale('ru');
        if ($this->app->environment('production')) config(['app.debug' => false]);
        \Illuminate\Support\Facades\RateLimiter::for('lead-submissions', function (\Illuminate\Http\Request $request) {
            $phone = $request->input('whatsapp_phone');
            $country = $request->input('whatsapp_country');
            $key = is_string($phone) && is_string($country)
                ? \App\Models\Lead::normalizePhone($country, $phone) : 'invalid-'.$request->ip();
            return [
                \Illuminate\Cache\RateLimiting\Limit::perMinute(20)->by('lead-ip:'.$request->ip()),
                \Illuminate\Cache\RateLimiting\Limit::perMinutes(15, 5)->by('lead-phone:'.hash('sha256', $key)),
            ];
        });
    }
}
