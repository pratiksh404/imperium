<?php

namespace App\Imperium\Resource;

use App\Models\User;
use App\Models\Admin\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Resource\Resource;
use App\Services\Resource\Form\Form;
use App\Services\Resource\DataTable\DataTable;
use App\Services\Resource\Navigation\MenuItem;
use App\Services\Resource\Form\Fields\TextField;
use App\Services\Resource\Navigation\Breadcrumb;
use App\Services\Resource\Navigation\Navigation;
use App\Services\Resource\Navigation\PageHeader;
use App\Services\Resource\Navigation\HeaderPoint;
use App\Services\Resource\Form\Fields\SelectField;
use App\Services\Resource\Form\Fields\TextareaField;
use App\Services\Resource\Navigation\BreadcrumbItem;
use App\Services\Resource\Form\Fields\DatePickerField;
use App\Services\Resource\DataTable\Columns\TextColumn;
use App\Services\Resource\Form\Fields\SelectOption;

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
            ])->precognitionMode()->opensIn(Form::DIALOG_MODE);
    }

    public function navigation(): Navigation
    {
        $auth_user = $this->authUser;

        return (new Navigation)
            ->menus([
                MenuItem::make('Roles')
                    ->icon(self::$icon)
                    ->url(route('roles.index'))
                    ->authorize($auth_user->can('viewAny', Role::class)),
            ])
            ->headers([
                PageHeader::make('Roles', 'roles.index')
                    ->breadcrumb(
                        Breadcrumb::make('Roles', 'roles.index')
                            ->items([
                                BreadcrumbItem::make('Role List', route('roles.index')),
                            ])
                    )
                    ->points([
                        HeaderPoint::make('Total Roles : ' . Role::count(), 'pi pi-shield'),
                        HeaderPoint::make('Trash Roles : ' . Role::onlyTrashed()->count(), 'pi pi-trash'),
                    ]),
            ]);
    }
}
