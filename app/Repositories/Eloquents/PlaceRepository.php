<?php

namespace App\Repositories\Eloquents;

use App\Models\Place;

class PlaceRepository extends BaseRepository
{

    public function __construct(Place $place)
    {
        parent::__construct();
        $this->model = $place;
    }

    public function model()
    {
        return Place::class;
    }

    public function withToursCount()
    {
        $this->model = $this->model->withCount('tours');

        return $this;
    }
}
