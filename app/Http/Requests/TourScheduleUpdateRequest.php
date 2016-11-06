<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TourScheduleUpdateRequest extends Request
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
            'id' => 'required|exists:tour_schedules,id',
            'tour_id' => 'required|exists:tours,id',
            'revenue_id' => 'exists:revenues,id',
            'start' => 'required|date_format:' . config('common.schedule_date_format'),
            'end' => 'required|date_format:' . config('common.schedule_date_format'),
            'max_slot' => 'required|integer|min:0',
        ];
    }
}
