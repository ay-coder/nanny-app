<?php

namespace App\Http\Requests\Frontend\User;

use App\Http\Requests\Request;

/**
 * Class PaymentRequest.
 */
class PaymentRequest extends Request
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
            'booking_id' => 'required',
            'payment_id' => 'required',
            'stripeToken' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'booking_id.required' => 'Payment Failed ! Please try again.',
            'payment_id.required' => 'Payment Failed ! Please try again.',
            'stripeToken.required' => 'Payment Failed ! Please try again.',
        ];
    }
}
