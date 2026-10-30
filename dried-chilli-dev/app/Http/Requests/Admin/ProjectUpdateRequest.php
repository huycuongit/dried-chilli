<?php

namespace App\Http\Requests\Admin;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectUpdateRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', Rule::unique(Project::class)->ignore($this->route('id'))],
            'avatar' => ['required', 'string'],
            'description' => ['required', 'string', 'max:2000'],
            'content' => ['nullable', 'string'],
        ];
    }
}
