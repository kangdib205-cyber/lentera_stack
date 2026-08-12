<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LenteraServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register module bindings, singletons, or configuration merging here.
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bootstrapping code for Lentera modules (events, routes, etc.)
    }
}
