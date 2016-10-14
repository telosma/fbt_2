<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{User, Comment};

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
}
