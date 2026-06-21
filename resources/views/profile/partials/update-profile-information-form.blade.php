<section>
    <header class="mb-5">
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
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
            <x-input-error class="mt-1 text-xs text-red-500" :messages="$errors->get('name')" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- NIM / NIDN --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">NIM / NIDN</label>
                <input type="text" name="nim_nidn" value="{{ old('nim_nidn', $user->nim_nidn) }}" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none font-mono">
                <x-input-error class="mt-1 text-xs text-red-500" :messages="$errors->get('nim_nidn')" />
            </div>

            {{-- Alamat Email --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Email Resmi</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                <x-input-error class="mt-1 text-xs text-red-500" :messages="$errors->get('email')" />
            </div>
        </div>

        {{-- Dropdown Program Studi --}}
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Program Studi</label>
            <select name="program_id" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus
