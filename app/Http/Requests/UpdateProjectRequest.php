<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization ditangani di Controller
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'program_id' => ['required', Rule::exists('programs', 'id')],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'course_class_id' => ['required', Rule::exists('course_classes', 'id')],
            'cohort' => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'demo_url' => ['nullable', 'url', 'max:500'],
            'repository_url' => ['nullable', 'url', 'max:500'],
            'documentation_url' => ['nullable', 'url', 'max:500'],
            'team_members' => ['nullable', 'array', 'max:4'],
            'team_members.*' => [Rule::exists('users', 'id')],
            'tags' => ['nullable', 'array'],
            'tags.*' => [Rule::exists('tags', 'id')],
            // Nullable karena tidak wajib upload ulang jika tidak diganti
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'screenshots' => ['nullable', 'array', 'max:5'],
            'screenshots.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ];
    }
}
