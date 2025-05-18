<?php

namespace Jpu4\LaravelExtras\Providers;

use Illuminate\Support\ServiceProvider;
use Jpu4\LaravelExtras\Console\MakeCrud;
use Jpu4\LaravelExtras\Console\PublishAllCommand;

class ExtrasServiceProvider extends ServiceProvider
{
    /**
     * The providers to register.
     *
     * @var array
     */
    protected $providers = [
        LaravelExtrasServiceProvider::class,
    ];

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/laravel-extras.php', 'laravel-extras'
        );

        $this->registerProviders();
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerPublishing();
    }

    /**
     * Register the package's commands.
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeCrud::class,
                PublishAllCommand::class,
            ]);
        }
    }

    /**
     * Register the package's publishable resources.
     */
    protected function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            // Publish config
            $this->publishes([
                __DIR__.'/../../config/laravel-extras.php' => config_path('laravel-extras.php'),
            ], 'laravel-extras-config');

            // Publish stubs
            $this->publishes([
                __DIR__.'/../stubs/' => resource_path('stubs/vendor/laravel-extras'),
            ], 'laravel-extras-stubs');
        }
    }

    /**
     * Register the service providers.
     *
     * @return void
     */
    protected function registerProviders(): void
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }
}