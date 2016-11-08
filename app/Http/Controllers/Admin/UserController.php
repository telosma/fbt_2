<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\UserRepository;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return view('admin.user.list');
    }

    public function ajaxList()
    {
        return $this->userRepository->showAll()->get();
    }

    public function ajaxCreate(UserRequest $request)
    {
        $userRequest = $request->only(['name', 'email']);
        $userRequest['password'] = $userRequest['email'];
        $response = $this->userRepository->create($userRequest);
        if ($response['status']) {
            return [
                config('common.flash_level_key') => config('admin.noty_status.success'),
                config('common.flash_message') => trans('admin.responses.create', [
                    'status' => trans('admin.status.success'),
                ]),
            ];
        }

        return [
            config('common.flash_level_key') => config('admin.noty_status.error'),
            config('common.flash_message') => trans('admin.responses.create', [
                'status' => trans('admin.status.fail'),
            ]),
        ];
    }

    public function ajaxUpdate(UserUpdateRequest $request)
    {
        $userRequest = $request->only(['name', 'email']);
        $response = $this->userRepository->update($userRequest, $request->id);
        if ($response['status']) {
            return [
                config('common.flash_level_key') => config('admin.noty_status.success'),
                config('common.flash_message') => trans('admin.responses.update', [
                    'status' => trans('admin.status.success'),
                ]),
            ];
        }

        return [
            config('common.flash_level_key') => config('admin.noty_status.error'),
            config('common.flash_message') => trans('admin.responses.update', [
                'status' => trans('admin.status.fail'),
            ]),
        ];
    }

    public function ajaxDelete(Request $request)
    {
        $response = $this->userRepository->delete($request->id);
        if ($response['status']) {
            return [
                config('common.flash_level_key') => config('admin.noty_status.success'),
                config('common.flash_message') => trans('admin.responses.delete', [
                    'status' => trans('admin.status.success'),
                ]),
            ];
        }

        return [
            config('common.flash_level_key') => config('admin.noty_status.error'),
            config('common.flash_message') => trans('admin.responses.delete', [
                'status' => trans('admin.status.fail'),
            ]),
        ];
    }
    
    public function ajaxResetPass(Request $request)
    {
        $response = $this->userRepository->resetPassword($request->id);
        if ($response['status']) {
            return [
                config('common.flash_level_key') => config('admin.noty_status.success'),
                config('common.flash_message') => trans('user.message.reset_password', [
                    'status' => trans('admin.status.success'),
                ]),
            ];
        }

        return [
            config('common.flash_level_key') => config('admin.noty_status.error'),
            config('common.flash_message') => trans('user.message.reset_password', [
                'status' => trans('admin.status.fail'),
            ]),
        ];
    }
}
