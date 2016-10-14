<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{User, Review};

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = [
        'user_id',
        'review_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }
}
