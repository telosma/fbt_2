<?php

namespace App\Repositories\Eloquents;

use App\Models\Review;

class ReviewRepository extends BaseRepository
{
    function __construct(Review $review)
    {
        parent::__construct();
        $this->model = $review;
    }

    public function model()
    {
        return Review::class;
    }
}
