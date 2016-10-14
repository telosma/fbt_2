<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tour;

class Place extends Model
{
    protected $table = 'places';
    protected $fillable = [
        'name',
    ];

    public tours()
    {
        return $this->belongsToMany(Tour::class, 'destinations', 'place_id', 'tour_id');
    }
}
