<?php

namespace App\Repositories\Eloquents;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{

    public function __construct(Category $category)
    {
        parent::__construct();
        $this->model = $category;
    }

    public function model()
    {
        return Category::class;
    }

    public function WithToursCount()
    {
        $this->model = $this->model->withCount('tours');

        return $this;
    }

    protected function updateNullParent($categories)
    {
        $updateArray = [];
        foreach ($categories as $category) {
            $update = true;
            foreach ($categories as $categoryParent) {
                if ($category->parent_id == $categoryParent->id) {
                    $update = false;
                    continue;
                }
            }
            if ($update) {
                $updateArray[] = $category->id;
            }
        }

        return $this->model->whereIn('id', $updateArray)->update(['parent_id' => null]);
    }
}
