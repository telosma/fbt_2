<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\TourScheduleRepository;
use Carbon\Carbon;

class HomeController extends Controller
{
    protected $tourScheduleRepository;

    public function __construct(TourScheduleRepository $tourScheduleRepository)
    {
        $this->tourScheduleRepository = $tourScheduleRepository;
    }

    public function index()
    {
        return view('admin.home');
    }

    public function ajaxMonthlyRevenue()
    {
        $data = [
            'labels' => [],
            'values' => [],
        ];
        for ($i = config('admin.max_month_in_char'); $i > 0; $i--) {
            $currentDay = Carbon::now()->month(Carbon::now()->month - $i);
            $minDay = $currentDay->startOfMonth()->toDateString();
            $maxDay = $currentDay->endOfMonth()->toDateString();
            $key = $currentDay->month . '-' . $currentDay->year;
            $value = 0;
            $tourSchedules = $this->tourScheduleRepository
                ->whereBetween('start', [$minDay, $maxDay])
                ->with([
                    'bookings' => function($query) {
                        $query->where('status', config('user.booking.paid'));
                    },
                ])
                ->get();
            if (!$tourSchedules['status']) {
                return $data;
            }

            foreach ($tourSchedules['data'] as $tourSchedule) {
                $numHumans = 0;
                foreach ($tourSchedule->bookings as $booking) {
                    $numHumans += $booking->num_humans;
                }
                $value = $numHumans * $tourSchedule->price;
            }
            $data['labels'][] = $key;
            $data['values'][] = $value;
        }

        return $data;
    }

    public function ajaxAnnualTurnover()
    {
        $data = [
            'labels' => [],
            'values' => [],
        ];
        for ($i = config('admin.max_year_in_char'); $i > 0; $i--) {
            $currentDay = Carbon::now()->year(Carbon::now()->year - $i);
            $minDay = $currentDay->startOfYear()->toDateString();
            $maxDay = $currentDay->endOfYear()->toDateString();
            $key = $currentDay->year;
            $value = 0;
            $tourSchedules = $this->tourScheduleRepository
                ->whereBetween('start', [$minDay, $maxDay])
                ->with([
                    'bookings' => function($query) {
                        $query->where('status', config('user.booking.paid'));
                    },
                ])
                ->get();
            if (!$tourSchedules['status']) {
                return $data;
            }

            foreach ($tourSchedules['data'] as $tourSchedule) {
                $numHumans = 0;
                foreach ($tourSchedule->bookings as $booking) {
                    $numHumans += $booking->num_humans;
                }
                $value = $numHumans * $tourSchedule->price;
            }
            $data['labels'][] = $key;
            $data['values'][] = $value;
        }

        return $data;
    }
}
