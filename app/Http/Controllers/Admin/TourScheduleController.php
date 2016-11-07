<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\TourScheduleRepository;
use App\Http\Requests\TourScheduleUpdateRequest;
use App\Http\Requests\TourScheduleRequest;

class TourScheduleController extends Controller
{
    protected $tourScheduleRepository;

    public function __construct(TourScheduleRepository $tourScheduleRepository)
    {
        $this->tourScheduleRepository = $tourScheduleRepository;
    }

    public function index()
    {
        return view('admin.tourSchedule.list');
    }

    public function ajaxList()
    {
        return $this->tourScheduleRepository
            ->showAll()
            ->get();
    }

    public function ajaxCreate(TourScheduleRequest $request)
    {
        $tourScheduleRequest = $request->only([
            'tour_id',
            'revenue_id',
            'start',
            'end',
            'max_slot',
        ]);
        $response = $this->tourScheduleRepository->create($tourScheduleRequest);
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

    public function ajaxUpdate(TourScheduleUpdateRequest $request)
    {
        $tourScheduleRequest = $request->only([
            'tour_id',
            'revenue_id',
            'start',
            'end',
            'max_slot',
        ]);
        $response = $this->tourScheduleRepository->update($tourScheduleRequest, $request->id);
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
        return $this->tourScheduleRepository->all();
    }

    public function ajaxDelete(Request $request)
    {
        $response = $this->tourScheduleRepository->delete($request->id);
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
