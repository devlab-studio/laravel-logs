<?php

namespace Devlab\LaravelLogs;

use Devlab\LaravelLogs\Commands\ClearLogs;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelLogsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-logs')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_models_procedures_table')
            ->hasMigration('create_models_logs_table')
            ->hasCommand(ClearLogs::class);
    }

    public function boot()
    {
        parent::boot();
        // Charge migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
