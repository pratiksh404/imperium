<?php

namespace App\Contracts;

use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use Illuminate\Http\Request;

interface RoleRepositoryInterface extends ResourcefulInterface
{
    public function permissionToggle(Role $role, Permission $permission);

    public function generateBREADForModule(Role $role, Request $request);
}
