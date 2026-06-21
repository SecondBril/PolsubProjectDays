<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program; // Pastikan model Program diimpor untuk dropdown form
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Notifications\UserApprovedNotification;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('program')->latest();

        // Fitur Pencarian Nama / NIM
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nim_nidn', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->where('is_active', false);
            } elseif ($request->status === 'active') {
                $query->where('is_active', true);
            }
        }

        $users = $query->paginate(15)->withQueryString();
        $programs = Program::all(); // Diperlukan untuk dropdown pilihan prodi di modal

        return view('admin.users.index', compact('users', 'programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nim_nidn' => 'required|string|max:50|unique:users',
            'role' => 'required|in:admin,dosen,mahasiswa',
            'program_id' => 'required_if:role,mahasiswa|nullable|exists:programs,id',
            'password' => 'required|string|min:8',
        ]);

        // 1. Buat User baru dan tampung ke dalam variabel $user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nim_nidn' => $validated['nim_nidn'],
            'role' => $validated['role'], // Tetap diisi untuk dokumentasi kolom lokal
            'program_id' => $validated['role'] === 'mahasiswa' ? $validated['program_id'] : null,
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        // 2. KUNCI UTAMA: Daftarkan role ke sistem Spatie agar terindeks di tabel pivot
        $user->assignRole($validated['role']);

        return back()->with('success', 'User baru berhasil dibuat dan role Spatie berhasil disinkronkan.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            'nim_nidn' => ['required', 'string', 'max:50', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,dosen,mahasiswa',
            'program_id' => 'required_if:role,mahasiswa|nullable|exists:programs,id',
            'password' => 'nullable|string|min:8',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nim_nidn' => $validated['nim_nidn'],
            'role' => $validated['role'],
            'program_id' => $validated['role'] === 'mahasiswa' ? $validated['program_id'] : null,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        // KUNCI UTAMA: Hapus role lama dan sinkronkan dengan role Spatie yang baru
        $user->syncRoles([$validated['role']]);

        return back()->with('success', 'Data profil dan hak akses pengguna berhasil diperbarui.');
    }

    public function approve(User $user)
    {
        $user->update(['is_active' => true]);
        $user->notify(new UserApprovedNotification($user->role ?? 'mahasiswa'));
        return back()->with('success', 'Akun berhasil diaktifkan dan user telah dinotifikasi via email.');
    }

    public function reject(User $user)
    {
        $user->delete();
        return back()->with('success', 'Akun pendaftaran ditolak dan data telah dihapus.');
    }
}
