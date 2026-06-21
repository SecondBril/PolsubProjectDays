<x-guest-layout>
    <!-- Header -->
    <div class="mb-6 text-center">
        <a href="/" class="inline-block text-2xl font-extrabold tracking-tight text-navy-900">
            JTIK POLSUB
        </a>
        <h2 class="mt-4 text-xl font-bold text-navy-900">Selamat Datang Kembali</h2>
        <p class="mt-1 text-sm text-slate-500">Masuk dengan NIM/NIDN untuk melanjutkan ke Showcase.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ showPassword: false }">
        @csrf

        <div>
            <label for="nim_nidn" class="block text-sm font-semibold text-slate-700 mb-1.5">NIM / NIDN</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>

                <input id="nim_nidn"
                    type="text"
                    inputmode="numeric"
                    name="nim_nidn"
                    :value="old('nim_nidn')"
                    required
                    autofocus
                    autocomplete="username"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="block w-full appearance-none rounded-lg border border-slate-300 bg-white pl-10 pr-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 sm:text-sm outline-none transition"
                    placeholder="Contoh: 22310001" />
            </div>
            <x-input-error :messages="$errors->get('nim_nidn')" class="mt-2" />
        </div>
        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-navy-700 hover:text-navy-900 transition" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password"
                       class="block w-full appearance-none rounded-lg border border-slate-300 bg-white pl-10 pr-10 py-2.5 text-slate-800 placeholder-slate-400 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 sm:text-sm outline-none transition"
                       placeholder="••••••••" />

                <!-- Toggle Password Visibility -->
                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 outline-none">
                    <svg x-show="!showPassword" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg x-show="showPassword" x-cloak class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-navy-700 focus:ring-navy-500" name="remember">
            <label for="remember_me" class="ml-2 block text-sm text-slate-600">
                Ingat saya
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="flex w-full justify-center rounded-lg bg-navy-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-700 focus:outline-none focus:ring-2 focus:ring-navy-500 focus:ring-offset-2 transition-all duration-150">
                Masuk
            </button>
        </div>

        <!-- Register Link -->
        <p class="text-center text-sm text-slate-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-navy-700 hover:text-navy-900 transition">Daftar sekarang</a>
        </p>
    </form>
</x-guest-layout>
