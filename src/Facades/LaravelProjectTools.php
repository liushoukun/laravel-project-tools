<?php

namespace Liushoukun\LaravelProjectTools\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelProjectTools extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-project-tools';
    }
}
