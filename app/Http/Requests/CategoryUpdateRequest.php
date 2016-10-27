<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CategoryUpdateRequest extends Request
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
            'id' => 'exists:categories,id',
            'name' => 'required|unique:categories,name,' . $this->id,
            'parent_id' => 'exists:categories,id|not_in:' . $this->id,
        ];
    }
}
