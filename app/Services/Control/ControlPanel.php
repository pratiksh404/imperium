<?php

namespace App\Services\Navigation;

use App\Services\Control\Header\Header;
use App\Services\Control\Menu;
use App\Services\Control\Sidebar;

abstract class Imperium
{
    const HOME = 'dashboard';

    const THEME_SWITCHER = true;

    abstract public function menu(): Menu;

    abstract public function header(): Header;

    abstract public function sidebar(): Sidebar;

    public function homeRoute(): string
    {
        return route(static::HOME);
    }
}
