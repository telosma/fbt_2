<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tour;

class Rate extends Model
{
    protected $table = 'rates';
    protected $fillable = [
        'user_id',
        'tour_id',
        'point',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }
}
