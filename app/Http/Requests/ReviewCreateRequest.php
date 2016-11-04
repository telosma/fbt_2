<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ReviewCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|min:' . config('common.limit.review_min'),
            'food' => 'required',
            'place' => 'required',
            'serivce' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => trans('user.message.required_review_content'),
            'food.required' => trans('user.message.rate_required', ['object' => trans('label.review.food')]),
            'place.required' => trans('user.message.rate_required', ['object' => trans('label.review.place')]),
            'serivce.required' => trans('user.message.rate_required', ['object' => trans('label.review.serivce')]),
        ];
    }
}
