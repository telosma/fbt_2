<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\RevenueRepository;
use App\Http\Requests\RevenueUpdateRequest;
use App\Http\Requests\RevenueRequest;

class RevenueController extends Controller
{
    protected $revenueRepository;

    public function __construct(RevenueRepository $revenueRepository)
    {
        $this->revenueRepository = $revenueRepository;
    }

    public function index()
    {
        return view('admin.revenue.list');
    }

    public function ajaxList()
    {
        return $this->revenueRepository
            ->withTourSchedulesCount()
            ->get();
    }

    public function ajaxCreate(RevenueRequest $request)
    {
        $revenueRequest = $request->only(['value']);
        $response = $this->revenueRepository->create($revenueRequest);
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

    public function ajaxUpdate(RevenueUpdateRequest $request)
    {
        $revenueRequest = $request->only(['value']);
        $response = $this->revenueRepository->update($revenueRequest, $request->id);
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

    public function ajaxListOnly()
    {
        return $this->revenueRepository->get();
    }

    public function ajaxDelete(Request $request)
    {
        $response = $this->revenueRepository->delete($request->id);
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
}
