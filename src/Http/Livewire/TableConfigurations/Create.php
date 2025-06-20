<?php
// packages\vsent\TableConfigurations\src\Http\Livewire\TableConfigurations\Create.php
namespace vsent\TableConfigurations\Http\Livewire\TableConfigurations;

use Livewire\Component;
use vsent\TableConfigurations\Models\TableConfiguration;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

// File: src/Http/Livewire/TableConfigurations/Create.php

class Create extends Component
{
    use AuthorizesRequests;

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
     * Mount the component.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->authorize('create', TableConfiguration::class);
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
                // Unique check for table_name and column_name combination
                Rule::unique('table_configurations')->where(function ($query) {
                    return $query->where('table_name', $this->table_name)
                        ->where('column_name', $this->column_name);
                }),
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
     * Create a new table configuration.
     */
    public function createTableConfiguration(): void
    {
        $this->authorize('create', TableConfiguration::class);

        $this->validate();

        try {
            TableConfiguration::create([
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

            session()->flash('message', 'Table configuration created successfully.');
            $this->redirect(route('table-configurations.index'), navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error creating table configuration: ' . $e->getMessage());
        }
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render(): \Illuminate\View\View
    {
        return view('table-configurations::livewire.table-configurations.create');
    }
}
