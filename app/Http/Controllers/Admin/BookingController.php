<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\BookingRepository;
use App\Http\Requests\RejectBookingRequest;

class BookingController extends Controller
{
    protected $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function index()
    {
        return view('admin.booking.list');
    }

    public function ajaxList()
    {
        return $this->bookingRepository
            ->with([
                'user' => function ($query) {
                    $query->select(['id', 'name']);
                },
                'tourSchedule' => function ($query) {
                    $query
                        ->select(['id', 'tour_id', 'start', 'end', 'price'])
                        ->with([
                            'tour' => function ($q) {
                                $q->select(['id', 'name', 'num_day']);
                            },
                        ]);
                },
            ])
            ->get();
    }

    public function ajaxReject(RejectBookingRequest $request)
    {
        $response = $this->bookingRepository->reject($request->id);
        if ($response['status']) {
            return [
                config('common.flash_level_key') => config('admin.noty_status.success'),
                config('common.flash_message') => trans('admin.responses.reject', [
                    'status' => trans('admin.status.success'),
                ]),
            ];
        }

        return [
            config('common.flash_level_key') => config('admin.noty_status.error'),
            config('common.flash_message') => trans('admin.responses.reject', [
                'status' => trans('admin.status.fail'),
            ]),
        ];
    }

    public function ajaxDelete(Request $request)
    {
        $response = $this->bookingRepository->delete($request->id);
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
