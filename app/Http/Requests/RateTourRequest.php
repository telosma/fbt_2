<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RateTourRequest extends Request
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
            'tour_id' => 'required|exists:tours,id',
            'point' => 'required|integer|min:0|max:5',
        ];
    }
}
