<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Tour, Category};

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'parent_id',
        'name',
    ];

    public function tours()
    {
        return $this->hasMany(Tour::class, 'category_id');
    }
    
    public function categoriesChildren()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
