<?php

namespace App\Contracts;

use App\Models\Admin\Role;
use Illuminate\Http\Request;
use App\Models\Admin\Permission;
use Pratiksh\Imperium\Contracts\ResourcefulInterface;

interface RoleRepositoryInterface extends ResourcefulInterface
{
    public function permissionToggle(Role $role, Permission $permission);

    public function generateBREADForModule(Role $role, Request $request);
}
