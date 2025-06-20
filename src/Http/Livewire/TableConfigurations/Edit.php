<?php
// packages\vsent\TableConfigurations\src\Http\Livewire\TableConfigurations\Edit.php
namespace vsent\TableConfigurations\Http\Livewire\TableConfigurations;

use Livewire\Component;
use vsent\TableConfigurations\Models\TableConfiguration;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

// File: src/Http/Livewire/TableConfigurations/Edit.php

class Edit extends Component
{
    use AuthorizesRequests;

    public TableConfiguration $tableConfiguration;

    public string $table_name = '';
    public string $column_name = '';
    public ?string $data_type = null;
    public ?string $length_or_values = null;
    public ?string $default_value = null;
    public ?string $character_collation = null;
    public ?string $column_attributes = null;
    public bool $is_nullable = false;
    public ?string $index_type = null;
    public bool $is_auto_increment = false;
    public ?string $column_comments = null;

    // Define all possible data types based on your migration
    public array $allDataTypes = [
        'VARCHAR',
        'CHAR',
        'TINYINT',
        'SMALLINT',
        'MEDIUMINT',
        'INT',
        'BIGINT',
        'FLOAT',
        'DOUBLE',
        'DECIMAL',
        'BOOLEAN',
        'DATE',
        'TIME',
        'YEAR',
        'DATETIME',
        'TIMESTAMP',
        'TEXT',
        'TINYTEXT',
        'MEDIUMTEXT',
        'LONGTEXT',
        'BLOB',
        'TINYBLOB',
        'MEDIUMBLOB',
        'LONGBLOB',
        'JSON',
        'GEOMETRY',
        'POINT',
        'LINESTRING',
        'POLYGON',
        'ENUM',
        'SET',
        'UUID',
    ];

    /**
     * Mount the component with an existing TableConfiguration.
     *
     * @param TableConfiguration $tableConfiguration The TableConfiguration model instance.
     * @return void
     */
    public function mount(TableConfiguration $tableConfiguration): void
    {
        $this->authorize('update', $tableConfiguration);

        $this->tableConfiguration = $tableConfiguration;

        // Populate form fields with existing data
        $this->table_name = $tableConfiguration->table_name;
        $this->column_name = $tableConfiguration->column_name;
        $this->data_type = $tableConfiguration->data_type;
        $this->length_or_values = $tableConfiguration->length_or_values;
        $this->default_value = $tableConfiguration->default_value;
        $this->character_collation = $tableConfiguration->character_collation;
        $this->column_attributes = $tableConfiguration->column_attributes;
        $this->is_nullable = $tableConfiguration->is_nullable;
        $this->index_type = $tableConfiguration->index_type;
        $this->is_auto_increment = $tableConfiguration->is_auto_increment;
        $this->column_comments = $tableConfiguration->column_comments;
    }

    /**
     * Validation rules for the form fields.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'table_name' => 'required|string|max:100',
            'column_name' => [
                'required',
                'string',
                'max:100',
                // Unique check, ignoring the current record
                Rule::unique('table_configurations')->where(function ($query) {
                    return $query->where('table_name', $this->table_name)
                        ->where('column_name', $this->column_name);
                })->ignore($this->tableConfiguration->id),
            ],
            'data_type' => ['required', 'string', Rule::in($this->allDataTypes)],
            'length_or_values' => 'nullable|string|max:255',
            'default_value' => 'nullable|string|max:255',
            'character_collation' => 'nullable|string|max:50',
            'column_attributes' => 'nullable|string|max:50',
            'is_nullable' => 'boolean',
            'index_type' => 'nullable|string|max:50',
            'is_auto_increment' => 'boolean',
            'column_comments' => 'nullable|string',
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array
     */
    protected array $messages = [
        'column_name.unique' => 'The combination of table name and column name must be unique.',
    ];

    /**
     * Update the table configuration.
     */
    public function updateTableConfiguration(): void
    {
        $this->authorize('update', $this->tableConfiguration);

        $this->validate();

        try {
            $this->tableConfiguration->update([
                'table_name' => $this->table_name,
                'column_name' => $this->column_name,
                'data_type' => $this->data_type,
                'length_or_values' => $this->length_or_values,
                'default_value' => $this->default_value,
                'character_collation' => $this->character_collation,
                'column_attributes' => $this->column_attributes,
                'is_nullable' => $this->is_nullable,
                'index_type' => $this->index_type,
                'is_auto_increment' => $this->is_auto_increment,
                'column_comments' => $this->column_comments,
            ]);

            session()->flash('message', 'Table configuration updated successfully.');
            $this->redirect(route('table-configurations.index'), navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating table configuration: ' . $e->getMessage());
        }
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render(): \Illuminate\View\View
    {
        return view('table-configurations::livewire.table-configurations.edit');
    }
}
