<?php
// packages\vsent\TableConfigurations\src\Http\Resources\TableConfigurationResource.php
namespace vsent\TableConfigurations\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// File: src/Http/Resources/TableConfigurationResource.php

class TableConfigurationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
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
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
