<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{User, TourSchedule};

class Booking extends Model
{
    protected $table = 'bookings';
    protected $fillable = [
        'user_id',
        'tour_schedule_id',
        'num_humans',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tourSchedule()
    {
        return $this->belongsTo(TourSchedule::class, 'tour_schedule_id');
    }
}
