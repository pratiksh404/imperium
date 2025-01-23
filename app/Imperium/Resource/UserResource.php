<?php

namespace App\Imperium\Resource;

use App\Models\Admin\Role;
use App\Models\User;
use App\Services\Resource\DataTable\Columns\TextColumn;
use App\Services\Resource\DataTable\DataTable;
use App\Services\Resource\Form\Fields\PasswordField;
use App\Services\Resource\Form\Fields\SelectField;
use App\Services\Resource\Form\Fields\TextField;
use App\Services\Resource\Form\Form;
use App\Services\Resource\Navigation\Breadcrumb;
use App\Services\Resource\Navigation\BreadcrumbItem;
use App\Services\Resource\Navigation\MenuItem;
use App\Services\Resource\Navigation\Navigation;
use App\Services\Resource\Navigation\PageHeader;
use App\Services\Resource\Resource;

class UserResource extends Resource
{
    public static $model = User::class;

    public static $name = 'User';

    public static $icon = 'pi pi-users';

    public static $route = 'users';

    public function dataTable(): DataTable
    {
        return (new DataTable)
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('role.name', 'Role'),
            ]);
    }

    public function form(): Form
    {
        return (new Form)
            ->fields([
                TextField::make('name'),
                TextField::make('email'),
                SelectField::make('role_id', 'User Role')->optionCollection(Role::all(), 'name', 'id'),
                PasswordField::make('password')->required(false),
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
            ->headers([
                PageHeader::make('Users', 'users.index')
                    ->breadcrumb(
                        Breadcrumb::make('Users', 'users.index')
                            ->items([
                                BreadcrumbItem::make('User List', route('users.index')),
                            ])
                    ),
            ]);
    }
}
