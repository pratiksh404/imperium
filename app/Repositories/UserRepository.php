<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\UserRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;
use Pratiksh\Imperium\Repositories\ResourcefulRepository;

class UserRepository extends ResourcefulRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function store(FormRequest $request)
    {
        $request->validated();

        $user = $this->model->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        event(new Registered($user));
    }

    public function update(FormRequest $request, Model $user)
    {
        $request->validated();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => ! isset($request->password) ? $user->password : bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        return $user;
    }
}
