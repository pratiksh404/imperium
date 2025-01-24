<?php

namespace App\Services\Control\Header;

class HeaderNavigation
{
    public array $menus = [];

    public $authorize = true;

    public array $profileMenuItems = [];

    public array $headerLinkMenuItems = [];

    public array $headerFlyoutMenuItems = [];

    public function profileMenus(array $profileMenuItems = []): self
    {
        $this->profileMenuItems = $profileMenuItems;

        return $this;
    }

    public function headerLinkMenus(array $headerLinkMenuItems = []): self
    {
        $this->headerLinkMenuItems = $headerLinkMenuItems;

        return $this;
    }

    public function headerFlyoutMenus(array $headerFlyoutMenuItems = []): self
    {
        $this->headerFlyoutMenuItems = $headerFlyoutMenuItems;

        return $this;
    }

    public function authorize(bool $authorize = true): self
    {
        $this->authorize = $authorize;

        return $this;
    }
}
