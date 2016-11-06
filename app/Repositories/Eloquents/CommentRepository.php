<?php

namespace App\Repositories\Eloquents;

use App\Models\Comment;

class CommentRepository extends BaseRepository
{

    public function __construct(Comment $comment)
    {
        parent::__construct();
        $this->model = $comment;
    }

    public function model()
    {
        return Comment::class;
    }

    public function deleteByReview($reviewId)
    {
        try {
            if (!is_array($reviewId)) {
                $reviewId = [$reviewId];
            }

            $reviewDeleted = $this->whereIn('review_id', $reviewId)->remove();

            return [
                'status' => true,
                'data' => $reviewDeleted,
            ];
        } catch (\Exception $ex) {
            return [
                'status' => false,
                'data' => $ex->getMessage(),
            ];
        }
    }
}
