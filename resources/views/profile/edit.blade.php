@php
    // Tentukan secara dinamis komponen layout pembungkus berdasarkan role pengguna
    $layoutComponent = Auth::user()->hasAnyRole(['admin', 'dosen']) ? 'admin-layout' : 'app-layout';
@endphp

<x-dynamic-component :component="$layoutComponent" title="Pengaturan Profil Akun">
    <div class="max-w-4xl mx-auto space-y-6 px-4 py-2">

        {{-- FLASH ALERT SUCCESS GLOBAL --}}
        @if(session('success'))
            <div class="p-4 bg-teal-500/10 border border-teal-500/30 text-teal-600 rounded-xl text-sm font-medium flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-base"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        {{-- ================================================================== --}}
        {{-- KARTU MODUL 1: INFORMASI AKUN PERSONAL                             --}}
        {{-- ================================================================== --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
            <header class="border-b border-slate-100 pb-4">
                <h2 class="text-base font-bold text-slate-900 tracking-tight">
                    {{ __('Informasi Akun') }}
                </h2>
                <p class="mt-1 text-xs text-textCustom-600">
                    {{ __("Perbarui data identitas profil personal, nomor induk, dan alamat email resmi Anda.") }}
                </p>
            </header>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('patch')

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus
                           class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                    <x-input-error class="mt-1 text-xs text-red-500" :messages="$errors->get('name')" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- NIM / NIDN --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">NIM / NIDN</label>
                        <input type="text" name="nim_nidn" value="{{ old('nim_nidn', $user->nim_nidn) }}" required
                           class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none font-mono">
                        <x-input-error class="mt-1 text-xs text-red-500" :messages="$errors->get('nim_nidn')" />
                    </div>

                    {{-- Alamat Email --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Email Resmi</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                        <x-input-error class="mt-1 text-xs text-red-500" :messages="$errors->get('email')" />
                    </div>
                </div>

                {{-- Dropdown Program Studi --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Program Studi Asal</label>
                    <select name="program_id" required
                            class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ old('program_id', $user->program_id) == $program->id ? 'selected' : '' }}>
                                {{ $program->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-1 text-xs text-red-500" :messages="$errors->get('program_id')" />
                </div>

                <div class="pt-2 flex items-center gap-3">
                    <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs transition-colors shadow-sm">
                        Simpan Identitas
                    </button>

                    @if (session('status') === 'profile-updated')
                        <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-xs text-teal-600 font-medium">
                            <i class="fa-solid fa-check mr-1"></i>Berhasil disimpan.
                        </span>
                    @endif
                </div>
            </form>
        </div>

        {{-- ================================================================== --}}
        {{-- KARTU MODUL 2: PERBARUI KATA SANDI (PASSWORD)                      --}}
        {{-- ================================================================== --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
            <header class="border-b border-slate-100 pb-4">
                <h2 class="text-base font-bold text-slate-900 tracking-tight">
                    {{ __('Perbarui Kata Sandi') }}
                </h2>
                <p class="mt-1 text-xs text-textCustom-600">
                    {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk menjaga keamanan akses.') }}
                </p>
            </header>

            <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('put')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" autocomplete="current-password"
                           class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1 text-xs text-red-500" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kata Sandi Baru</label>
                        <input type="password" name="password" autocomplete="new-password"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1 text-xs text-red-500" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" autocomplete="new-password"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1 text-xs text-red-500" />
                    </div>
                </div>

                <div class="pt-2 flex items-center gap-3">
                    <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs transition-colors shadow-sm">
                        Perbarui Sandi
                    </button>

                    @if (session('status') === 'password-updated')
                        <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-xs text-teal-600 font-medium">
                            <i class="fa-solid fa-check mr-1"></i>Sandi berhasil diubah.
                        </span>
                    @endif
                </div>
            </form>
        </div>

        {{-- ================================================================== --}}
        {{-- KARTU MODUL 3: HAPUS AKUN (DANGER ZONE)                            --}}
        {{-- ================================================================== --}}
        <div class="bg-white p-6 rounded-2xl border border-rose-200/80 shadow-sm space-y-5" x-data="{ confirmDeletion: false }">
            <header class="border-b border-rose-100 pb-4">
                <h2 class="text-base font-bold text-rose-900 tracking-tight">
                    {{ __('Hapus Akun Pengguna') }}
                </h2>
                <p class="mt-1 text-xs text-rose-700/80">
                    {{ __('Setelah akun Anda dihapus, seluruh aset data portofolio, tim, dan riwayat project PBL akan dimusnahkan secara permanen dari basis data.') }}
                </p>
            </header>

            <button type="button" @click="confirmDeletion = true"
                    class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-lg text-xs transition-colors shadow-sm">
                {{ __('Hapus Akun Saya') }}
            </button>

            {{-- MODAL POPUP KONFIRMASI PENGHAPUSAN AKUN PERMANEN (SLIM LOCK 320PX) --}}
            <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-in fade-in duration-200"
                 x-show="confirmDeletion"
                 style="display: none;"
                 x-cloak>

                <div class="bg-white rounded-2xl border border-slate-200 max-w-[320px] w-full overflow-hidden shadow-2xl mx-auto"
                     @click.away="confirmDeletion = false">

                    <div class="p-5 pb-4 text-center">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-sm border border-rose-100 shadow-sm mx-auto mb-3">
                            <i class="fa-solid fa-user-slash"></i>
                        </div>
                        <h3 class="text-[14.5px] font-bold text-slate-900 tracking-tight">Konfirmasi Hapus Akun</h3>
                        <p class="text-[11.5px] text-textCustom-600 mt-2">
                            Masukkan kata sandi Anda untuk memvalidasi perintah penghapusan permanen ini.
                        </p>
                    </div>

                    <form method="post" action="{{ route('profile.destroy') }}" class="inline">
                        @csrf
                        @method('delete')

                        <div class="px-5 pb-4">
                            <input id="password" name="password" type="password" required placeholder="Kata sandi konfirmasi"
                                   class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-rose-500 focus:ring-0 outline-none">
                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1 text-[10.5px] text-red-500 text-left" />
                        </div>

                        <div class="flex items-center justify-end gap-2 p-[12px_20px] border-t border-slate-100 bg-slate-50">
                            <button type="button" @click="confirmDeletion = false"
                                    class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 font-semibold rounded-lg text-[11px]">
                                Batal
                            </button>
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-lg text-[11px] shadow-sm">
                                Ya, Musnahkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-dynamic-component>
