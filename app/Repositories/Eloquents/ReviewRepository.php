<?php

namespace App\Repositories\Eloquents;

use App\Models\Review;
use App\Repositories\Eloquents\CommentRepository;
use DB;

class ReviewRepository extends BaseRepository
{
    protected $commentRepository;

    public function __construct(
        Review $review,
        CommentRepository $commentRepository
    ) {
        parent::__construct();
        $this->model = $review;
        $this->commentRepository = $commentRepository;
    }

    public function model()
    {
        return Review::class;
    }

    public function delete($ids)
    {
        try {
            DB::beginTransaction();
            parent::delete($ids);
            $comments = $this->commentRepository->deleteByReview($ids);
            if (!$comments['status']) {
                throw new \Exception(trans('messages.db_delete_error'));
            }

            DB::commit();

            return [
                'status' => true,
                'data' => $comments,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
