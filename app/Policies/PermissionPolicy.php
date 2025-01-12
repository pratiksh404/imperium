<?php

namespace App\Policies;

use App\Models\Admin\Permission;
use App\Models\User;

class PermissionPolicy
{
    public $bread;

    public function before(User $user, string $ability)
    {
        $this->bread = $user->breadPermissionForModule('Permission');

    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $this->bread['browse'] ?? false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Permission $permission): bool
    {
        return $this->bread['read'] ?? false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->bread['add'] ?? false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permission $permission): bool
    {
        return $this->bread['edit'] ?? false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permission $permission): bool
    {
        return $this->bread['delete'] ?? false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Permission $permission): bool
    {
        return $this->bread['delete'] ?? false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Permission $permission): bool
    {
        return $this->bread['delete'] ?? false;
    }
}
