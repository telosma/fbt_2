<?php

namespace App\Repositories\Eloquents;

use App\Models\SocialUser;
use Exception;

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

    public function findOrCreate($socialUser, $provider, $userId)
    {
        $existUser = $this->model->where('provider_user_token', $socialUser->id)->first();
        if (!$existUser) {
            try {
                $user = $this->model->create([
                    'user_id' => $userId,
                    'provider' => $provider,
                    'provider_user_token' => $socialUser->id,
                ]);

                return $user;
            } catch (Exception $e) {
                return [
                    'message' => $e->getMessage(),
                ];
            }
        }

        if ($existUser->user_id !== $userId) {
            $existUser->user_id = $userId;
            try {
                $existUser->save();
            } catch (Exception $e) {
                return [
                    'message' => $e->getMessage(),
                ];
            }
        }

        return $existUser;
    }
}
