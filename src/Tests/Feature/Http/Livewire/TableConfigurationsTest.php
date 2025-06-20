<?php
// packages\vsent\TableConfigurations\src\Tests\Feature\Http\Livewire\TableConfigurationsTest.php
namespace vsent\TableConfigurations\Tests\Feature\Http\Livewire;

use Orchestra\Testbench\TestCase;
use vsent\TableConfigurations\Models\TableConfiguration;
use vsent\TableConfigurations\Providers\TableConfigurationsServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Models\User; // Assuming your application's User model

// File: src/Tests/Feature/Http/Livewire/TableConfigurationsTest.php

class TableConfigurationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app)
    {
        return [
            TableConfigurationsServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        // Set up a dummy user model for testing authorization
        $app['config']->set('auth.providers.users.model', User::class);
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../../Database/Migrations');
        // Ensure User model table exists for authentication if needed
        if (!Schema::hasTable('users')) {
            $this->artisan('make:migration', ['name' => 'create_users_table', '--path' => 'database/migrations']);
            (new \CreateUsersTable)->up(); // Run the migration manually
        }
    }

    /** @test */
    public function table_configurations_index_page_loads_and_shows_configurations()
    {
        $user = User::factory()->create();
        TableConfiguration::factory()->count(5)->create();

        Livewire::actingAs($user)
            ->test(\vsent\TableConfigurations\Http\Livewire\TableConfigurations\Index::class)
            ->assertStatus(200)
            ->assertSee(TableConfiguration::first()->table_name);
    }

    /** @test */
    public function table_configurations_create_form_can_create_new_configuration()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(\vsent\TableConfigurations\Http\Livewire\TableConfigurations\Create::class)
            ->set('table_name', 'new_table')
            ->set('column_name', 'new_column')
            ->set('data_type', 'VARCHAR')
            ->set('length_or_values', '255')
            ->call('createTableConfiguration')
            ->assertRedirect(route('table-configurations.index'));

        $this->assertDatabaseHas('table_configurations', [
            'table_name' => 'new_table',
            'column_name' => 'new_column',
            'data_type' => 'VARCHAR',
        ]);
    }

    /** @test */
    public function table_configurations_edit_form_can_update_existing_configuration()
    {
        $user = User::factory()->create();
        $config = TableConfiguration::factory()->create();

        Livewire::actingAs($user)
            ->test(\vsent\TableConfigurations\Http\Livewire\TableConfigurations\Edit::class, ['tableConfiguration' => $config])
            ->set('column_name', 'updated_column')
            ->set('column_comments', 'Updated comments for test')
            ->call('updateTableConfiguration')
            ->assertRedirect(route('table-configurations.index'));

        $this->assertDatabaseHas('table_configurations', [
            'id' => $config->id,
            'column_name' => 'updated_column',
            'column_comments' => 'Updated comments for test',
        ]);
    }

    /** @test */
    public function table_configurations_can_be_deleted()
    {
        $user = User::factory()->create();
        $config = TableConfiguration::factory()->create();

        Livewire::actingAs($user)
            ->test(\vsent\TableConfigurations\Http\Livewire\TableConfigurations\Index::class)
            ->call('delete', $config->id);

        $this->assertDatabaseMissing('table_configurations', [
            'id' => $config->id,
        ]);
    }

    /** @test */
    public function table_configurations_index_page_can_be_searched()
    {
        $user = User::factory()->create();
        TableConfiguration::factory()->create(['table_name' => 'invoice_table', 'column_name' => 'invoice_id']);
        TableConfiguration::factory()->create(['table_name' => 'order_table', 'column_name' => 'order_id']);

        Livewire::actingAs($user)
            ->test(\vsent\TableConfigurations\Http\Livewire\TableConfigurations\Index::class)
            ->set('search', 'invoice')
            ->assertSee('invoice_table')
            ->assertDontSee('order_table');
    }
}
