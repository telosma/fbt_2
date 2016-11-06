<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Tour, Booking, Revenue};
use Carbon\Carbon;

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
    protected $dates = [
        'start',
        'end',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'tour_schedule_id');
    }

    public function revenue()
    {
        return $this->belongsTo(Revenue::class, 'revenue_id');
    }

    public function getStartAttribute($value)
    {
        return Carbon::parse($value)->format(config('common.schedule_date_format'));
    }

    public function setStartAttribute($value)
    {
        return $this->attributes['start'] = $value ?
            Carbon::createFromFormat(config('common.schedule_date_format'), $value)
            : Carbon::now()->format(config('common.schedule_date_format'));
    }

    public function getEndAttribute($value)
    {
        return Carbon::parse($value)->format(config('common.schedule_date_format'));
    }

    public function setEndAttribute($value)
    {
        return $this->attributes['end'] = $value ?
            Carbon::createFromFormat(config('common.schedule_date_format'), $value)
            : Carbon::now()->format(config('common.schedule_date_format'));
    }
}
