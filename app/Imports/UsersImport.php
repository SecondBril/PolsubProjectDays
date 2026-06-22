<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Program;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsOnError; // Ditambahkan agar onError bekerja otomatis
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsOnError
{
    use SkipsErrors;

    // PERBAIKAN 1: Ganti nama properti agar tidak bertabrakan dengan trait
    public $customErrors = [];

    public function model(array $row)
    {
        if (empty($row['name']) || empty($row['email'])) {
            return null;
        }

        $program = null;
        if (!empty($row['program'])) {
            $program = Program::where('name', $row['program'])
                              ->orWhere('code', $row['program'])
                              ->first();
        }

        $role = strtolower($row['role'] ?? 'mahasiswa');

        $user = User::create([
            'name'       => $row['name'],
            'email'      => $row['email'],
            'nim_nidn'   => $row['nim_nidn'],
            'role'       => $role,
            'program_id' => $program ? $program->id : null,
            'password'   => Hash::make($row['password'] ?? $row['nim_nidn']),
            'is_active'  => true,
        ]);

        $user->assignRole($role);

        return $user;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'nim_nidn' => 'required|unique:users,nim_nidn',
            'role'     => 'required|in:dosen,mahasiswa,admin',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        // PERBAIKAN 2: Simpan ke properti baru
        foreach ($failures as $failure) {
            $this->customErrors[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
        }
    }

    public function onError(Throwable $e)
    {
        // PERBAIKAN 3: Simpan ke properti baru
        $this->customErrors[] = "Error sistem: " . $e->getMessage();
    }
}
