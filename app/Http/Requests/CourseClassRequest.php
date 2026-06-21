<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CourseClassRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'course_id' => ['required', 'exists:courses,id'],
            'semester_id' => ['required', 'exists:semesters,id'],
            'lecturer_id' => ['required', 'exists:users,id'], // Di View nanti difilter hanya role Dosen
            'lecturer_ids' => ['required', 'array'],
            'lecturer_ids.*' => ['required', 'exists:users,id'],
            'class_code' => ['required', 'string', 'max:20'],
        ];
    }
}
