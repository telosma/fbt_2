<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SigninRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }

    public function all()
    {
        $attributes = parent::all();
        $attributes['email'] = strtolower($attributes['email']);

        return $attributes;
    }
}
