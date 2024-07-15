<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->ConfigureRateLimiting();
        // Route::middleware('api')
        //     ->prefix('api/v1')
        //     ->group(base_path('routes/api.php'));

        // Route::middleware('web')
        //     ->group(base_path('routes/web.php'));       

    }

    public function ConfigureRateLimiting(){
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
