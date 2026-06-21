<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProgramRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('program')?->id;
        return [
            'code' => ['required', 'string', 'max:10', Rule::unique('programs', 'code')->ignore($id)],
            'name' => ['required', 'string', 'max:100'],
            'short_name' => ['required', 'string', 'max:20'],
            'color_code' => ['required', 'string', 'max:7', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'is_active' => ['boolean'],
        ];
    }
}
