<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SignupRequest;
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
        $params['role'] = 0;
        $params['type'] = 1;
        $user = $this->userRepositoty->create($params);
        if ($user['status']) {
            return redirect()->route('home')->with([
                config('common.flash_notice') => trans('messages.success_signup'),
                config('common.flash_level_key') => config('common.flash_level.success')
            ]);
        }
    }
}
