<?php

namespace App\Services\Generator\SchemaResource\SchemaForm\Fields;

class InputFieldMaker
{
    public array $field_info;

    public string $input_field = '\n';

    public function __construct(array $field_info)
    {
        $this->field_info = $field_info;
    }

    public static function for(array $field_info): self
    {
        return new self($field_info);
    }

    public function grab() {}
}
