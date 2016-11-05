<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\{CommentCreateRequest, CommentUpdateRequest};
use App\Repositories\Eloquents\CommentRepository;
use App\Repositories\Eloquents\ReviewRepository;
use Auth;

class CommentController extends Controller
{
    protected $commentRepository;
    protected $reviewRepository;
    protected $userId = null;

    public function __construct(CommentRepository $commentRepository, ReviewRepository $reviewRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->reviewRepository = $reviewRepository;
        if (Auth::check()) {
            $this->userId = Auth::user()->id;
        }
    }

    public function store(CommentCreateRequest $request)
    {
        $comment = $this->commentRepository->create([
            'user_id' => $this->userId,
            'review_id' => $request->reviewId,
            'content' => $request->content,
        ]);

        if (!$comment['status']) {
            return [
                'status' => false,
                'message' => trans('user.message.fail'),
            ];
        }

        return [
            'status' => true,
            'htmlComents' => view('includes.comment', ['comment' => $comment['data']])->render(),
        ];
    }

    public function update(CommentUpdateRequest $request, $id)
    {
        $result = $this->commentRepository->where('user_id', $this->userId)->update(
            [
                'content' => $request->content,
            ],
            $id
        );

        return [
            'status' => $result['status'],
        ];
    }

    public function destroy(Request $request, $id)
    {
        $result = $this->commentRepository->where('user_id', $this->userId)->delete($request->commentId);

        return [
            'status' => $result['status'],
        ];
    }
}
