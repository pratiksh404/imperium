<?php

namespace App\Imperium\Resource;

use App\Models\Admin\Role;
use App\Services\Resource\DataTable\Columns\TextColumn;
use App\Services\Resource\DataTable\DataTable;
use App\Services\Resource\Form\Fields\RatingField;
use App\Services\Resource\Form\Fields\TextField;
use App\Services\Resource\Form\Form;
use App\Services\Resource\Navigation\Breadcrumb;
use App\Services\Resource\Navigation\BreadcrumbItem;
use App\Services\Resource\Navigation\BreadcrumbPoint;
use App\Services\Resource\Navigation\MenuItem;
use App\Services\Resource\Navigation\Navigation;
use App\Services\Resource\Resource;

class RoleResource extends Resource
{
    public static $model = Role::class;

    public static $name = 'Role';

    public static $icon = 'pi pi-shield';

    public static $route = 'roles';

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
                TextField::make('name'),
                RatingField::make('rating'),
            ]);
    }

    public function navigation(): Navigation
    {
        return (new Navigation)
            ->menus([
                MenuItem::make('Roles')
                    ->icon(self::$icon)
                    ->url(route('roles.index'))
                    ->shortcut(1),
            ])
            ->breadcrumbs([
                Breadcrumb::make('Roles', 'roles.index')
                    ->items([
                        BreadcrumbItem::make('Role List', route('roles.index')),
                    ])->points([
                        BreadcrumbPoint::make('Total Roles : '.Role::count(), 'pi pi-shield'),
                        BreadcrumbPoint::make('Trash Roles : '.Role::onlyTrashed()->count(), 'pi pi-trash'),
                    ]),
            ]);
    }
}
