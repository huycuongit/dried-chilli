<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyCouponRequest extends FormRequest
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
            'code' => 'required|string|exists:coupons,code',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Please enter a coupon code.',
            'code.exists' => 'This coupon code is invalid or does not exist.',
        ];
    }
}
