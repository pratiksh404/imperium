<?php

namespace App\Services\Resource\Navigation;

class Navigation
{
    public array $menus = [];

    public array $breadcrumbs = [];

    public function menus(array $menus): self
    {
        $this->menus = $menus;

        return $this;
    }

    public function breadcrumbs(array $breadcrumbs): self
    {
        $this->breadcrumbs = $breadcrumbs;

        return $this;
    }
}
