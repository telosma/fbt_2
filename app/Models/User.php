<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\{Review, Comment, BankAccount, SocialUser, Booking};
use Hash;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'type',
        'avatar_link',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class, 'user_id');
    }

    public function socialUsers()
    {
        return $this->hasMany(SocialUser::class, 'user_id');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getAvatarLinkAttribute()
    {
        if (filter_var($this->attributes['avatar_link'], FILTER_VALIDATE_URL)) {
            return $this->attributes['avatar_link'];
        }

        return asset(config('upload.default_folder_path') . $this->attributes['avatar_link']);
    }
}
