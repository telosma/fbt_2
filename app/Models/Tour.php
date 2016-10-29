<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{TourSchedule, Image, Rate, Place, Review};

class Tour extends Model
{
    protected $table = 'tours';
    protected $fillable = [
        'name',
        'price',
        'category_id',
        'num_day',
        'rate_average',
        'description',
    ];

    public function tourSchedules()
    {
        return $this->hasMany(TourSchedule::class, 'tour_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'tour_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'tour_id');
    }

    public function rates()
    {
        return $this->hasMany(Rate::class, 'tour_id');
    }

    public function places()
    {
        return $this->belongsToMany(Place::class, 'destinations', 'tour_id', 'place_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
