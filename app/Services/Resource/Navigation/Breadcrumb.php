<?php

namespace App\Services\Resource\Navigation;

class Breadcrumb
{
    public string $title;

    public string $for;

    public ?array $items;

    public ?array $points;

    public array $actions;

    public function __construct(string $title, string $for)
    {
        $this->title = $title;
        $this->for = $for;
    }

    public static function make(string $title, string $for): self
    {
        return new static($title, $for);
    }

    public function items(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function points(array $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function item(BreadcrumbItem $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    public function point(BreadcrumbPoint $point): self
    {
        $this->points[] = $point;

        return $this;
    }
}

class BreadcrumbItem
{
    public string $label;

    public string $route;

    public function __construct(string $label, string $route)
    {
        $this->label = $label;
        $this->route = $route;
    }

    public static function make(string $label, string $route): self
    {
        return new static($label, $route);
    }
}

class BreadcrumbPoint
{
    public string $information;

    public string $icon;

    public $authorize = true;

    public function __construct(string $information, ?string $icon = null)
    {
        $this->information = $information;
        $this->icon = $icon;
    }

    public static function make(string $information, ?string $icon = null): self
    {
        return new static($information, $icon);
    }

    public function authorize(bool $authorize = true): self
    {
        $this->authorize = $authorize;

        return $this;
    }
}
