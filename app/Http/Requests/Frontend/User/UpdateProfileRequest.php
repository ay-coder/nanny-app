<?php

namespace App\Http\Requests\Frontend\User;

use App\Http\Requests\Request;

/**
 * Class UpdateProfileRequest.
 */
class UpdateProfileRequest extends Request
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
        if(access()->user()->user_type !== '1') {
            return [
                'name'  => 'required',
                'email' => 'sometimes|required|email',
            ];
        } else {
            return [
                'name'      => 'required',
                'email'     => 'sometimes|required|email',
                'mobile'    => 'required',
                'birthdate' => 'required',
                'address'   => 'required',
                'gender'    => 'required',
            ];
        }
    }
}
