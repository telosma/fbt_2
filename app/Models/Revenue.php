<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TourSchedule;

class Revenue extends Model
{
    protected $table = 'revenues';
    protected $fillable = [
        'value',
    ];

    public function tourSchedules()
    {
        return $this->hasMany(TourSchedule::class, 'revenue_id');
    }
}
