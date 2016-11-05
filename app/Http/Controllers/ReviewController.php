<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewCreateRequest;
use App\Repositories\Eloquents\{ReviewRepository, TourRepository};
use Auth;

class ReviewController extends Controller
{
    protected $reviewRepository;
    protected $userId = null;

    public function __construct(ReviewRepository $reviewRepository, TourRepository $tourRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->tourRepository = $tourRepository;
        if (Auth::check()) {
            $this->userId = Auth::user()->id;
        }
    }

    public function postCreate(ReviewCreateRequest $request)
    {
        $tour = $this->tourRepository->find($request->tourId);
        if ($tour['status']) {
            $review = $this->reviewRepository->create([
                'user_id' => $this->userId,
                'tour_id' => $request->tourId,
                'content' => $request->content,
                'rated_food' => $request->food,
                'rated_place' => $request->place,
                'rated_service' => $request->serivce,
            ]);
            if ($review['status']) {
                $message = [
                    config('common.flash_notice') => trans('user.message.success_review'),
                    config('common.flash_level_key') => config('common.flash_level.success'),
                ];
            } else {
                $message = [
                    config('common.flash_notice') => trans('user.message.fail'),
                    config('common.flash_level_key') => config('common.flash_level.danger'),
                ];
            }
        } else {
            $message = [
                config('common.flash_notice') => trans('user.message.null_tour'),
                config('common.flash_level_key') => config('common.flash_level.danger'),
            ];
        }

        return redirect()->back()->with($message);
    }
}
