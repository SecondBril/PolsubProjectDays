<x-admin-layout title="Manajemen Pengguna">
    <div class="space-y-6" x-data="{ openCreateModal: false, openEditModal: false, openRejectModal: false, currentUser: {} }">

        {{-- Flash Message Success --}}
        @if(session('success'))
            <div class="p-4 bg-teal-500/10 border border-teal-500/30 text-teal-600 rounded-xl text-sm font-medium flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-base"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        {{-- BARIS TOP PANEL: FILTER & ADD BUTTON --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-2.5 w-full sm:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIM/NIDN, email..." class="border border-slate-200 bg-surface rounded-lg px-3 py-1.5 text-xs text-textCustom-900 focus:border-teal-500 focus:ring-0 outline-none w-full sm:w-64 placeholder-slate-400">

                <select name="status" onchange="this.form.submit()" class="border border-slate-200 bg-surface rounded-lg px-3 py-1.5 text-xs text-textCustom-900 focus:border-teal-500 focus:ring-0 outline-none">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                </select>

                @if(request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('admin.users.index') }}" class="text-xs text-red-500 font-medium hover:underline px-1">Reset</a>
                @endif
            </form>

            <button type="button" @click="openCreateModal = true" class="w-fit flex items-center justify-center gap-2 px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors shrink-0">
                <i class="fa-solid fa-user-plus text-[13px]"></i> Tambah Akun Baru
            </button>
        </div>

        {{-- TABEL DATA PENGGUNA --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-textCustom-400 font-bold text-[11px] uppercase tracking-wider">
                            <th class="py-3.5 px-5">Pengguna / Identitas</th>
                            <th class="py-3.5 px-5">Kontak &amp; Akun</th>
                            <th class="py-3.5 px-5">Role / Prodi</th>
                            <th class="py-3.5 px-5 text-center">Status</th>
                            <th class="py-3.5 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-textCustom-900 font-medium">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-slate-100 font-bold text-slate-700 flex items-center justify-center uppercase shrink-0">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-slate-900 text-sm">{{ $user->name }}</span>
                                            <span class="text-textCustom-400 text-[11px] font-mono mt-0.5">ID: {{ $user->nim_nidn }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-5">
                                    <div class="flex flex-col">
                                        <span>{{ $user->email }}</span>
                                        <span class="text-[10px] text-textCustom-400 mt-0.5">Dibuat: {{ $user->created_at->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-5">
                                    <div class="flex flex-col">
                                        <span class="capitalize text-slate-800 font-semibold">{{ $user->role }}</span>
                                        <span class="text-textCustom-400 text-[11px] mt-0.5">{{ $user->program->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-center">
                                    @if($user->is_active)
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-teal-500/10 text-teal-600 border border-teal-500/20">Aktif</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-600 border border-amber-500/20 animate-pulse">Menunggu</span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        @if(!$user->is_active)
                                            {{-- Tombol Approve (Tetap Menggunakan Form POST Langsung) --}}
                                            <form method="POST" action="{{ route('admin.users.approve', $user->id) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="p-1.5 bg-teal-500/10 text-teal-600 border border-teal-500/20 rounded-md hover:bg-teal-500 hover:text-white transition-all" title="Setujui Akun">
                                                    <i class="fa-solid fa-check text-[13px] px-0.5"></i>
                                                </button>
                                            </form>

                                            {{-- TOMBOL REJECT KUSTOM (Memicu Pop-up Modal) --}}
                                            <button type="button"
                                                    @click="currentUser = {{ json_encode($user) }}; openRejectModal = true"
                                                    class="p-1.5 bg-rose-500/10 text-rose-600 border border-rose-500/20 rounded-md hover:bg-rose-500 hover:text-white transition-all"
                                                    title="Tolak Registrasi">
                                                <i class="fa-solid fa-xmark text-[13px] px-0.5"></i>
                                            </button>
                                        @endif

                                        {{-- Tombol Edit Trigger --}}
                                        <button type="button" @click="currentUser = {{ json_encode($user) }}; openEditModal = true" class="p-1.5 bg-slate-100 text-slate-600 border border-slate-200 rounded-md hover:bg-navy-900 hover:text-white transition-all" title="Edit Data">
                                            <i class="fa-solid fa-pen-to-square text-[13px]"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-textCustom-400 font-medium">
                                    Tidak ada data pengguna yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            @if($users->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        {{-- ========================================== --}}
        {{-- MODAL MODUL 1: TAMBAH USER BARU            --}}
        {{-- ========================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-show="openCreateModal" x-transition style="display: none;">
            <div class="bg-white rounded-2xl border border-slate-200 max-w-md w-full overflow-hidden shadow-2xl" @click.away="openCreateModal = false">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-bold text-base text-slate-900">Tambah Akun Baru</h3>
                    <button type="button" @click="openCreateModal = false" class="text-slate-400 hover:text-slate-600 text-sm"><i class="fa-solid fa-xmark text-base"></i></button>
                </div>
                <form method="POST" action="{{ route('admin.users.store') }}" class="p-5 space-y-4" x-data="{ currentRole: 'mahasiswa' }">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Email Resmi</label>
                            <input type="email" name="email" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">NIM / NIDN</label>
                            <input type="text" name="nim_nidn" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Hak Akses (Role)</label>
                        <select name="role" x-model="currentRole" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0">
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                    <div x-show="currentRole === 'mahasiswa'">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Program Studi</label>
                        <select name="program_id" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0">
                            <option value="">-- Pilih Program Studi --</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kata Sandi (Password)</label>
                        <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0">
                    </div>
                    <div class="pt-2 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="openCreateModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs transition-colors shadow-sm">Simpan Akun</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- MODAL MODUL 2: EDIT USER DATA              --}}
        {{-- ========================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-show="openEditModal" x-transition style="display: none;">
            <div class="bg-white rounded-2xl border border-slate-200 max-w-md w-full overflow-hidden shadow-2xl" @click.away="openEditModal = false">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-bold text-base text-slate-900">Ubah Data Pengguna</h3>
                    <button type="button" @click="openEditModal = false" class="text-slate-400 hover:text-slate-600 text-sm"><i class="fa-solid fa-xmark text-base"></i></button>
                </div>
                <form method="POST" :action="`{{ url('admin/users') }}/${currentUser.id}`" class="p-5 space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" :value="currentUser.name" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Email Resmi</label>
                            <input type="email" name="email" :value="currentUser.email" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">NIM / NIDN</label>
                            <input type="text" name="nim_nidn" :value="currentUser.nim_nidn" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Hak Akses (Role)</label>
                        <select name="role" x-model="currentUser.role" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0">
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                    <div x-show="currentUser.role === 'mahasiswa'">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Program Studi</label>
                        <select name="program_id" x-model="currentUser.program_id" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0">
                            <option value="">-- Pilih Program Studi --</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Ubah Kata Sandi (Opsional)</label>
                        <span class="text-[10px] text-textCustom-400 block mb-2">Kosongkan kolom di bawah jika tidak ingin mengubah sandi lama.</span>
                        <input type="password" name="password" placeholder="Masukkan password baru" class="w-full border border-slate-200 bg-white rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0">
                    </div>
                    <div class="pt-2 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs transition-colors shadow-sm">Perbarui Data</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- MODAL MODUL 3: POP-UP REJECT KUSTOM       --}}
        {{-- ========================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4"
            x-show="openRejectModal"
            x-transition
            style="display: none;">

            <div class="bg-white rounded-2xl border border-slate-200 max-w-sm overflow-hidden shadow-2xl"
                @click.away="openRejectModal = false">

                <div class="p-6 pb-4">
                    {{-- Icon Peringatan Bahaya --}}
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg mb-4 shadow-sm border border-rose-100">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>

                    {{-- Konten Informasi Akun Terkait --}}
                    <div class="leading-relaxed">
                        <h3 class="text-base font-bold text-slate-900 mb-1">Tolak Pendaftaran Pengguna?</h3>
                        <p class="text-xs text-textCustom-600">
                            Akun atas nama <span class="font-semibold text-slate-900" x-text="currentUser.name"></span>
                            (<span class="font-mono text-[11px]" x-text="currentUser.nim_nidn"></span>) akan ditolak dan dihapus secara permanen dari basis data antrean masuk sistem.
                        </p>
                    </div>
                </div>

                {{-- Aksi Submit Form Pembatalan Sesi --}}
                <div class="flex items-center justify-end gap-2 p-2 border-t border-slate-100 bg-slate-50">
                    <button type="button"
                            @click="openRejectModal = false"
                            class="px-4 py-2 bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 font-semibold rounded-lg text-xs transition-colors">
                        Batal
                    </button>

                    <form method="POST" :action="`{{ url('admin/users') }}/${currentUser.id}/reject`" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-lg text-xs transition-colors shadow-sm">
                            <i class="fa-regular fa-trash-can"></i> Ya, Tolak &amp; Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
