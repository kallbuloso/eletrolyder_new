<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(225); //NEW: Increase StringLength

        Gate::before(function ($user, $ability) {
            if ($user->hasRole(env('APP_SUPER_ADMIN', 'Super-admin'))) {
                return true;
            }
            return null;
        });

        Vite::prefetch(concurrency: 3);
    }
}
