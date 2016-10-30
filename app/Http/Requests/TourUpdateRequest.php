<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TourUpdateRequest extends Request
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
            'id' => 'required|exists:tours,id',
            'name' => 'required|unique:tours,name,' . $this->id,
            'price' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'num_day' => 'required|integer|min:0',
            'places' => 'array',
        ];
    }
}
