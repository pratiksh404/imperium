<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Http\FormRequest;

class UserRepository extends ResourcefulRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function store(FormRequest $request)
    {
        $user = parent::store($request);

        event(new Registered($user));
    }
}
