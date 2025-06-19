<?php

namespace Merlion\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'merlion:install';
    protected $description = 'Install admin panel';

    public function handle(): void
    {
        $this->call('vendor:publish', [
            '--tag'   => 'merlion-assets',
            '--force' => true,
        ]);
    }
}
