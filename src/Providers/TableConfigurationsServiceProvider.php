<?php
// packages\vsent\TableConfigurations\src\Providers\TableConfigurationsServiceProvider.php
namespace vsent\TableConfigurations\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use vsent\TableConfigurations\Console\Commands\InstallCommand;
use vsent\TableConfigurations\Console\Commands\UninstallCommand;
use vsent\TableConfigurations\Models\TableConfiguration;
use vsent\TableConfigurations\Policies\TableConfigurationPolicy;
use vsent\TableConfigurations\Http\Livewire\TableConfigurations\Index;
use vsent\TableConfigurations\Http\Livewire\TableConfigurations\Create;
use vsent\TableConfigurations\Http\Livewire\TableConfigurations\Edit;
use vsent\TableConfigurations\Http\Livewire\TableConfigurations\Show;

// File: src/Providers/TableConfigurationsServiceProvider.php

class TableConfigurationsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge package configuration with application's config
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/table-configurations.php',
            'table-configurations'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Load migrations from the package
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        // Load views from the package and set namespace
        $this->loadViewsFrom(__DIR__ . '/../../../resources/views', 'table-configurations');

        // Load routes from the package
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        // Register Livewire components
        Livewire::component('table-configurations.index', Index::class);
        Livewire::component('table-configurations.create', Create::class);
        Livewire::component('table-configurations.edit', Edit::class);
        Livewire::component('table-configurations.show', Show::class);

        // Register commands if the application is running in console
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                UninstallCommand::class,
            ]);

            // Publish assets
            $this->publishes([
                __DIR__ . '/../Config/table-configurations.php' => config_path('table-configurations.php'),
            ], 'table-configurations-config');

            $this->publishes([
                __DIR__ . '/../Database/Migrations' => database_path('migrations'),
            ], 'table-configurations-migrations');

            $this->publishes([
                __DIR__ . '/../Resources/views' => resource_path('views/vendor/table-configurations'),
            ], 'table-configurations-views');

            // You can also publish assets, lang files etc.
            // $this->publishes([
            //     __DIR__.'/../../../Resources/assets' => public_path('vendor/table-configurations'),
            // ], 'table-configurations-assets');

            // $this->publishes([
            //     __DIR__.'/../Resources/lang' => resource_path('lang/vendor/table-configurations'),
            // ], 'table-configurations-lang');
        }

        // Register policies
        // Note: It's often better to register policies in the main application's AuthServiceProvider
        // However, for a self-contained package, you can register them here.
        // If your main app has a comprehensive AuthServiceProvider, you might skip this here
        // and instruct the user to add it there.
        Gate::policy(TableConfiguration::class, TableConfigurationPolicy::class);
    }
}
