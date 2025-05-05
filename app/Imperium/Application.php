<?php

namespace App\Imperium;

use Pratiksh\Imperium\Services\Control\Header\Header;
use Pratiksh\Imperium\Services\Control\Header\Navigation\HeaderNavigation;
use Pratiksh\Imperium\Services\Control\Imperium;
use Pratiksh\Imperium\Services\Control\Menu;
use Pratiksh\Imperium\Services\Control\Sidebar;
use Pratiksh\Imperium\Services\Resource\Navigation\MenuGroup;
use Pratiksh\Imperium\Services\Resource\Navigation\MenuItem;
use Pratiksh\Imperium\Services\Resource\Navigation\MenuResourceItem;

class Application extends Imperium
{
    const HOME = 'dashboard';

    const THEME_SWITCHER = true;

    public function menu(): Menu
    {
        return Menu::make([
            MenuGroup::make('ADMINISTRATION')->group([
                MenuItem::make('Dashboard')->icon('home')
                    ->children([
                        MenuItem::make('Test')->url(route('welcome'))->icon('home')->children([
                            MenuItem::make('Dashboard')->url(route('dashboard'))->icon('home')->badge('2'),
                        ]),
                        MenuItem::make('Dashboard')->url(route('dashboard'))->icon('home')->badge('2'),
                    ]),
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
                        MenuItem::make('Migration Generator')->icon('pi pi-database')->url(route('dev-tools.migration-generator'))->authorize(env('APP_ENV') === 'local'),
                        MenuItem::make('Documentation')->children([
                            MenuItem::make('PrimeVue')->url('https://primevue.org/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                            MenuItem::make('Vue')->url('https://vuejs.org/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                            MenuItem::make('Laravel')->url('https://laravel.com/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                            MenuItem::make('Inertia')->url('https://inertiajs.com')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                        ])->type(MenuItem::URL),
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
