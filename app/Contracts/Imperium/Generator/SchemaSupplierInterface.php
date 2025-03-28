<?php

namespace App\Contracts\Imperium\Generator;

interface SchemaSupplierInterface
{

    public function __construct(string $table_name);

    public function columns(): array;

    public function tableName(): string;
}
