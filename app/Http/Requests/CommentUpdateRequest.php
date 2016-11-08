<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CommentUpdateRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'content' => 'required',
            'commentId' => 'required|exists:comments,id',
        ];
    }
}
