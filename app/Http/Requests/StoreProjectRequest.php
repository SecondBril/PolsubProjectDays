<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
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
            'team_members' => ['required', 'array', 'min:1', 'max:4'], // Maksimal 4 anggota tambahan
            'team_members.*' => [Rule::exists('users', 'id')],
            'tags' => ['nullable', 'array'],
            'tags.*' => [Rule::exists('tags', 'id')],
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'], // Max 10MB
            'screenshots' => ['nullable', 'array', 'max:5'],
            'screenshots.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'team_lead_id' => 'nullable|exists:users,id',
            'team_name' => 'nullable|string|max:255',
        ];
    }
}
