<?php

namespace Devlab\LaravelLogs\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Devlab\LaravelLogs\LaravelLogs
 */
class LaravelLogs extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Devlab\LaravelLogs\LaravelLogs::class;
    }
}
