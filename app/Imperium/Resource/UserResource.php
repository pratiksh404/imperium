<?php

namespace App\Imperium\Resource;

use App\Models\User;
use App\Services\Resource\DataTable\Columns\TextColumn;
use App\Services\Resource\DataTable\DataTable;
use App\Services\Resource\Form\Fields\TextField;
use App\Services\Resource\Form\Form;
use App\Services\Resource\Navigation\Breadcrumb;
use App\Services\Resource\Navigation\BreadcrumbItem;
use App\Services\Resource\Navigation\MenuItem;
use App\Services\Resource\Navigation\Navigation;
use App\Services\Resource\Resource;

class UserResource extends Resource
{
    public static $model = User::class;

    public static $name = 'User';

    public static $icon = 'pi pi-shield';

    public static $route = 'users';

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
                MenuItem::make('Users')
                    ->icon(self::$icon)
                    ->url(route('users.index'))
                    ->shortcut(1),
            ])
            ->breadcrumbs([
                Breadcrumb::make('Users', 'users.index')
                    ->items([
                        BreadcrumbItem::make('User List', route('users.index')),
                    ]),
            ]);
    }
}
