<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\Eloquents\{TourRepository, ReviewRepository};
use Auth;

class TourController extends Controller
{
    protected $tourRepository;
    protected $reviewRepository;
    protected $userId;

    public function __construct(TourRepository $tourRepository, ReviewRepository $reviewRepository)
    {
        $this->tourRepository = $tourRepository;
        $this->reviewRepository = $reviewRepository;

        if (Auth::check()) {
            $this->userId = Auth::user()->id;
        } else {
            $this->userId = null;
        }
    }

    public function show($id)
    {
        $tour = $this->tourRepository->show($id);
        if ($tour) {
            $reviews = $this->reviewRepository
                ->where('tour_id', $id)
                ->orderBy('created_at', 'desc')
                ->paginate(config('common.list_review'));

            return view('tour.show', [
                'tour' => $tour,
                'reviews' => $reviews,
            ]);
        }

        return redirect()->route('home')->with([
            config('common.flash_notice') => trans('messages.not_found', ['item' => 'Tour']),
            config('common.flash_level_key') => config('common.flash_level.warning'),
        ]);
    }
}
