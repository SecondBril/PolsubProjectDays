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

            // Anggota tambahan bersifat opsional (karena minimal kelompok bisa saja 1 orang yaitu ketua sendiri)
            'team_members' => ['nullable', 'array', 'max:4'],

            // PERBAIKAN: Gunakan 'distinct' agar ID anggota tidak boleh kembar di form,
            // dan pastikan ID anggota tidak sama dengan ID ketua yang sedang dipilih/dikunci.
            'team_members.*.user_id' => [
                'required',
                'distinct',
                Rule::exists('users', 'id'),
                function ($attribute, $value, $fail) use ($isAdminOrDosen) {
                    $targetLeadId = $isAdminOrDosen ? $this->input('team_lead_id') : Auth::id();
                    if ($value == $targetLeadId) {
                        $fail('Mahasiswa yang dipilih sebagai ketua tidak boleh dimasukkan kembali sebagai anggota tambahan.');
                    }
                }
            ],
            'team_members.*.contribution' => ['required_with:team_members.*.user_id', 'string', 'max:1000'],

            // PERBAIKAN: Aturan kondisional dibersihkan dari string 'nullable' yang kontradiktif
            'leader_contribution' => [
                $isAdminOrDosen ? 'nullable' : 'required',
                'string',
                'max:1000'
            ],

            'tags' => ['nullable', 'array'],
            'tags.*' => [Rule::exists('tags', 'id')],
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'screenshots' => ['nullable', 'array', 'max:5'],
            'screenshots.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],

            // PERBAIKAN: Jika yang input Admin/Dosen, team_lead_id WAJIB ditentukan
            'team_lead_id' => [
                $isAdminOrDosen ? 'required' : 'nullable',
                Rule::exists('users', 'id')
            ],

            'team_name' => 'nullable|string|max:255',
            'features' => ['nullable', 'array'],
            'features.*.name' => ['required_with:features.*.icon', 'string', 'max:255'],
            'features.*.icon' => ['required_with:features.*.name', 'string', 'max:100'],
        ];
    }
}
