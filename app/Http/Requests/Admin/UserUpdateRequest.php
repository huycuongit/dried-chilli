<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\Admin;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:5',
                Rule::unique((new Admin)->getTable())->ignore($this->id)
            ],
            'email' => [
                'required',
                'email',
                Rule::unique((new Admin)->getTable())->ignore($this->id)
            ],
            // 'phone' => [
            //     'numeric',
            //     Rule::unique((new Admin)->getTable())->ignore($this->id)
            // ],
            'roles' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter a name.',
            'name.min' => 'Name must contain at least 5 characters.',
            'name.unique' => 'This name already exists.',

            'email.required' => 'Please enter an email address.',
            'email.email' => 'Invalid email address.',
            'email.unique' => 'This email address already exists.',

            'phone.numeric' => 'Phone number must contain digits only.',
            'phone.unique' => 'This phone number already exists.',
            'roles.required' => 'Please select a role.',
        ];
    }
}
