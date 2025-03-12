<?php

namespace App\Services\Generator\SchemaResource;

class DatabaseSchema
{
    public string $driver_name;

    public function __construct()
    {
        $this->driver_name = getDatabaseDriverName();
    }
}
