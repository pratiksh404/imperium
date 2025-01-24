<?php

namespace App\Imperium;

use App\Services\Resource\Navigation\MenuGroup;
use App\Services\Resource\Navigation\MenuItem;
use App\Services\Resource\Navigation\MenuResourceItem;

class Navigation
{
    public function header() {}

    public static function menu(): array
    {
        return [
            MenuGroup::make('ADMINISTRATION')->group([
                MenuItem::make('Dashboard')->url(route('dashboard'))->icon('pi pi-home'),
                MenuResourceItem::make(\App\Imperium\Resource\RoleResource::class),
            ]),

        ];
    }
}
