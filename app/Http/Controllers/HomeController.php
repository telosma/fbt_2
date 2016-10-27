<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\Eloquents\{CategoryRepository, TourScheduleRepository};

class HomeController extends Controller
{
    private $categories;
    protected $categoryRepository;
    protected $tourScheduleRepository;

    public function __construct(CategoryRepository $categoryRepository, TourScheduleRepository $tourScheduleRepository)
    {
        $this->tourScheduleRepository = $tourScheduleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categories = $this->categoryRepository->withToursCount()->get()['data'];
    }

    public function tourMenu($categoryCurrentId)
    {
        return $this->drawTourMenu($this->categories, $categoryCurrentId);
    }

    protected function drawTourMenu($categories, $categoryCurrentId, $parent_id = null)
    {
        $result = '';
        foreach ($categories as $key => $category) {
            if ($category['parent_id'] == $parent_id) {
                $children = $this->drawTourMenu($categories, $categoryCurrentId, $category['id']);
                $result .= view('includes.tourMenuPiece', [
                    'category' => $category,
                    'children' => $children,
                    'tourCountTree' => $this->tourCountTree($key),
                    'categoryCurrentId' => $categoryCurrentId,
                ])->render();
            }
        }

        return $result;
    }

    public function tourCountTree($key)
    {
        if (isset($this->categories[$key])) {
            $response = $this->categories[$key]['tours_count'];
            foreach ($this->categories as $k => $category) {
                if ($category['parent_id'] == $this->categories[$key]['id']) {
                    $response += $this->tourCountTree($k);
                }
            }

            return $response;
        }

        return false;
    }

    public function getHome()
    {
        return view('user.home', [
            'tourMenu' => $this->tourMenu(null),
            'tourSchedules' => $this->tourScheduleRepository->getNewestTours(),
        ]);
    }
}
