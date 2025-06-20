<?php
// packages\vsent\TableConfigurations\src\Routes\web.php
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use vsent\TableConfigurations\Http\Controllers\TableConfigurationsController;

// File: src/Routes/web.php

// Get route prefix and middleware from package configuration
$prefix = config('table-configurations.route_prefix', 'table-configurations');
$middleware = config('table-configurations.middleware', ['web', 'auth']);

Route::middleware($middleware)->prefix($prefix)->group(function () {

    // Volt Pages for Livewire CRUD
    Volt::route('/', vsent\TableConfigurations\Http\Livewire\TableConfigurations\Index::class)
        ->name('table-configurations.index');

    Volt::route('/create', vsent\TableConfigurations\Http\Livewire\TableConfigurations\Create::class)
        ->name('table-configurations.create');

    Volt::route('/{tableConfiguration}/edit', vsent\TableConfigurations\Http\Livewire\TableConfigurations\Edit::class)
        ->name('table-configurations.edit');

    Volt::route('/{tableConfiguration}', vsent\TableConfigurations\Http\Livewire\TableConfigurations\Show::class)
        ->name('table-configurations.show');

    // Optional: API routes or non-Livewire routes managed by the controller
    // If you only rely on Livewire, these might not be strictly necessary for the UI.
    // Route::get('/', [TableConfigurationsController::class, 'index'])->name('table-configurations.index'); // Redundant if using Volt for index
    // Route::post('/', [TableConfigurationsController::class, 'store'])->name('table-configurations.store');
    // Route::put('/{tableConfiguration}', [TableConfigurationsController::class, 'update'])->name('table-configurations.update');
    // Route::delete('/{tableConfiguration}', [TableConfigurationsController::class, 'destroy'])->name('table-configurations.destroy');
});
