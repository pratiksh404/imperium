<?php

namespace App\Services\Resource\Form;

abstract class InputField
{
    // Type
    public $type;

    // Presentation Type
    public $presentationType;

    // Sizes
    const SMALL = 'small';

    const LARGE = 'large';

    // Floated Label Type
    const FLOAT_LABEL_OVER = 'over';

    const FLOAT_LABEL_IN = 'in';

    const FLOAT_LABEL_ON = 'on';

    // Severity
    const SUCCESS = 'success';

    const WARNING = 'warning';

    const ERROR = 'error';

    const INFO = 'info';

    const DEFAULT = 'secondary';

    public string $field;

    public string $label;

    public string $placeholder;

    public bool $required = true;

    public bool $visibility = true;

    public bool $readOnly = false;

    public bool $disabled = false;

    public $size = self::SMALL;

    public string $id;

    public string $class;

    public bool $iconField = false;

    public $prefix;

    public $suffix;

    public bool $prefixIsIcon = false;

    public bool $suffixIsIcon = false;

    public bool $floatedLabel = false;

    public string $floatedLabelType = self::FLOAT_LABEL_ON;

    public bool $iftaLabel = false;

    public string $hintText;

    public string $hintColor = self::DEFAULT;

    public $value;

    /**
     * Create a new column instance.
     */
    public function __construct(string $field, string $label = null)
    {
        $this->field = $field;
        $this->label = ! is_null($label) ? $label : ucfirst($field);
        $this->class = $this->field;
        $this->id = $this->field;
        $this->placeholder = $this->label;
        $this->type = $this->getType();
    }

    /**
     * Get the type of input field (implemented by subclasses).
     */
    abstract protected function getType(): string;

    /**
     * Make a new column instance.
     *
     * @return static
     */
    public static function make(string $field, string $label = null)
    {
        return new static($field, $label);
    }

    /**
     * Set placeholder for the input field.
     *
     * @return $this
     */
    public function placeholder(string $placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Mark the input field as required.
     *
     * @return $this
     */
    public function required(bool $required = true)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Mark the input field as readonly.
     *
     * @return $this
     */
    public function readOnly(bool $readOnly = true)
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    /**
     * Mark the input field as readonly.
     *
     * @return $this
     */
    public function disabled(bool $disabled = true)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Set a default value for the input field.
     *
     * @return $this
     */
    public function value(mixed $value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Set a class for the input field.
     *
     * @return $this
     */
    public function class(string $class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Set an ID for the input field.
     *
     * @return $this
     */
    public function id(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set visibility for the input field.
     *
     * @return $this
     */
    public function visibility(bool $visibility = true)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Set size for the input field.
     *
     * @return $this
     */
    public function size(string $size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Set prefix for the input field.
     *
     * @return $this
     */
    public function prefix(string $prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Set suffix for the input field.
     *
     * @return $this
     */
    public function suffix(string $suffix)
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * Set prefix for the input field.
     *
     * @return $this
     */
    public function prefixIsIcon(bool $prefixIsIcon = true)
    {
        $this->prefixIsIcon = $prefixIsIcon;

        return $this;
    }

    /**
     * Set suffix for the input field.
     *
     * @return $this
     */
    public function suffixIsIcon(bool $suffixIsIcon = true)
    {
        $this->suffixIsIcon = $suffixIsIcon;

        return $this;
    }

    /**
     * Set floated label for the input field.
     *
     * @return $this
     */
    public function floatedLabel($floatedLabelType = self::FLOAT_LABEL_ON)
    {
        $this->floatedLabel = true;
        $this->floatedLabelType = $floatedLabelType;

        return $this;
    }

    /**
     * Set ifta label for the input field.
     *
     * @return $this
     */
    public function iftaLabel(bool $iftaLabel = true)
    {
        $this->iftaLabel = $iftaLabel;

        $this->floatedLabel = false;

        return $this;
    }

    /**
     * Set hint text for the input field.
     *
     * @return $this
     */
    public function hint(string $hintText, string $hintColor = self::DEFAULT)
    {
        $this->hintText = $hintText;

        $this->hintColor = $hintColor;

        return $this;
    }

    /**
     * Set icon for the input field.
     *
     * @return $this
     */
    public function iconField(string $prefix, string $suffix = null)
    {
        $this->iconField = true;
        $this->prefix = $prefix;
        $this->suffix = $suffix;

        $this->prefixIsIcon = true;
        $this->suffixIsIcon = true;

        return $this;
    }
}