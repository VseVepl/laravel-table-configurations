<?php
// packages\vsent\TableConfigurations\src\Http\Requests\TableConfigurationRequest.php
namespace vsent\TableConfigurations\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use vsent\TableConfigurations\Models\TableConfiguration; // Import the model

// File: src/Http/Requests/TableConfigurationRequest.php

class TableConfigurationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Authorize based on policy.
        // For 'store' (create), check against the class.
        // For 'update' or 'destroy', check against the specific model instance.
        if ($this->route('tableConfiguration')) { // For update/show/delete routes
            return Gate::allows('update', $this->route('tableConfiguration'));
        }

        // For create route
        return Gate::allows('create', TableConfiguration::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $allDataTypes = [
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

        // Determine unique rule for update vs. create
        $uniqueRule = Rule::unique('table_configurations')->where(function ($query) {
            return $query->where('table_name', $this->table_name)
                ->where('column_name', $this->column_name);
        });

        if ($this->route('tableConfiguration')) { // If updating an existing record
            $uniqueRule->ignore($this->route('tableConfiguration')->id);
        }

        return [
            'table_name' => 'required|string|max:100',
            'column_name' => [
                'required',
                'string',
                'max:100',
                $uniqueRule,
            ],
            'data_type' => ['required', 'string', Rule::in($allDataTypes)],
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
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'column_name.unique' => 'The combination of table name and column name must be unique.',
        ];
    }
}
