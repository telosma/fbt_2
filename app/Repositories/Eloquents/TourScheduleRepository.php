<?php

namespace App\Repositories\Eloquents;

use App\Models\TourSchedule;
use Carbon\Carbon;

class TourScheduleRepository extends BaseRepository
{
    public function __construct(TourSchedule $tourSchedule)
    {
        parent::__construct();
        $this->model = $tourSchedule;
    }

    public function model()
    {
        return TourSchedule::class;
    }

    public function getNewestTours()
    {
        $today = Carbon::today();

        return $this->model
            ->with([
                'tour' => function($query) {
                    $query->with('images');
            }])
            ->whereDate('start', '>', $today)
            ->groupBy('tour_id')
            ->orderBy('start')
            ->limit(config('limit.tour_index'))
            ->get();
    }
}
