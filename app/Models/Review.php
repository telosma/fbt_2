<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{User, Comment, Tour};
use Carbon\Carbon;

class Review extends Model
{
    protected $table = 'reviews';
    protected $fillable = [
        'user_id',
        'tour_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'review_id');
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(config('common.publish_date_format'));
    }
}
