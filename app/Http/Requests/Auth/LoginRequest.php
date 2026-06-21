<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 1. Ganti validasi 'email' menjadi 'nim_nidn'
            'nim_nidn' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // 2. Ganti 'email' menjadi 'nim_nidn' pada Auth::attempt
        if (! Auth::attempt($this->only('nim_nidn', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'nim_nidn' => trans('auth.failed'), // 3. Ganti key error menjadi nim_nidn
            ]);
        }

        // LOGIKA APPROVAL: Cek apakah akun sudah diaktifkan admin
        if (! Auth::user()->is_active) {
            Auth::logout();
            // Hapus session agar tidak tetap login
            $this->session()->invalidate();
            $this->session()->regenerateToken();

            throw ValidationException::withMessages([
                'nim_nidn' => 'Akun Anda belum diaktifkan oleh Administrator. Silakan hubungi Admin JTIK.',
            ]);
        }

        // Update last_login_at
        Auth::user()->update(['last_login_at' => now()]);

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'nim_nidn' => trans('auth.throttle', [ // Ganti key error
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        // 4. Ganti 'email' menjadi 'nim_nidn' untuk rate limiting
        return Str::transliterate(Str::lower($this->string('nim_nidn')).'|'.$this->ip());
    }
}
