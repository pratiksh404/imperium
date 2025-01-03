<?php

namespace App\Services\Resource\Navigation;

class MenuItem
{
    public string $label;

    public string $icon = 'bx bx-radio-circle';

    public string $url;

    public ?array $children;

    public $authorize = true;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public static function make(string $label): self
    {
        return new static($label);
    }

    public function authorize(bool $authorize = true): self
    {
        $this->authorize = $authorize;

        return $this;
    }

    public function url(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function child(MenuItem $child): self
    {
        $this->children[] = $child;

        return $this;
    }
}
