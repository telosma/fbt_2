<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Socialite;
use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Eloquents\SocialUserRepository;
use Exception;

class AuthSocialController extends Controller
{
    protected $userRepository;
    protected $socialUserRepository;

    public function __construct(UserRepository $userRepository, SocialUserRepository $socialUserRepository)
    {
        $this->userRepository = $userRepository;
        $this->socialUserRepository = $socialUserRepository;
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();
        if ($socialUser) {
            $user = $this->findOrCreateUser($socialUser, $this->convertProviderTotinyInt($provider));
            if (isset($user['message'])) {
                return redirect()->route('home')->with([
                    config('common.flash_notice') => $user['message'],
                    config('common.flash_level_key') => config('common.flash_level.danger')
                ]);
            }

            Auth::login($user);

            return redirect()->route('home')->with([
                config('common.flash_notice') => trans('user.message.success_via', ['provider' => $provider]),
                config('common.flash_level_key') => config('common.flash_level.success')
            ]);
        }
    }

    protected function findOrCreateUser($socialUser, $provider)
    {
        $existUser = $this->userRepository->where('email', $socialUser->email)->first();

        if ($existUser['status'] && is_null($existUser['data'])) {   // Not Exist User
            $newUser = $this->userRepository->create([
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'avatar_link' => $socialUser->avatar,
                'role' => config('user.role.user'),
                'type' => $provider,
            ]);
            if ($newUser['status']) {
                $createSocialUser =  $this->socialUserRepository->findOrCreate(
                    $socialUser,
                    $provider,
                    $newUser['data']->id
                );
                if (isset($createSocialUser['message'])) {
                    return [
                        'message' => $createSocialUser['message'],
                    ];
                } else {
                    return $newUser['data'];
                }
            } else {
                return [
                    'message' => $newUser['message'],
                ];
            }
        } elseif ($existUser['status']) {   //Exist User
            $createSocialUser =  $this->socialUserRepository->findOrCreate(
                $socialUser,
                $provider,
                $existUser['data']->id
            );
            if (isset($createSocialUser['message'])) {
                return [
                    'message' => $createSocialUser['message'],
                ];
            } else {
                return $existUser['data'];
            }
        } else {
            return [
                'message' => $existUser['message'],
            ];
        }
    }

    protected function convertProviderTotinyInt($provider)
    {
        switch ($provider) {
            case 'facebook':
                return config('user.type.facebook_user');
                break;
            case 'google':
                return config('user.type.google_user');
                break;
            case 'github':
                return config('user.type.github_user');
                break;
        }
    }
}
