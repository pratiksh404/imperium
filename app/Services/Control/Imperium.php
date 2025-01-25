<?php

namespace App\Services\Control;

use App\Services\Control\Header\Header;

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
