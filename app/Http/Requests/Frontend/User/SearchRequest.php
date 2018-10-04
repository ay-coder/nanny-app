<?php

namespace App\Http\Requests\Frontend\User;

use App\Http\Requests\Request;

/**
 * Class SearchRequest.
 */
class SearchRequest extends Request
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
            'start_booking_date' => 'required',
            'end_booking_date' => 'required|after:booking_date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'baby_ids' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'baby_ids.required' => 'Please select baby.'
        ];
    }
}
