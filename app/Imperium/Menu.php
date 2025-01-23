<?php

use App\Services\Resource\Navigation\MenuGroup;
use App\Services\Resource\Navigation\MenuItem;
use App\Services\Resource\Navigation\MenuResourceItem;

return [
MenuGroup::make('ADMINISTRATION')->group([
        MenuItem::make('Dashboard')->url(route('dashboard'))->icon('pi pi-home'),
        MenuResourceItem::make(\App\Imperium\Resource\RoleResource::class),
    ]),
App\Services\Resource\Navigation\MenuResourceItem::make(App\Imperium\Resource\PermissionResource::class),
];
