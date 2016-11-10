<?php

namespace App\Repositories\Eloquents;

use App\Models\Rate;
use App\Repositories\Eloquents\TourRepository;

class RateRepository extends BaseRepository
{
    protected $tourRepository;

    public function __construct(Rate $rate, TourRepository $tourRepository)
    {
        parent::__construct();
        $this->model = $rate;
        $this->tourRepository = $tourRepository;
    }

    public function model()
    {
        return Rate::class;
    }
    
    public function caculateTourPoint($tourId)
    {
        $points = $this->where('tour_id', $tourId)->get();
        if ($points['status']) {
            $pointAvg = $points['data']->avg('point');
            if ($this->tourRepository->update(['tour' => ['rate_average' => $pointAvg]], $tourId)['status']) {
                return true;
            }
        }

        return false;
    }
}
