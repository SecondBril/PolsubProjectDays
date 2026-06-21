<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Models\Program;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */


    public function create(): View
    {
        // Ambil semua data program studi untuk dropdown
        $programs = Program::orderBy('name')->get(); 
        
        return view('auth.register', compact('programs'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    // app/Http/Controllers/Auth/RegisteredUserController.php
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim_nidn' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'program_id' => ['required', 'exists:programs,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'nim_nidn' => $request->nim_nidn,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'program_id' => $request->program_id,
            'is_active' => false, // PENDING APPROVAL OLEH ADMIN
        ]);

        // Assign role default (misal: mahasiswa)
        $user->assignRole('mahasiswa');

        // JANGAN LOGIN OTOMATIS (Hapus event(new Registered($user)); dan Auth::login)
        // event(new Registered($user));
        // Auth::login($user);

        return redirect()->route('login')->with('status', 'Registrasi berhasil! Akun Anda sedang menunggu persetujuan dari Admin JTIK.');
    }
}
