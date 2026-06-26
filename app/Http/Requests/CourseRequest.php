<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        // Mengambil parameter route 'course'. Jika berupa objek model, ambil id-nya.
        // Jika berupa string/int, gunakan langsung.
        $courseParameter = $this->route('course');
        $id = is_object($courseParameter) ? $courseParameter->id : $courseParameter;

        return [
            'program_id' => ['required', 'exists:programs,id'],
            'code' => ['required', 'string', 'max:20', Rule::unique('courses', 'code')->ignore($id)],
            'name' => ['required', 'string', 'max:150'],
            'sks' => ['required', 'integer', 'min:1', 'max:6'],
            'description' => ['nullable', 'string'],
        ];
    }
}
