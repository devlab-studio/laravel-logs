<?php

namespace Devlab\LaravelLogs\Commands;

use Illuminate\Console\Command;

class LaravelLogsCommand extends Command
{
    public $signature = 'laravel-logs';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
