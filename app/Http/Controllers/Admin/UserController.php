<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;


class UserController extends Controller
{
    protected $userRepositoryInterface;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Admin/Modules/User/Index', $this->userRepositoryInterface->index());
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
    public function store(UserRequest $request)
    {
        $this->userRepositoryInterface->store($request);

        return to_route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $this->userRepositoryInterface->update($request, $user);

        return to_route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->userRepositoryInterface->destroy($user);

        return to_route('users.index');
    }
}
