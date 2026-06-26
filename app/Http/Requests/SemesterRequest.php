<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SemesterRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        // Mengamankan pengambilan ID, baik route menggunakan parameter {semester} atau {id}
        $semesterParameter = $this->route('semester') ?? $this->route('id');
        $semesterId = is_object($semesterParameter) ? $semesterParameter->id : $semesterParameter;

        return [
            'name' => ['required', 'string', 'max:50'],
            'year' => [
                'required',
                'integer',
                'min:2020',
                'max:' . (date('Y') + 2),
                Rule::unique('semesters', 'year')->where(function ($query) {
                    return $query->where('term', $this->term);
                })->ignore($semesterId)
            ],
            'term' => ['required', 'in:Ganjil,Genap'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * Kustomisasi pesan error agar Admin paham apa yang salah
     */
    public function messages(): array
    {
        return [
            'year.unique' => 'Kombinasi Tahun Akademik dan Sesi Term (Ganjil/Genap) tersebut sudah terdaftar di sistem!',
        ];
    }
}
