<?php

namespace Jpu4\LaravelExtras\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jpu4\LaravelExtras\LaravelExtras
 */
class LaravelExtras extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-extras';
    }
}
