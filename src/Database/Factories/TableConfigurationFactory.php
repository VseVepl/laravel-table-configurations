<?php
// File: src/Database/Factories/TableConfigurationFactory.php

namespace vsent\TableConfigurations\Database\Factories;

use vsent\TableConfigurations\Models\TableConfiguration;
use Illuminate\Database\Eloquent\Factories\Factory;

class TableConfigurationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TableConfiguration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dataTypes = [
            'VARCHAR',
            'INT',
            'BIGINT',
            'BOOLEAN',
            'TEXT',
            'DATE',
            'DECIMAL',
            'ENUM'
        ];
        $dataType = $this->faker->randomElement($dataTypes);

        $lengthOrValues = null;
        if ($dataType === 'VARCHAR') {
            $lengthOrValues = (string) $this->faker->numberBetween(50, 255);
        } elseif ($dataType === 'DECIMAL') {
            $lengthOrValues = $this->faker->numberBetween(5, 10) . ',' . $this->faker->numberBetween(0, 4);
        } elseif ($dataType === 'ENUM') {
            $lengthOrValues = "'active','inactive','pending'";
        }

        return [
            'table_name' => $this->faker->word() . '_table',
            'column_name' => $this->faker->word() . '_field',
            'data_type' => $dataType,
            'length_or_values' => $lengthOrValues,
            'default_value' => ($this->faker->boolean(20) && $dataType !== 'BOOLEAN') ? $this->faker->word() : null,
            'character_collation' => in_array($dataType, ['VARCHAR', 'TEXT']) ? 'utf8mb4_unicode_ci' : null,
            'column_attributes' => $this->faker->boolean(10) ? 'UNSIGNED' : null,
            'is_nullable' => $this->faker->boolean(40),
            'index_type' => $this->faker->boolean(20) ? $this->faker->randomElement(['PRIMARY', 'UNIQUE', 'INDEX']) : null,
            'is_auto_increment' => ($dataType === 'BIGINT' && $this->faker->boolean(5)) ? true : false,
            'column_comments' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
