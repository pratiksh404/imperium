<?php

namespace App\Services;

use Illuminate\Support\Arr;

class Menu
{
    public function all(): array
    {
        return array_merge([$this->item('Dashboard', 'bx bx-home', route('dashboard'))], $this->resourcefulMenus());
    }

    public function resourcefulMenus(): array
    {
        $resources = resources();

        $menus = Arr::collapse(array_column($resources, 'menus'));

        return $menus;
    }

    private function item($name, $icon = 'bx bx-radio-circle', $url = null, $children = null): array
    {
        return [
            'label' => $name,
            'icon' => $icon,
            'url' => $url,
            'children' => ! is_null($children) ? $children->map(function ($child) {
                return $this->item($child->label, $child->icon, $child->url, $child->children);
            }) : null,
        ];
    }
}
