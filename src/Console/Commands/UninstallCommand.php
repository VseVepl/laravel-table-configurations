<?php

namespace vsent\TableConfigurations\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

// File: src/Console/Commands/UninstallCommand.php

class UninstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table-configurations:uninstall {--force : Force the uninstallation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall the Laravel Table Configurations package.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if ($this->option('force') || $this->confirm('This will remove all published package files and rollback migrations. Are you sure you want to proceed?')) {
            $this->info('Uninstalling Laravel Table Configurations...');

            // Get the path to the migration file that would have been published
            $migrationFilePath = database_path('migrations/' . (new \DateTime('2025-06-20 02:12:30'))->format('Y_m_d_His') . '_create_dynamic_table_configurations_table.php');
            // Use glob to find the actual migration file name, as the timestamp might vary slightly
            $migrationFiles = glob(database_path('migrations/*_create_dynamic_table_configurations_table.php'));

            if (!empty($migrationFiles)) {
                $this->info('Rolling back migrations...');
                foreach ($migrationFiles as $migrationFile) {
                    $migrationFileName = basename($migrationFile);
                    Artisan::call('migrate:rollback', [
                        '--path' => 'database/migrations/' . $migrationFileName,
                    ]);
                    $this->comment(Artisan::output());
                    File::delete($migrationFile);
                    $this->info("Deleted migration file: {$migrationFileName}");
                }
            } else {
                $this->warn('No migrations found for rollback. Skipping migration rollback.');
            }

            $this->info('Removing published configuration file...');
            $configPath = config_path('table-configurations.php');
            if (File::exists($configPath)) {
                File::delete($configPath);
                $this->info("Deleted config file: {$configPath}");
            } else {
                $this->warn('Configuration file not found. Skipping config file deletion.');
            }

            $this->info('Removing published views...');
            $viewsPath = resource_path('views/vendor/table-configurations');
            if (File::isDirectory($viewsPath)) {
                File::deleteDirectory($viewsPath);
                $this->info("Deleted views directory: {$viewsPath}");
            } else {
                $this->warn('Views directory not found. Skipping views deletion.');
            }

            $this->info('Laravel Table Configurations uninstalled successfully!');
            $this->warn('Please remember to run `composer dump-autoload` if you encountered issues, and remove `your-vendor/laravel-table-configurations` from your main composer.json.');
        } else {
            $this->info('Uninstallation cancelled.');
        }
    }
}
