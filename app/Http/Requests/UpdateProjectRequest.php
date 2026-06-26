<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pastikan diaktifkan jika otentikasi tidak dicek manual di Controller
        return Auth::check();
    }

    public function rules(): array
    {
        // Ambil objek user yang sedang berinteraksi dengan request
        $isAdminOrDosen = $this->user()?->hasAnyRole(['admin', 'dosen']);

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

            // --- VALIDASI TIM TERBARU (SAMA DENGAN STORE) ---
            'team_members' => ['required', 'array', 'min:1', 'max:4'],
            'team_members.*.user_id' => [
                'required',
                'distinct',
                Rule::exists('users', 'id'),
                function ($attribute, $value, $fail) use ($isAdminOrDosen) {
                    // Cari tahu siapa lead-nya pada request update ini
                    $targetLeadId = $isAdminOrDosen ? $this->input('team_lead_id') : Auth::id();
                    if ($value == $targetLeadId) {
                        $fail('Mahasiswa yang bertindak sebagai ketua tidak boleh dimasukkan kembali sebagai anggota tambahan.');
                    }
                }
            ],
            'team_members.*.contribution' => ['required_with:team_members.*.user_id', 'string', 'max:1000'],

            'leader_contribution' => [
                $isAdminOrDosen ? 'nullable' : 'required',
                'string',
                'max:1000'
            ],

            'team_lead_id' => [
                $isAdminOrDosen ? 'required' : 'nullable',
                Rule::exists('users', 'id')
            ],
            'team_name' => ['nullable', 'string', 'max:255'],

            // --- VALIDASI MEDIA (NULLABLE UNTUK UPDATE) ---
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'screenshots' => ['nullable', 'array', 'max:5'],
            'screenshots.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],

            // --- VALIDASI TAGS & FEATURES ---
            'tags' => ['nullable', 'array'],
            'tags.*' => [Rule::exists('tags', 'id')],
            'features' => ['nullable', 'array'],
            'features.*.name' => ['required_with:features.*.icon', 'string', 'max:255'],
            'features.*.icon' => ['required_with:features.*.name', 'string', 'max:100'],
        ];
    }
}
