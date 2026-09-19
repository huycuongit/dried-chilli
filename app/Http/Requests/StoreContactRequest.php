<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'required_without:phone', 'email', 'max:255'],
            'phone_country' => ['nullable', 'required_with:phone', 'regex:/^\+[1-9][0-9]{0,3}$/'],
            'phone' => ['nullable', 'required_without:email', 'string', 'regex:/^[0-9\s().-]{6,20}$/'],
            'company' => ['nullable', 'string', 'max:255'],
            'project_type' => ['required', \Illuminate\Validation\Rule::in(array_merge(array_keys(config('nafu-services')), ['business-website', 'ecommerce', 'custom-web-app', 'booking-system', 'general-repairs', 'plumbing', 'electrical', 'other']))],
            'budget' => ['nullable', 'in:under-1000,1000-3000,3000-5000,over-5000,discuss'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'source' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Please enter your full name.',
            'email.required_without' => 'Please enter an email address or phone number.',
            'email.email' => 'Please enter a valid email address.',
            'phone_country.required_with' => 'Please select a country calling code.',
            'phone_country.regex' => 'Please select a valid country calling code.',
            'phone.required_without' => 'Please enter a phone number or email address.',
            'phone.regex' => 'Please enter a valid phone number.',
            'project_type.required' => 'Please select a project type.',
            'message.required' => 'Please tell us what you need.',
            'message.min' => 'Please enter at least 10 characters.',
        ];
    }
}
