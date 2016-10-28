<?php

namespace App\Repositories\Eloquents;

use App\Models\Revenue;

class RevenueRepository extends BaseRepository
{

    public function __construct(Revenue $revenue)
    {
        parent::__construct();
        $this->model = $revenue;
    }

    public function model()
    {
        return Revenue::class;
    }

    public function withTourSchedulesCount()
    {
        $this->model = $this->model->withCount('tourSchedules');

        return $this;
    }
}
