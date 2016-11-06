<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\TourRepository;
use App\Http\Requests\TourRequest;
use App\Http\Requests\TourUpdateRequest;
use App\Http\Requests\TourUpdateImageRequest;

class TourController extends Controller
{
    protected $tourRepository;

    public function __construct(TourRepository $tourRepository)
    {
        $this->tourRepository = $tourRepository;
    }

    public function index()
    {
        return view('admin.tour.list');
    }

    public function ajaxList()
    {
        return $this->tourRepository
            ->showAll();
    }

    public function ajaxShow($id)
    {
        return $this->tourRepository
            ->show($id);
    }

    public function ajaxShowImage($id)
    {
        return $this->tourRepository
            ->showImage($id);
    }

    public function ajaxUpdateImage(TourUpdateImageRequest $request)
    {
        $response = $this->tourRepository->updateImage($request->id, $request->images);
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
                'status' => $response['message'],
            ]),
        ];
    }

    public function ajaxShowWithSchedule($id)
    {
        $data = $this->tourRepository->showWithSchedule($id);
        if ($data['status']) {
            return $data['data'];
        }

        return [];
    }

    public function ajaxCreate(TourRequest $request)
    {
        $tourRequest = $request->only([
            'name',
            'category_id',
            'price',
            'num_day',
            'description',
        ]);
        if (isset($request['places'])) {
            $places = $request['places'];
        } else {
            $places = [];
        }

        $response = $this->tourRepository->create([
            'tour' => $tourRequest,
            'places' => $places
        ]);
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

    public function ajaxUpdate(TourUpdateRequest $request)
    {
        $tourRequest = $request->only([
            'name',
            'category_id',
            'price',
            'num_day',
            'description',
        ]);
        if (isset($request['places'])) {
            $places = $request['places'];
        } else {
            $places = [];
        }

        $response = $this->tourRepository->update(
            [
                'tour' => $tourRequest,
                'places' => $places
            ],
            $request->id
        );
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
        return $this->tourRepository->lists('name', 'id');
    }

    public function ajaxDelete(Request $request)
    {
        $response = $this->tourRepository->delete($request->id);
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
