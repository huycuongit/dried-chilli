<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleStoreRequest extends FormRequest
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
                'string',
                'min:5',
                Rule::unique(Role::class, 'name')
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter a name.',
            'name.min' => 'Name must contain at least 5 characters.',
            'name.unique' => 'This role name already exists.',
        ];
    }
}
