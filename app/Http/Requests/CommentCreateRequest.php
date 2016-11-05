<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CommentCreateRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'content' => 'required',
            'reviewId' => 'required|exists:reviews,id',
        ];
    }
}
