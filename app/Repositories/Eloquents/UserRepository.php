<?php

namespace App\Repositories\Eloquents;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function model()
    {
        return User::class;
    }
}
