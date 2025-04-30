<?php

namespace App\Imperium\Resource;

use App\Models\Admin\Role;
use App\Models\User;
use Pratiksh\Imperium\Services\Resource\DataTable\Columns\TextColumn;
use Pratiksh\Imperium\Services\Resource\DataTable\DataTable;
use Pratiksh\Imperium\Services\Resource\Form\Fields\PasswordField;
use Pratiksh\Imperium\Services\Resource\Form\Fields\SelectField;
use Pratiksh\Imperium\Services\Resource\Form\Fields\TextField;
use Pratiksh\Imperium\Services\Resource\Form\Form;
use Pratiksh\Imperium\Services\Resource\Navigation\Breadcrumb;
use Pratiksh\Imperium\Services\Resource\Navigation\BreadcrumbItem;
use Pratiksh\Imperium\Services\Resource\Navigation\MenuItem;
use Pratiksh\Imperium\Services\Resource\Navigation\Navigation;
use Pratiksh\Imperium\Services\Resource\Navigation\PageHeader;
use Pratiksh\Imperium\Services\Resource\Resource;

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
