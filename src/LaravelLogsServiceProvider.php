<?php

namespace Devlab\LaravelLogs;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Devlab\LaravelLogs\Commands\LaravelLogsCommand;

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
            ->hasMigration('create_laravel_logs_table')
            ->hasMigration('create_laravel_logs_audits_table')
            ->hasMigration('create_models_procedures_otable')
            ->hasMigration('create_models_logs_table')
            ->hasCommand(LaravelLogsCommand::class);
    }

    public function boot()
    {
        // Charge migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Editable files to be published
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'devlab-core-files');

    }
}
