<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BookingRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'scheduleId' => 'required|exists:tour_schedules,id',
            'numHuman' => 'required|numeric|min:1',
        ];
    }
}
