<?php

namespace App\Services;

use App\Services\Resource\Navigation\MenuGroup;
use App\Services\Resource\Navigation\MenuItem;
use Illuminate\Support\Arr;

class Menu
{
    public function all(): array
    {
        return array_merge([
            MenuGroup::make('Administration')->group([
                MenuItem::make('Dashboard')->url(route('dashboard')),
                MenuItem::make('Test')->children([
                    MenuItem::make('Test 1')->url(route('welcome')),
                ]),
                MenuItem::make('Test 2')->url(route('welcome')),
            ]),
        ], $this->resourcefulMenus());
    }

    public function resourcefulMenus(): array
    {
        $resources = resources();

        $menus = Arr::collapse(array_column($resources, 'menus'));

        return $menus;
    }

    private function item($name, $icon = 'pi pi-circle', $url = null, $children = null): array
    {
        return [
            'label' => $name,
            'icon' => $icon,
            'url' => $url,
            'items' => ! is_null($children) ? collect($children)->map(function ($child) {
                return $this->item($child['label'], $child['icon'], $child['url'] ?? null, $child['items'] ?? null);
            }) : null,
        ];
    }
}
