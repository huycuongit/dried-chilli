<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\News;


class NewsStoreRequest extends FormRequest
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
                Rule::unique((new News)->getTable())
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
            'name.min' => 'Name must contain at least 5 characters.',
            'name.string' => 'Name must be a string.',
            'name.unique' => 'This name already exists.',

            'news_category_id.required' => 'Please select an article category.',
            'avatar.required' => 'Please select an image.',
        ];
    }
}
