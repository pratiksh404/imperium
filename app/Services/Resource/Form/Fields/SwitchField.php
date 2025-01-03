<?php

namespace App\Services\Resource\Form\Fields;

use App\Services\Resource\Form\InputField;

class SwitchField extends InputField
{
    public function __construct(string $field, string $label = null)
    {
        parent::__construct($field, $label);
    }

    /**
     * Get the type of input field.
     */
    protected function getType(): string
    {
        return 'switch';
    }
}
