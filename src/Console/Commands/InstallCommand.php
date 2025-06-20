<?php

namespace vsent\TableConfigurations\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

// File: src/Console/Commands/InstallCommand.php

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table-configurations:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Laravel Table Configurations package.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Installing Laravel Table Configurations...');

        $this->info('Publishing configuration file...');
        Artisan::call('vendor:publish', [
            '--provider' => "vsent\\TableConfigurations\\Providers\\TableConfigurationsServiceProvider",
            '--tag' => "table-configurations-config",
            '--force' => true,
        ]);
        $this->comment(Artisan::output());

        $this->info('Publishing migrations...');
        Artisan::call('vendor:publish', [
            '--provider' => "vsent\\TableConfigurations\\Providers\\TableConfigurationsServiceProvider",
            '--tag' => "table-configurations-migrations",
            '--force' => true,
        ]);
        $this->comment(Artisan::output());

        $this->info('Publishing views...');
        Artisan::call('vendor:publish', [
            '--provider' => "vsent\\TableConfigurations\\Providers\\TableConfigurationsServiceProvider",
            '--tag' => "table-configurations-views",
            '--force' => true,
        ]);
        $this->comment(Artisan::output());

        $this->info('Running migrations...');
        Artisan::call('migrate');
        $this->comment(Artisan::output());

        $this->info('Laravel Table Configurations installed successfully!');
        $this->warn('Remember to review the published configuration and migrate your database if you have not already.');
    }
}
