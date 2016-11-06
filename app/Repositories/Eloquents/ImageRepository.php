<?php

namespace App\Repositories\Eloquents;

use App\Models\Image;

class ImageRepository extends BaseRepository
{

    public function __construct(Image $image)
    {
        parent::__construct();
        $this->model = $image;
    }

    public function model()
    {
        return Image::class;
    }
}
