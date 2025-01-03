<?php

namespace App\Repositories;

use App\Contracts\RoleRepositoryInterface;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleRepository extends ResourcefulRepository implements RoleRepositoryInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function permissionToggle(Role $role, Permission $permission)
    {
        DB::table('permission_role')->updateOrInsert([
            'role_id' => $role->id,
            'permission_id' => $permission->id,
        ], [
            'active' => ! $role->permissions()->where('permissions.id', $permission->id)->first()->pivot->active,
        ]);
    }

    public function generateBREADForModule(Role $role, Request $request)
    {
        $request->validate([
            'module_namespace' => 'required',
        ]);

        Permission::generateBREADForModel($request->get('module_namespace'), $role);
    }
}
