<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\ReviewRepository;

class ReviewController extends Controller
{
    protected $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function index()
    {
        return view('admin.review.list');
    }

    public function ajaxList()
    {
        $data = $this->reviewRepository->with([
                'user' => function ($query) {
                    $query->select(['id', 'name']);
                },
                'tour' => function($query) {
                    $query->select(['id', 'name']);
                }
            ])
            ->withCount('comments')
            ->get();
        if(!$data['status']) {
            return [
                'data' => [],
            ];
        }

        $reviews = $data['data']->toArray();
        foreach ($reviews as &$review) {
            unset($review['content']);
        }

        return [
            'data' => $reviews,
        ];
    }

    public function ajaxDelete(Request $request)
    {
        $response = $this->reviewRepository->delete($request->id);
        if ($response['status']) {
            return [
                config('common.flash_level_key') => config('admin.noty_status.success'),
                config('common.flash_message') => trans('admin.responses.delete', [
                    'status' => trans('admin.status.success'),
                ]),
            ];
        }

        return [
            config('common.flash_level_key') => config('admin.noty_status.error'),
            config('common.flash_message') => trans('admin.responses.delete', [
                'status' => trans('admin.status.fail'),
            ]),
        ];
    }
}
