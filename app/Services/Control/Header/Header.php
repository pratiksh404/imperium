<?php

namespace App\Services\Control\Header;

use App\Services\Resource\Navigation\MenuItem;

class Header
{
    public bool $includeThemeSwitcher = true;

    public bool $includeHeaderMenu = true;

    public bool $includeBreadcrumb = true;

    public HeaderNavigation $navigation;

    public array $profileMenus = [];

    public function navigation(HeaderNavigation $navigation): self
    {
        $this->navigation = $navigation;

        return $this;
    }

    public function profileMenus(?array $profileMenus = null): self
    {
        $this->profileMenus = $profileMenus ?? [
            MenuItem::make('Profile')->url(route('profile.edit'))->icon('pi pi-user'),
            MenuItem::make('Logout')->url(route('logout'))->icon('pi pi-sign-out'),
        ];

        return $this;
    }

    public function includeThemeSwitcher(bool $includeThemeSwitcher): self
    {
        $this->includeThemeSwitcher = $includeThemeSwitcher;

        return $this;
    }

    public function includeHeaderMenu(bool $includeHeaderMenu): self
    {
        $this->includeHeaderMenu = $includeHeaderMenu;

        return $this;
    }

    public function includeBreadcrumb(bool $includeBreadcrumb): self
    {
        $this->includeBreadcrumb = $includeBreadcrumb;

        return $this;
    }
}
