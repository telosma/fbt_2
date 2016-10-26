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
                return redirect()->route('home')->withErrors($user['message']);
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
                $existSocialUser = $this->socialUserRepository->where('provider_user_token', $socialUser->id)->first();
                if ($existSocialUser['status'] && is_null($existSocialUser['data'])) {
                    $newSocialUser = $this->socialUserRepository->create([
                        'user_id' => $newUser['data']->id,
                        'provider' => $provider,
                        'provider_user_token' => $socialUser->id,
                    ]);
                    if ($newSocialUser['status']) {
                        return $newUser['data'];
                    }                    
                } elseif ($existSocialUser['status']) {
                    $newSocialUser = $this->socialUserRepository->update(
                        ['user_id' => $newUser['data']->id],
                        $existSocialUser['data']->id
                    );

                    return $newUser['data'];
                } else {
                    return [
                        'message' => $existSocialUser['message'],
                    ];
                }
            } else {
                return [
                    'message' => $newUser['message'],
                ];            }
        } elseif ($existUser['status']) {   //Exist User
            $existSocialUser = $this->socialUserRepository->where('provider_user_token', $socialUser->id)->first();
            if ($existSocialUser['status'] && is_null($existSocialUser['data'])) {
                $newSocialUser = $this->socialUserRepository->create([
                    'user_id' => $existUser['data']->id,
                    'provider' => $provider,
                    'provider_user_token' => $socialUser->id,
                ]);
            } elseif ($existSocialUser['status']) {
                return $existUser['data'];
            } else {
                return [
                    'message' => $existSocialUser['message'],
                ];
            }
        } else {
            return [
                'message' => $existUser['message'],
            ];
        }
    }

    protected function convertProviderTotinyInt($provider)
    {
        if ($provider === 'facebook') {
            return config('user.type.facebook_user');
        } elseif ($provider === 'google') {
            return config('user.type.google_user');
        } elseif ($provider === 'github') {
            return config('user.type.github_user');
        }
    }
}
