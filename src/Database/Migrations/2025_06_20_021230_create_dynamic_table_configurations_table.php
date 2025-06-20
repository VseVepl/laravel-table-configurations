<?php
// packages\vsent\TableConfigurations\src\Database\Migrations\2025_06_20_021230_create_dynamic_table_configurations_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('table_configurations', function (Blueprint $table) {
            // Primary Key
            $table->id()->comment('Auto-incrementing primary key');

            // Table and Column Identification
            $table->string('table_name', 100)->comment('Name of the table this column configuration belongs to');
            $table->string('column_name', 100)->comment('Name of the column in the associated table');

            // Column Metadata
            $table->enum('data_type', [
                'VARCHAR',
                'CHAR', // String Types
                'TINYINT',
                'SMALLINT',
                'MEDIUMINT',
                'INT',
                'BIGINT', // Integer Types
                'FLOAT',
                'DOUBLE',
                'DECIMAL', // Floating-Point & Fixed-Point Types
                'BOOLEAN', // Alias for TINYINT(1)
                'DATE',
                'TIME',
                'YEAR',
                'DATETIME',
                'TIMESTAMP', // Date & Time Types
                'TEXT',
                'TINYTEXT',
                'MEDIUMTEXT',
                'LONGTEXT', // Text Types
                'BLOB',
                'TINYBLOB',
                'MEDIUMBLOB',
                'LONGBLOB', // Binary Large Object Types
                'BINARY',
                'VARBINARY', // Binary String Types
                'ENUM',
                'SET', // Special String Types
                'JSON', // JSON Document Type
                // Add other less common types if absolutely necessary for your use case, e.g., GEOMETRY, POINT etc.
            ])->comment('The MySQL data type for the column (e.g., VARCHAR, INT, ENUM, JSON)');
            $table->string('length_or_values', 100)->nullable()->comment('Length for VARCHAR/INT or enum values for ENUM types');
            $table->string('default_value', 255)->nullable()->comment('Default value for the column');
            $table->string('character_collation', 50)->nullable()->comment('Character set collation for string types');
            $table->string('column_attributes', 50)->nullable()->comment('Additional attributes (e.g., UNSIGNED, ZEROFILL)');

            // Constraints
            $table->boolean('is_nullable')->default(false)->comment('Indicates if the column allows NULL values');
            $table->string('index_type', 50)->nullable()->comment('Type of index applied to the column (e.g., PRIMARY, UNIQUE, INDEX)');
            $table->boolean('is_auto_increment')->default(false)->comment('Indicates if the column is auto-incrementing');

            // Documentation
            $table->text('column_comments')->nullable()->comment('Detailed description or purpose of the column');

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index(['table_name'], 'idx_table_name');
            $table->index(['column_name'], 'idx_column_name');
            $table->index(['data_type'], 'idx_data_type');

            // Combined index for frequently accessed pairs
            $table->index(['table_name', 'column_name'], 'idx_table_column_name');

            // Unique constraint to prevent duplicate configurations for the same column in the same table
            $table->unique(['table_name', 'column_name'], 'uq_table_column');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_configurations');
    }
};
