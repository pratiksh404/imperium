<?php

namespace App\Services\Resource\Form\Fields;

use App\Services\Resource\Form\InputField;
use Illuminate\Support\Collection;

class SelectField extends InputField
{
    public array $options = [];

    public bool $checkmark = true;

    public bool $highlightOnSelect = false;

    public bool $showClear = false;

    public bool $searchable = true;

    public string $dropdownIcon;

    public string $header;

    public bool $multiple = false;

    public function __construct(string $field, string $label = null)
    {
        parent::__construct($field, $label);
    }

    /**
     * Get the type of input field.
     */
    protected function getType(): string
    {
        return 'select';
    }

    /**
     * Prepare options for select.
     */
    public function options(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Prepare options from collection for select.
     */
    public function optionCollection(Collection $collection, $label, $value, string $icon = null, string $image = null)
    {
        $this->options = $collection->map(function ($data) use ($value, $label, $icon, $image) {
            $value = $data->$value;
            $label = $data->$label;
            $icon = ! is_null($icon) ? $data->$icon : null;
            $image = ! is_null($image) ? $data->$image : null;

            return SelectOption::make($value, $label)
                ->icon($icon)
                ->image($image)->toArray();
        })->toArray();

        return $this;
    }

    /**
     * Set checkmark for the select.
     */
    public function checkmark(bool $checkmark = true)
    {
        $this->checkmark = $checkmark;
        $this->highlightOnSelect = false;

        return $this;
    }

    /**
     * Set highlightOnSelect for the select.
     */
    public function highlightOnSelect(bool $highlightOnSelect = true)
    {
        $this->highlightOnSelect = $highlightOnSelect;
        $this->checkmark = false;

        return $this;
    }

    /**
     * Set showClear for the select.
     */
    public function showClear(bool $showClear = true)
    {
        $this->showClear = $showClear;

        return $this;
    }

    /**
     * Set searchable for the select.
     */
    public function searchable(bool $searchable = true)
    {
        $this->searchable = $searchable;

        return $this;
    }

    /**
     * Set dropdownIcon for the select.
     */
    public function dropdownIcon(string $dropdownIcon)
    {
        $this->dropdownIcon = $dropdownIcon;

        return $this;
    }

    /**
     * Set header for the select.
     */
    public function header(string $header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Set multiple for the select.
     */
    public function multiple(bool $multiple = true)
    {
        $this->multiple = $multiple;

        return $this;
    }
}

class SelectOption
{
    public $value;

    public $label;

    public $icon;

    public $image;

    public $selected;

    public function __construct($value, $label)
    {
        $this->value = $value;
        $this->label = $label;
    }

    /**
     * Make a new select option instance.
     *
     * @return static
     */
    public static function make($value, $label)
    {
        return new static($value, $label);
    }

    /**
     * Set icon for the option.
     *
     * @return $this
     */
    public function icon(string $icon = null)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Set image for the option.
     *
     * @return $this
     */
    public function image(string $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Set selected for the option.
     *
     * @return $this
     */
    public function selected(bool $selected = true)
    {
        $this->selected = $selected;

        return $this;
    }

    /**
     * To Array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'value' => $this->value,
            'label' => $this->label,
            'icon' => $this->icon,
            'image' => $this->image,
            'selected' => $this->selected,
        ];
    }
}