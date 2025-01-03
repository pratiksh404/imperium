<?php

namespace App\Repositories;

use App\Repositories\ResourcefulRepository;
use App\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends ResourcefulRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
