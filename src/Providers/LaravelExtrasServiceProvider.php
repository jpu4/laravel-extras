<?php

namespace Jpu4\LaravelExtras\Providers;

use Illuminate\Support\ServiceProvider;
use Jpu4\LaravelExtras\LaravelExtras;

class LaravelExtrasServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton('laravel-extras', function ($app) {
            return new LaravelExtras();
        });
        
        $this->app->alias('laravel-extras', LaravelExtras::class);
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['laravel-extras'];
    }
}
