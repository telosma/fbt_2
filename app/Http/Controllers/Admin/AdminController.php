<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('notAdmin', ['except' => 'logout']);
        $this->middleware('admin', ['only' => 'logout']);
    }

    public function getLogin()
    {
        return view('admin.login');
    }

    public function postLogin(AdminLoginRequest $request)
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->back()->with([
                config('common.flash_message') => trans('user.message.error_login'),
                config('common.flash_level_key') => config('common.flash_level.warning')
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('admin.getLogin');
    }
}
