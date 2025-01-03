<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait HasAuthorization
{
    public $user;

    public function initializeHasAuthorization()
    {
        $this->appends[] = 'can';
        $this->user = $this->getUser();
    }

    // Returns Policy Permissions
    public function getCanAttribute()
    {
        $user = $this->user ?? $this->getUser();

        if (! is_null($user)) {
            return [
                'viewAny' => $user->can('viewAny', $this),
                'view' => $user->can('view', [$this, $this->id]),
                'create' => $user->can('create', [$this, $this->id]),
                'update' => $user->can('update', [$this, $this->id]),
                'delete' => $user->can('delete', [$this, $this->id]),
                'restore' => $user->can('restore', [$this, $this->id]),
                'forceDelete' => $user->can('forceDelete', [$this, $this->id]),
            ];
        }

        return null;

    }

    public function getUser()
    {
        return $this->user ?? (class_basename($this) == 'User' ? $this : User::find(Auth::user()->id ?? null));
    }
}
