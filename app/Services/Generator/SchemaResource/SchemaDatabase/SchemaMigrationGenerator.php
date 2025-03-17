<?php

namespace App\Services\Generator\SchemaResource\SchemaDatabase;

use Exception;
use Illuminate\Support\Str;
use App\Services\Generator\Generator;
use App\Contracts\Imperium\Generator\GeneratorInterface;

class SchemaMigrationGenerator extends Generator implements GeneratorInterface
{
    public string $table_name;
    public string $migration_schemas;
    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->table_name = strtolower(Str::plural($name));
    }

    public function schemas(string $migration_schemas)
    {
        $this->migration_schemas = $migration_schemas;
        return $this;
    }

    public function generate()
    {
        if (!migrationExistsForTable($this->table_name)) {
            $template = str_replace(
                [
                    '{{tableName}}',
                    '{{migrationSchemas}}'
                ],
                [
                    $this->table_name,
                    $this->migration_schemas
                ],
                $this->getStub('ImperiumMigration'),
            );
            return $this->makeFile(database_path('migrations/' . date('Y_m_d_His') . '_create_' . $this->table_name . '_table.php'), $template);
        } else {
            throw new Exception('Migration file already exists for table ' . $this->table_name);
        }
    }
}
