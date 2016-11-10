<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\Eloquents\{TourRepository, ReviewRepository, TourScheduleRepository};
use Auth;
use Carbon\Carbon;

class TourController extends Controller
{
    protected $tourRepository;
    protected $reviewRepository;
    protected $tourScheduleRepository;
    protected $userId;

    public function __construct(
        TourRepository $tourRepository,
        ReviewRepository $reviewRepository,
        TourScheduleRepository $tourScheduleRepository
    ) {
        $this->tourRepository = $tourRepository;
        $this->reviewRepository = $reviewRepository;
        $this->tourScheduleRepository = $tourScheduleRepository;

        if (Auth::check()) {
            $this->userId = Auth::user()->id;
        } else {
            $this->userId = null;
        }
    }

    public function show($id)
    {
        $tour = $this->tourRepository->show($id);
        if ($tour) {
            $reviews = $this->reviewRepository
                ->where('tour_id', $id)
                ->orderBy('created_at', 'desc')
                ->paginate(config('common.list_review'));

            return view('tour.show', [
                'tour' => $tour,
                'reviews' => $reviews,
            ]);
        }

        return redirect()->route('home')->with([
            config('common.flash_notice') => trans('messages.not_found', ['item' => 'Tour']),
            config('common.flash_level_key') => config('common.flash_level.warning'),
        ]);
    }

    public function postAjaxSchedules(Request $request)
    {
        $tour = $this->tourRepository->find($request->tourId);
        if ($tour['status']) {
            $thresholeDay = Carbon::now()->addDays(config('common.threshole_day'))->toDateString();
            $schedules = $this->tourScheduleRepository
                ->where('tour_id', $request->tourId)
                ->where('start', $thresholeDay, '>')
                ->where('available_slot', 0, '>')
                ->orderBy('start')
                ->limit(config('limit.page_limit'))
                ->get();
            if ($schedules['status']) {
                return [
                    'status' => true,
                    'schedules' => $schedules['data'],
                ];
            }
        }

        return ['status' => false];
    }
}
