<?php
// packages\vsent\TableConfigurations\src\Tests\Feature\TableConfigurationTest.php
namespace vsent\TableConfigurations\Tests\Feature;

use Orchestra\Testbench\TestCase;
use vsent\TableConfigurations\Models\TableConfiguration;
use vsent\TableConfigurations\Providers\TableConfigurationsServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

// File: src/Tests/Feature/TableConfigurationTest.php

class TableConfigurationTest extends TestCase
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
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../Database/Migrations');
    }

    /** @test */
    public function it_can_create_a_table_configuration()
    {
        $data = TableConfiguration::factory()->make()->toArray();
        unset($data['id']); // ID is auto-incremented, not part of mass assignment

        $tableConfiguration = TableConfiguration::create($data);

        $this->assertNotNull($tableConfiguration->id);
        $this->assertDatabaseHas('table_configurations', [
            'table_name' => $data['table_name'],
            'column_name' => $data['column_name'],
            'data_type' => $data['data_type'],
        ]);
    }

    /** @test */
    public function it_can_update_a_table_configuration()
    {
        $tableConfiguration = TableConfiguration::factory()->create();
        $newName = 'updated_column_name';
        $newComment = 'This is an updated comment.';

        $tableConfiguration->update([
            'column_name' => $newName,
            'column_comments' => $newComment,
        ]);

        $this->assertDatabaseHas('table_configurations', [
            'id' => $tableConfiguration->id,
            'column_name' => $newName,
            'column_comments' => $newComment,
        ]);
    }

    /** @test */
    public function it_can_delete_a_table_configuration()
    {
        $tableConfiguration = TableConfiguration::factory()->create();

        $tableConfiguration->delete();

        $this->assertDatabaseMissing('table_configurations', [
            'id' => $tableConfiguration->id,
        ]);
    }
}
