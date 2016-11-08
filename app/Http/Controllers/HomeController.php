<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\Eloquents\{CategoryRepository, TourScheduleRepository, TourRepository};

class HomeController extends Controller
{
    private $categories;
    protected $categoryRepository;
    protected $tourScheduleRepository;
    protected $tourRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        TourScheduleRepository $tourScheduleRepository,
        TourRepository $tourRepository
    ) {
        $this->tourScheduleRepository = $tourScheduleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categories = $this->categoryRepository->withToursCount()->get()['data'];
        $this->tourRepository = $tourRepository;
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
        $topTours = $this->tourRepository->limitTopRate(config('limit.tour_top'));
        $tourSchedules = $this->tourScheduleRepository->getNewestTours();
        if ($topTours['status'] && $tourSchedules )
        {
            return view('user.home', [
                'tourMenu' => $this->tourMenu(null),
                'tourSchedules' => $tourSchedules,
                'topTours' => $topTours['data'],
            ]);
        }

        return view('user.home')->with([
            'tourMenu' => $this->tourMenu(null),
            'tourSchedules' => null,
            'topTours' => null,
            config('common.flash_notice') => trans('user.message.fail'),
            config('common.flash_level_key') => config('common.flash_level.danger'),
        ]);
    }

    public function getTourByCategory($id)
    {
        $tours = $this->tourRepository->getByCategory($id);
        $topTours = $this->tourRepository->limitTopRate(config('limit.tour_top'));
        if ($tours && $topTours['data']) {
            return view('tour.list', [
                'tourMenu' => $this->tourMenu($id),
                'tours' => $tours,
                'topTours' => $topTours['data'],
            ]);
        }

        return redirect('/')->with([
            config('common.flash_notice') => trans('user.message.fail'),
            config('common.flash_level_key') => config('common.flash_level.danger'),
        ]);
    }
}
