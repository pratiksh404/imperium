<?php

namespace App\Services\Resource\Form;

class Form
{
    public bool $authorize = true;

    public string $formComponent;

    public array $fields = [];

    public array $steppers = [];

    public array $tabs = [];

    /**
     * Form authorization
     *
     * @return $this
     */
    public function authorize(bool $authorize = true)
    {
        $this->authorize = $authorize;

        return $this;
    }

    /**
     * Add a field to the form.
     *
     * @return $this
     */
    public function fields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Add a stepper to the form.
     *
     * @return $this
     */
    public function steppers(array $steppers): self
    {
        $this->steppers = $steppers;

        return $this;
    }

    /**
     * Add a tab to the form.
     *
     * @return $this
     */
    public function tabs(array $tabs): self
    {
        $this->tabs = $tabs;

        return $this;
    }
}

class Group
{
    public string $title;

    public bool $authorize = true;

    public array $fields = [];

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * Make a new stepper instance.
     *
     * @return static
     */
    public static function make(string $field)
    {
        return new static($field);
    }

    /**
     * Form authorization
     *
     * @return $this
     */
    public function authorize(bool $authorize = true)
    {
        $this->authorize = $authorize;

        return $this;
    }

    /**
     * Add a field to the form.
     *
     * @return $this
     */
    public function fields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }
}
