<?php

namespace App\Repositories\Eloquents;

use App\Models\Booking;
use DB;
use App\Repositories\Eloquents\TourScheduleRepository;

class BookingRepository extends BaseRepository
{
    protected $tourScheduleRepository;

    public function __construct(
        Booking $booking,
        TourScheduleRepository $tourScheduleRepository
    ) {
        parent::__construct();
        $this->model = $booking;
        $this->tourScheduleRepository = $tourScheduleRepository;
    }

    public function model()
    {
        return Booking::class;
    }

    public function reject($ids)
    {
        try {
            DB::beginTransaction();
            $countRejected = 0;
            if (!is_array($ids)) {
                $ids = [$ids];
            }

            $bookings = $this
                ->whereIn('id', $ids)
                ->where('status', config('user.booking.new'))
                ->get();

            if ($bookings['status']) {
                foreach ($bookings['data'] as $booking) {
                    $booking->update(['status' => config('user.booking.rejected')]);
                    $tourSchedule = $booking->tourSchedule()->first();
                    if ($tourSchedule) {
                        $tourSchedule->available_slot = $tourSchedule->available_slot + $booking->num_humans;
                        $tourSchedule->save();
                    }

                    $countRejected++;
                }
            } else {
                return [
                    'status' => false,
                    'message' => trans('messages.db_delete_error'),
                ];
            }

            DB::commit();

            return [
                'status' => true,
                'data' => $countRejected,
            ];
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getByUserId($userId)
    {
        return $this
            ->where('user_id', $userId)
            ->with(['tourSchedule' => function($query) {
                $query->with(['tour']);
            }])
            ->orderBy('status')
            ->orderBy('created_at', 'desc')
            ->paginate(config('common.limit.page_limit'));
    }
}
