<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ContactRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'phone' => 'required|regex:/(0)[0-9]/|min:10|max:11',
            'subject' => 'min:5',
            'bodyMessage' => 'min:10',
        ];
    }
}
