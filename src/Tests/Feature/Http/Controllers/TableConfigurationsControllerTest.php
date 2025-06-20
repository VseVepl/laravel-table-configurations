<?php
// packages\vsent\TableConfigurations\src\Tests\Feature\Http\Controllers\TableConfigurationsControllerTest.php
namespace vsent\TableConfigurations\Tests\Feature\Http\Controllers;

use Orchestra\Testbench\TestCase;
use vsent\TableConfigurations\Models\TableConfiguration;
use vsent\TableConfigurations\Providers\TableConfigurationsServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User; // Assuming your application's User model

// File: src/Tests/Feature/Http/Controllers/TableConfigurationsControllerTest.php

class TableConfigurationsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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
    public function it_can_store_a_table_configuration_via_api()
    {
        $user = User::factory()->create(); // Create a user for authentication

        $data = TableConfiguration::factory()->make()->toArray();
        unset($data['id']); // ID is auto-incremented, not part of mass assignment
        unset($data['created_at']);
        unset($data['updated_at']);

        $response = $this->actingAs($user)->postJson(route('table-configurations.store'), $data);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'message' => 'Table configuration created successfully.',
                'table_name' => $data['table_name'],
                'column_name' => $data['column_name'],
            ]);

        $this->assertDatabaseHas('table_configurations', [
            'table_name' => $data['table_name'],
            'column_name' => $data['column_name'],
        ]);
    }

    /** @test */
    public function it_can_update_a_table_configuration_via_api()
    {
        $user = User::factory()->create();
        $tableConfiguration = TableConfiguration::factory()->create();
        $updatedData = [
            'column_name' => 'new_column_name',
            'column_comments' => 'Updated comment for the column.',
            'is_nullable' => true,
        ];

        $response = $this->actingAs($user)->putJson(route('table-configurations.update', $tableConfiguration), $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Table configuration updated successfully.',
                'column_name' => $updatedData['column_name'],
            ]);

        $this->assertDatabaseHas('table_configurations', [
            'id' => $tableConfiguration->id,
            'column_name' => $updatedData['column_name'],
            'column_comments' => $updatedData['column_comments'],
            'is_nullable' => $updatedData['is_nullable'],
        ]);
    }

    /** @test */
    public function it_can_delete_a_table_configuration_via_api()
    {
        $user = User::factory()->create();
        $tableConfiguration = TableConfiguration::factory()->create();

        $response = $this->actingAs($user)->deleteJson(route('table-configurations.destroy', $tableConfiguration));

        $response->assertStatus(200)
            ->assertJson(['message' => 'Table configuration deleted successfully.']);

        $this->assertDatabaseMissing('table_configurations', [
            'id' => $tableConfiguration->id,
        ]);
    }
}
