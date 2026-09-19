<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\News;

class NewsUpdateRequest extends FormRequest
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
                Rule::unique((new News)->getTable())->ignore($this->id)
            ],
            // 'news_category_id' => [
            //     'required',
            // ],
            'avatar' => [
                'required',
            ],
            'category_name' => ['nullable', 'string', 'max:100'],
            'meta_data.title' => ['nullable', 'string', 'max:255'],
            'meta_data.description' => ['nullable', 'string', 'max:1024'],
            'meta_data.key_words' => ['nullable', 'string', 'max:1024'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter a name.',

            'news_category_id.required' => 'Please select an article category.',
            'avatar.required' => 'Please select an image.',
        ];
    }
}
