<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Review;

class Like extends Model
{
    protected $table = 'likes';
    protected $fillable = [
        'user_id',
        'review_id',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }
}
