<?php

namespace App\Repositories\Eloquents;

use App\Models\Tour;
use App\Repositories\Eloquents\PlaceRepository;
use App\Repositories\Eloquents\ImageRepository;
use DB;

class TourRepository extends BaseRepository
{
    protected $placeRepository;
    protected $imageRepository;

    public function __construct(
        Tour $tour,
        PlaceRepository $placeRepository,
        ImageRepository $imageRepository
    ) {
        parent::__construct();
        $this->model = $tour;
        $this->placeRepository = $placeRepository;
        $this->imageRepository = $imageRepository;
    }

    public function model()
    {
        return Tour::class;
    }

    public function create($param)
    {
        $tourCreate = parent::create($param['tour']);
        if ($tourCreate['status']) {
            $places = [];
            foreach ($param['places'] as $placeId) {
                if ($this->placeRepository->find($placeId)['status']) {
                    $places[] = $placeId;
                }
            }
            $tourCreate['data']->places()->attach($places);
        }

        return $tourCreate;
    }

    public function updateImage($id, $images)
    {
        try {
            $tour = $this->find($id)['data'];
            $imageCreated = 0;
            if (!$tour) {
                throw new \Exception(trans('tour.tour_not_exist'));
            }

            $tour->images()->delete();
            if (!empty($images)) {
                foreach ($images as $image) {
                    $headers = get_headers($image);
                    if(strpos($headers[0], '200') !== false)
                    {
                        $imageCreate = $this->imageRepository->create([
                            'tour_id' => $tour->id,
                            'url' => $image
                        ]);
                        if ($imageCreate['status']) {
                            $imageCreated++;
                        }
                    }
                }
            }

            return [
                'status' => true,
                'data' => $imageCreated,
            ];
        } catch (\Exception $ex) {
            return [
                'status' => false,
                'message' => $ex->getMessage(),
            ];
        }
    }

    public function update($param, $id)
    {
        $tourUpdate = parent::update($param['tour'], $id);
        if ($tourUpdate['status']) {
            $tourUpdate['data']->places()->detach();
            $places = [];
            foreach ($param['places'] as $placeId) {
                if ($this->placeRepository->find($placeId)['status']) {
                    $places[] = $placeId;
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
                $tours = $this->whereIn('id', $ids);
                foreach ($tours->get()['data'] as $tour) {
                    $tour->places()->detach();
                    $tour->images()->delete();
                    $tour->reviews()->delete();
                    $tour->rates()->delete();
                }
                $data = $tours->remove();
            } else {
                $tour = $this->find($ids)['data'];
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
        return $this
            ->select([
                'id',
                'name',
                'price',
                'category_id',
                'num_day',
                'rate_average',
                'description',
            ])
            ->withCount('reviews')
            ->with(['places', 'category'])
            ->get();
    }

    public function show($id)
    {
        return $this
            ->with(['tourSchedules', 'places', 'category', 'images'])
            ->withCount('reviews', 'rates')
            ->find($id)['data'];
    }

    public function showImage($id)
    {
        return $this
            ->select(['id', 'name'])
            ->with('images')
            ->find($id)['data'];
    }
}
