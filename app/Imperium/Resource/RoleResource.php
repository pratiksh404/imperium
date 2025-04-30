<?php

namespace App\Imperium\Resource;

use App\Models\User;
use App\Models\Admin\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Pratiksh\Imperium\Services\Resource\Resource;
use Pratiksh\Imperium\Services\Resource\Form\Form;
use Pratiksh\Imperium\Services\Resource\DataTable\DataTable;
use Pratiksh\Imperium\Services\Resource\Navigation\MenuItem;
use Pratiksh\Imperium\Services\Resource\Form\Fields\TextField;
use Pratiksh\Imperium\Services\Resource\Navigation\Breadcrumb;
use Pratiksh\Imperium\Services\Resource\Navigation\Navigation;
use Pratiksh\Imperium\Services\Resource\Navigation\PageHeader;
use Pratiksh\Imperium\Services\Resource\Navigation\HeaderPoint;
use Pratiksh\Imperium\Services\Resource\Form\Fields\SelectField;
use Pratiksh\Imperium\Services\Resource\Form\Fields\TextareaField;
use Pratiksh\Imperium\Services\Resource\Navigation\BreadcrumbItem;
use Pratiksh\Imperium\Services\Resource\Form\Fields\DatePickerField;
use Pratiksh\Imperium\Services\Resource\DataTable\Columns\TextColumn;
use Pratiksh\Imperium\Services\Resource\Form\Fields\NumberField;
use Pratiksh\Imperium\Services\Resource\Form\Fields\SelectOption;

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
                TextColumn::make('name')->searchable(),
            ]);
    }

    public function form(): Form
    {
        return (new Form)
            ->fields([
                TextField::make('name'),
                NumberField::make('age')->dependsOn('name', function (Request $request) {
                    return rand(1, 100);
                })
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
