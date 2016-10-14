<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tour;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = [
        'tour_id',
        'url',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }
}
