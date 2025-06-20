<?php
// packages\vsent\TableConfigurations\src\Models\TableConfiguration.php
namespace vsent\TableConfigurations\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use vsent\TableConfigurations\Database\Factories\TableConfigurationFactory;

// File: src/Models/TableConfiguration.php

class TableConfiguration extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'table_configurations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'table_name',
        'column_name',
        'data_type',
        'length_or_values',
        'default_value',
        'character_collation',
        'column_attributes',
        'is_nullable',
        'index_type',
        'is_auto_increment',
        'column_comments',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_nullable' => 'boolean',
        'is_auto_increment' => 'boolean',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): TableConfigurationFactory
    {
        return TableConfigurationFactory::new();
    }
}
