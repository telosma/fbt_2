<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\Eloquents\{
    CategoryRepository,
    TourScheduleRepository,
    TourRepository,
    PlaceRepository
};
use App\Http\Requests\ContactRequest;
use Mail;

class HomeController extends Controller
{
    private $categories;
    protected $categoryRepository;
    protected $tourScheduleRepository;
    protected $tourRepository;
    protected $placeRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        TourScheduleRepository $tourScheduleRepository,
        TourRepository $tourRepository,
        PlaceRepository $placeRepository
    ) {
        $this->tourScheduleRepository = $tourScheduleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categories = $this->categoryRepository->withToursCount()->get()['data'];
        $this->tourRepository = $tourRepository;
        $this->placeRepository = $placeRepository;
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

    public function postContact(ContactRequest $request)
    {
        $contact = $request->all();
        try {
            Mail::send('emails.contact', $contact, function($message) use ($contact) {
                $message->from($contact['email']);
                $message->to(config('common.email_admin'));
                $message->subject($contact['subject']);
            });

            return redirect()->back()->with([
                config('common.flash_notice') => trans('user.message.success_contact'),
                config('common.flash_level_key') => config('common.flash_level.success'),
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with([
                config('common.flash_notice') => trans('user.message.fail'),
                config('common.flash_level_key') => config('common.flash_level.danger'),
            ]);
        }
    }

    public function getTourByPlace($id)
    {
        $place = $this->placeRepository
            ->with(['tours' => function($query) {
                $query->limit(config('common.limit.page_limit'));
            }])
            ->find($id);
        $topTours = $this->tourRepository->limitTopRate(config('limit.tour_top'));
        if ($place['status'] && $place['data'] && $topTours['data']) {
            return view('tour.listByPlace', [
                'tourMenu' => $this->tourMenu(null),
                'tours' => $place['data']->tours,
                'topTours' => $topTours['data'],
            ]);
        }
    }
}
