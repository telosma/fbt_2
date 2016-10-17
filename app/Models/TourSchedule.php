<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Tour, Booking};

class TourSchedule extends Model
{
    protected $table = 'tour_schedules';
    protected $fillable = [
        'tour_id',
        'revenue_id',
        'start',
        'end',
        'max_slot',
        'available_slot',
        'price',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'tour_schedule_id');
    }
}
