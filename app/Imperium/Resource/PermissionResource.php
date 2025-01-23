<?php

namespace App\Imperium\Resource;

use App\Models\Admin\Permission;
use App\Services\Resource\DataTable\Columns\TextColumn;
use App\Services\Resource\DataTable\DataTable;
use App\Services\Resource\Form\Fields\TextField;
use App\Services\Resource\Form\Form;
use App\Services\Resource\Navigation\Breadcrumb;
use App\Services\Resource\Navigation\BreadcrumbItem;
use App\Services\Resource\Navigation\MenuItem;
use App\Services\Resource\Navigation\Navigation;
use App\Services\Resource\Resource;

class PermissionResource extends Resource
{
    public static $model = Permission::class;

    public static $name = 'Permission';

    public static $icon = 'pi pi-shield';

    public static $route = 'permissions';

    public function dataTable(): DataTable
    {
        return (new DataTable)
            ->columns([
                TextColumn::make('name'),
            ]);
    }

    public function form(): Form
    {
        return (new Form)
            ->fields([
                TextField::make('id'),
            ]);
    }

    public function navigation(): Navigation
    {
        return (new Navigation)
            ->menus([
                MenuItem::make('Permissions')
                    ->icon(self::$icon)
                    ->url(route('permissions.index'))
                    ->shortcut(1),
            ])
            ->breadcrumbs([
                Breadcrumb::make('Permissions', 'permissions.index')
                    ->items([
                        BreadcrumbItem::make('Permission List', route('permissions.index')),
                    ]),
            ]);
    }
}
