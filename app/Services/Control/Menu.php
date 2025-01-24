<?php

namespace App\Services\Control;

class Menu
{
    public array $items = [];

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public static function make(array $items): self
    {
        return new static($items);
    }
}
