<?php

namespace App\Services\Resource\Navigation;

class MenuGroup
{
    public string $label;

    public ?string $icon = 'pi pi-circle';

    public ?string $badge;

    public ?array $group = null;

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

    public function badge(?string $badge = null): self
    {
        $this->badge = $badge;

        return $this;
    }

    public function item(?MenuItem $child = null): self
    {
        if ($child !== null) {
            $this->group[] = $child;
        }

        return $this;
    }

    public function group(?array $group = null): self
    {
        if (! is_null($group)) {
            $this->group = $group;
        }

        return $this;
    }
}
