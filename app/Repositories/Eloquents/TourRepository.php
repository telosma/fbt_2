<?php

namespace App\Repositories\Eloquents;

use App\Models\Tour;
use App\Models\Place;
use DB;

class TourRepository extends BaseRepository
{

    public function __construct(Tour $tour)
    {
        parent::__construct();
        $this->model = $tour;
    }

    public function model()
    {
        return Tour::class;
    }

    public function create($param, $places)
    {
        $tourCreate = parent::create($param);
        if ($tourCreate['status']) {
            $placesArray = [];
            foreach ($places as $place) {
                if (Place::find($place)) {
                    $placesArray[] = $place;
                }
            }
            $tourCreate['data']->places()->attach($placesArray);
        }

        return $tourCreate;
    }

    public function update($param, $id, $places)
    {
        $tourUpdate = parent::update($param, $id);
        if ($tourUpdate['status']) {
            $tourUpdate['data']->places()->detach();
            $placesArray = [];
            foreach ($places as $place) {
                if (Place::find($place)) {
                    $placesArray[] = $place;
                }
            }
            $tourUpdate['data']->places()->attach($places);
        }

        return $tourUpdate;
    }

    public function delete($ids)
    {
        try {
            DB::beginTransaction();
            if (is_array($ids)) {
                $tours = $this->model->whereIn('id', $ids);
                foreach ($tours->get() as $tour) {
                    $tour->places()->detach();
                    $tour->images()->delete();
                    $tour->reviews()->delete();
                    $tour->rates()->delete();
                }
                $data = $tours->delete();
            } else {
                $tour = $this->model->find($ids);
                $tour->places()->detach();
                $tour->images()->delete();
                $tour->reviews()->delete();
                $tour->rates()->delete();
                $data = $tour->delete();
            }

            if (!$data) {
                throw new \Exception(trans('messages.db_delete_error'));
            }

            DB::commit();

            return [
                'status' => true,
                'data' => $data,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function showAll()
    {
        $this->model = $this->model
            ->select([
                'id',
                'name',
                'price',
                'category_id',
                'num_day',
                'rate_average',
            ])
            ->withCount('reviews')
            ->with(['places', 'category']);

        return $this;
    }

    public function show($id)
    {
        return $this->model
            ->with(['tourSchedules', 'places', 'category', 'images'])
            ->find($id);
    }
}
