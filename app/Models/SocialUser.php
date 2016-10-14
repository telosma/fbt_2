<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SocialUser extends Model
{
    protected $table = 'social_users';
    protected $fillable = [
        'user_id',
        'provider',
        'provider_user_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
