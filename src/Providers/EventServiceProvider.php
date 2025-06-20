<?php
// packages\vsent\TableConfigurations\src\Providers\EventServiceProvider.php
namespace vsent\TableConfigurations\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

// File: src/Providers/EventServiceProvider.php

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the package.
     *
     * @var array
     */
    protected $listen = [
        // Example:
        // 'vsent\TableConfigurations\Events\TableConfigurationCreated' => [
        //     'vsent\TableConfigurations\Listeners\LogNewConfiguration',
        // ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
