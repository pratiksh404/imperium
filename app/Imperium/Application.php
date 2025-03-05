<?php

namespace App\Imperium;

use App\Services\Control\Menu;
use App\Services\Control\Sidebar;
use App\Services\Control\Imperium;
use App\Services\Control\Header\Header;
use App\Services\Resource\Navigation\MenuItem;
use App\Services\Resource\Navigation\MenuGroup;
use App\Services\Resource\Navigation\MenuResourceItem;
use App\Services\Control\Header\Navigation\HeaderNavigation;
use App\Services\Control\Header\Navigation\HeaderFlyoutMenuItem;
use App\Services\Control\Header\Navigation\HeaderFlyoutMenuItemFooter;

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
                        MenuGroup::make('ADMINISTRATION')->group([
                            MenuItem::make('Dropdown')->children([
                                MenuItem::make('A')->url('https://www.primefaces.org/primevue/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                                MenuItem::make('B')->url('https://vuejs.org/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                                MenuItem::make('C')->url('https://laravel.com/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                            ])->type(MenuItem::URL),
                        ]),
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
                        MenuItem::make('PrimeVue')->icon('pi pi-prime')->url('https://www.primefaces.org/primevue/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                        MenuItem::make('Vue')->icon('pi pi-heart')->url('https://vuejs.org/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                        MenuItem::make('Laravel')->icon('pi pi-code')->url('https://laravel.com/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                        MenuItem::make('Inertia')->icon('pi pi-crown')->url('https://inertiajs.com')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                    ])
                    ->headerFlyoutMenus([
                        HeaderFlyoutMenuItem::make('Documentation')->children([
                            MenuItem::make('PrimeVue')->icon('pi pi-prime')->url('https://www.primefaces.org/primevue/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local')
                                ->description('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Exercitationem veritatis libero ut cumque.'),
                            MenuItem::make('Vue')->icon('pi pi-heart')->url('https://vuejs.org/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local')->description('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Exercitationem veritatis libero ut cumque.'),
                            MenuItem::make('Laravel')->icon('pi pi-code')->url('https://laravel.com/')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local')->description('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Exercitationem veritatis libero ut cumque.'),
                            MenuItem::make('Inertia')->icon('pi pi-crown')->url('https://inertiajs.com')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local')->description('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Exercitationem veritatis libero ut cumque.'),
                        ])
                            ->footer(
                                (new HeaderFlyoutMenuItemFooter)
                                    ->children([
                                        MenuItem::make('Github')->icon('pi pi-github')->url('https://github.com/pratiksh404')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                                        MenuItem::make('Watch Demo')->icon('pi pi-youtube')->url('https://github.com/pratiksh404')->type(MenuItem::URL)->authorize(env('APP_ENV') === 'local'),
                                    ])
                            )
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
