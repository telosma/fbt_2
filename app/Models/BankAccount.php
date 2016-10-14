<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class BankAccount extends Model
{
    protected $table = 'bank_accounts';
    protected $fillable = [
        'user_id',
        'account',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
