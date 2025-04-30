<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\RoleRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleRepositoryInterface;

    public function __construct(RoleRepositoryInterface $roleRepositoryInterface)
    {
        $this->roleRepositoryInterface = $roleRepositoryInterface;
        $this->authorizeResource(Role::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Admin/Modules/Role/Index', $this->roleRepositoryInterface->index());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $this->roleRepositoryInterface->store($request);

        return to_route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $this->roleRepositoryInterface->update($request, $role);

        return to_route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->roleRepositoryInterface->destroy($role);

        return to_route('roles.index');
    }

    public function permissionToggle(Role $role, Permission $permission)
    {
        $this->roleRepositoryInterface->permissionToggle($role, $permission);

        return to_route('roles.index');
    }

    public function generateBREADForModule(Role $role, Request $request)
    {
        $this->roleRepositoryInterface->generateBREADForModule($role, $request);

        return to_route('roles.index');
    }
}
