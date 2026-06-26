<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_id'      => ['required', 'exists:courses,id'],
            'semester_id'    => ['required', 'exists:semesters,id'],
            'class_code'     => ['required', 'string', 'max:20'],

            // Hapus lecturer_id tunggal, pertahankan yang array ini:
            'lecturer_ids'   => ['nullable', 'array'],
            'lecturer_ids.*' => ['exists:users,id'],
        ];
    }
}
