<?php

namespace App\Http\Requests\Admin;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceUpdateRequest extends FormRequest
{
    public function messages()
    {
        return [
            'slug.regex' => 'English slug may contain lowercase letters, numbers and hyphens only.',
            'slug.unique' => 'This English slug is already in use.',
        ];
    }

    public function authorize() { return true; }
    public function rules()
    {
        return [
            'contract_price' => ['nullable', 'numeric', 'min:0', 'max:9999999999999'],
            'name' => ['required', 'string', 'max:255', Rule::unique(Service::class)->ignore($this->id)],
            'slug' => ['nullable', 'string', 'max:240', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique(Service::class, 'slug')->ignore($this->route('id'))],
            'description' => ['required', 'string'],
            'benefits' => ['nullable', 'string', 'max:5000'],
            'content' => ['nullable', 'string'],
            'meta_data.title' => ['nullable', 'string', 'max:255'],
            'meta_data.description' => ['nullable', 'string', 'max:1024'],
            'meta_data.key_words' => ['nullable', 'string', 'max:1024'],
            'avatar' => ['required', 'string'],
            'position' => ['required', 'integer', 'min:0'],
            'active' => ['required', 'boolean'],
        ];
    }
}
