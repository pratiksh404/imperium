<?php

namespace App\Imperium;

use App\Services\Control\Header\Header;
use App\Services\Control\Header\Navigation\HeaderNavigation;
use App\Services\Control\Imperium;
use App\Services\Control\Menu;
use App\Services\Control\Sidebar;
use App\Services\Resource\Navigation\MenuGroup;
use App\Services\Resource\Navigation\MenuItem;
use App\Services\Resource\Navigation\MenuResourceItem;

class Application extends Imperium
{
    const HOME = 'dashboard';

    const THEME_SWITCHER = true;

    public function menu(): Menu
    {
        return Menu::make([
            MenuGroup::make('ADMINISTRATION')->group([
                MenuItem::make('Dashboard')->url(route('dashboard'))->icon('pi pi-home'),
                MenuResourceItem::make(\App\Imperium\Resource\RoleResource::class),
            ]),
        ]);
    }

    public function header(): Header
    {
        return (new Header)
            ->navigation(
                (new HeaderNavigation)
                    ->headerLinkMenus([
                        MenuItem::make('Dropdown')->children([
                            MenuItem::make('PrimeVue')->url('https://www.primefaces.org/primevue/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                            MenuItem::make('Vue')->url('https://vuejs.org/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                            MenuItem::make('Laravel')->url('https://laravel.com/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                            MenuItem::make('Inertia')->children([
                                MenuItem::make('PrimeVue')->url('https://www.primefaces.org/primevue/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                                MenuItem::make('Vue')->url('https://vuejs.org/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                                MenuItem::make('Laravel')->url('https://laravel.com/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                                MenuItem::make('test')->url('https://inertiajs.com')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                            ])->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                        ])->type(MenuItem::URL),
                        MenuItem::make('PrimeVue')->url('https://www.primefaces.org/primevue/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                        MenuItem::make('Vue')->url('https://vuejs.org/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                        MenuItem::make('Laravel')->url('https://laravel.com/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                        MenuItem::make('Inertia')->url('https://inertiajs.com')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                    ])
                    ->profileMenus([
                        MenuItem::make('Profile')->url(route('users.my-profile'))->icon('pi pi-user'),
                        MenuItem::make('Logout')->url(route('logout'))->icon('pi pi-sign-out'),
                    ])
            );
    }

    public function sidebar(): Sidebar
    {
        return new Sidebar;
    }
}
