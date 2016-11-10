<?php

namespace App\Repositories\Eloquents;

use App\Models\TourSchedule;
use Carbon\Carbon;
use App\Repositories\Eloquents\TourRepository;
use App\Repositories\Eloquents\RevenueRepository;

class TourScheduleRepository extends BaseRepository
{
    protected $tourRepository;
    protected $revenueRepository;

    public function __construct(
        TourSchedule $tourSchedule,
        TourRepository $tourRepository,
        RevenueRepository $revenueRepository
    ) {
        parent::__construct();
        $this->model = $tourSchedule;
        $this->tourRepository = $tourRepository;
        $this->revenueRepository = $revenueRepository;
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

    public function showAll()
    {
        $this->model = $this->model->with([
            'tour' => function ($query) {
                $query->select(['id', 'price', 'name', 'rate_average', 'num_day']);
            },
            'revenue' => function ($query) {
                $query->select(['id', 'value']);
            },
        ]);

        return $this;
    }

    public function create($param)
    {
        try {
            $tourScheduleParam = $param;
            $tourScheduleParam['available_slot'] = $param['max_slot'];
            $tour = $this->tourRepository->find($param['tour_id'])['data'];
            $revenue = $this->revenueRepository->find($param['revenue_id']);
            if ($revenue['status']) {
                $percent = $revenue['data']['value'];
            } else {
                $percent = 0;
            }

            $tourScheduleParam['price'] = round((1 - $percent / 100) * $tour->price);

            return parent::create($tourScheduleParam);
        } catch (Exception $ex) {
            return [
                'status' => false,
                'message' => $ex->getMessage(),
            ];
        }
    }

    public function update($param, $id)
    {
        try {
            $tourScheduleParam = $param;
            $tourScheduleParam['available_slot'] = $param['max_slot'];
            $tour = $this->tourRepository->find($param['tour_id'])['data'];
            $revenue = $this->revenueRepository->find($param['revenue_id']);
            if ($revenue['status']) {
                $percent = $revenue['data']['value'];
            } else {
                $percent = 0;
            }

            $tourScheduleParam['price'] = round((1 - $percent / 100) * $tour->price);

            return parent::update($tourScheduleParam, $id);
        } catch (Exception $ex) {
            return [
                'status' => false,
                'message' => $ex->getMessage(),
            ];
        }
    }
}
