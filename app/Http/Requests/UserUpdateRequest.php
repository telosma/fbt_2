<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserUpdateRequest extends Request
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
            'id' => 'exists:users,id',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->id,
        ];
    }

    public function all()
    {
        $attributes = parent::all();
        $attributes['email'] = strtolower($attributes['email']);

        return $attributes;
    }
}
