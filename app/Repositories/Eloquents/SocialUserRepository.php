<?php

namespace App\Repositories\Eloquents;

use App\Models\SocialUser;

class SocialUserRepository extends BaseRepository
{
    public function __construct(SocialUser $socialUser)
    {
        parent::__construct();
        $this->model = $socialUser;
    }

    public function model()
    {
        return SocialUser::class;
    }
}
