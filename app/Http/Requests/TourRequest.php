<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TourRequest extends Request
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
            'name' => 'required|unique:tours,name',
            'price' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'num_day' => 'required|integer|min:0',
            'places' => 'array',
        ];
    }
}
