<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SemesterRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        // Ambil ID semester saat ini jika dalam mode UPDATE/EDIT untuk pengecualian
        $semesterId = $this->route('semester')?->id;

        return [
            'name' => ['required', 'string', 'max:50'],
            'year' => [
                'required',
                'integer',
                'min:2020',
                'max:' . (date('Y') + 2),
                // VALIDASI KRUSIAL: Cek apakah kombinasi year dan term sudah dipakai
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
