<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\SigninRequest;
use App\Repositories\Eloquents\UserRepository;
use Auth;

class AuthUserController extends Controller
{
    protected $userRepositoty;

    public function __construct(UserRepository $userRepositoty)
    {
        $this->userRepositoty = $userRepositoty;
    }

    public function postSignup(SignupRequest $request)
    {
        $params = $request->only('name', 'email', 'password');
        $params['avatar_link'] = config('common.default_avatar');
        $params['role'] = config('user.role.user');
        $params['type'] = config('user.type.normal_user');
        $user = $this->userRepositoty->create($params);
        if ($user['status']) {
            Auth::login($user['data']);

            return redirect()->route('home')->with([
                config('common.flash_notice') => trans('user.message.success_signup'),
                config('common.flash_level_key') => config('common.flash_level.success')
            ]);
        }
    }

    public function postSignin(SigninRequest $request)
    {
        $loginSuccess = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);
        if ($loginSuccess) {
            $message = [
                config('common.flash_notice') => trans('user.message.success_signin',['email' => $request->email]),
                config('common.flash_level_key') => config('common.flash_level.success'),
            ];
        } else {
            $message = [
                config('common.flash_notice') => trans('user.message.failed_signin'),
                config('common.flash_level_key') => config('common.flash_level.danger'),
            ];
        }

        return redirect()->route('home')->with($message);
    }

    public function getSignout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->flush();

            return redirect()->route('home');
        }
    }
}
