<x-admin-layout title="Kelola Program Studi">
    <div class="space-y-6" x-data="{ openCreateModal: false, openEditModal: false, openDeleteModal: false, currentProgram: {} }">

        {{-- FLASH MESSAGE SUCCESS --}}
        @if(session('success'))
            <div class="p-4 bg-teal-500/10 border border-teal-500/30 text-teal-600 rounded-xl text-sm font-medium flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-base"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        {{-- TOP PANEL CONTROL --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div>
                <p class="text-textCustom-600 text-xs">Manajemen data master Program Studi di lingkungan POLS-HUB JTIK.</p>
            </div>
            <button type="button" @click="openCreateModal = true" class="w-fit flex items-center justify-center gap-2 px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors shrink-0">
                <i class="fa-solid fa-plus text-[12px]"></i> Tambah Prodi
            </button>
        </div>

        {{-- DATA MASTER TABLE --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-textCustom-400 font-bold text-[11px] uppercase tracking-wider">
                            <th class="py-3.5 px-5 w-24">Kode Prodi</th>
                            <th class="py-3.5 px-5">Nama Program Studi</th>
                            <th class="py-3.5 px-5">Singkatan</th>
                            <th class="py-3.5 px-5">Label Warna</th>
                            <th class="py-3.5 px-5 text-center w-24">Status</th>
                            <th class="py-3.5 px-5 text-right w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-textCustom-900 font-medium">
                        @forelse($programs as $program)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-5 font-mono font-bold text-slate-600">
                                    {{ $program->code }}
                                </td>
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-3 h-3 rounded-full shrink-0 shadow-sm" style="background-color: {{ $program->color_code }}"></div>
                                        <span class="font-semibold text-slate-900 text-sm">{{ $program->name }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-5 font-semibold text-slate-700">
                                    {{ $program->short_name }}
                                </td>
                                <td class="py-4 px-5 font-mono text-slate-500">
                                    <span class="px-2 py-0.5 rounded border border-slate-200 bg-slate-50 text-[11px]">{{ $program->color_code }}</span>
                                </td>
                                <td class="py-4 px-5 text-center">
                                    @if($program->is_active ?? true)
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-teal-500/10 text-teal-600 border border-teal-500/20">Aktif</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-400 border border-slate-200">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button"
                                                @click="currentProgram = {{ json_encode($program) }}; openEditModal = true"
                                                class="p-1.5 bg-slate-100 text-slate-600 border border-slate-200 rounded-md hover:bg-navy-900 hover:text-white transition-all">
                                            <i class="fa-solid fa-pen-to-square text-[13px]"></i>
                                        </button>
                                        <button type="button"
                                                @click="currentProgram = {{ json_encode($program) }}; openDeleteModal = true"
                                                class="p-1.5 bg-rose-500/10 text-rose-600 border border-rose-500/20 rounded-md hover:bg-rose-500 hover:text-white transition-all">
                                            <i class="fa-regular fa-trash-can text-[13px]"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-textCustom-400 font-medium">
                                    Belum ada data program studi terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- MODAL 1: CREATE PROGRAM STUDI              --}}
        {{-- ========================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-in fade-in duration-200" x-show="openCreateModal" style="display: none;">
            <div class="bg-white rounded-2xl border border-slate-200 max-w-md overflow-hidden shadow-2xl" @click.away="openCreateModal = false">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-bold text-base text-slate-900">Tambah Program Studi</h3>
                    <button type="button" @click="openCreateModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-base"></i></button>
                </div>
                <form method="POST" action="{{ route('admin.programs.store') }}" class="p-5 space-y-4">
                    @csrf
                    <div class="grid grid-cols-3 gap-3">
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kode Prodi <span class="text-rose-500">*</span></label>
                            <input type="text" name="code" required placeholder="TRPL" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none uppercase">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Singkat <span class="text-rose-500">*</span></label>
                            <input type="text" name="short_name" required placeholder="Teknologi Rekayasa Perangkat Lunak" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Panjang Program Studi <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="D4 Teknologi Rekayasa Perangkat Lunak" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kode Warna Tema <span class="text-rose-500">*</span></label>
                        <div class="flex gap-2">
                            <input type="color" name="color_code" id="color_picker_create" value="#0EA5E9" class="w-8 h-8 rounded border border-slate-200 cursor-pointer p-0 overflow-hidden bg-transparent" oninput="document.getElementById('color_text_create').value = this.value">
                            <input type="text" id="color_text_create" value="#0EA5E9" class="border border-slate-200 rounded-lg px-3 py-1 text-xs focus:border-teal-500 focus:ring-0 outline-none uppercase font-mono w-28" readonly>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 py-1">
                        <input type="checkbox" name="is_active" id="is_active_create" checked value="1" class="rounded border-slate-200 text-teal-500 focus:ring-0">
                        <label for="is_active_create" class="text-xs font-semibold text-slate-700 cursor-pointer">Aktifkan Program Studi</label>
                    </div>
                    <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="openCreateModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs transition-colors shadow-sm">Simpan Prodi</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- MODAL 2: EDIT PROGRAM STUDI                --}}
        {{-- ========================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-in fade-in duration-200" x-show="openEditModal" style="display: none;">
            <div class="bg-white rounded-2xl border border-slate-200 max-w-md overflow-hidden shadow-2xl" @click.away="openEditModal = false">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-bold text-base text-slate-900">Ubah Program Studi</h3>
                    <button type="button" @click="openEditModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-base"></i></button>
                </div>
                <form method="POST" :action="`{{ url('admin/programs') }}/${currentProgram.id}`" class="p-5 space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-3 gap-3">
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kode Prodi <span class="text-rose-500">*</span></label>
                            <input type="text" name="code" :value="currentProgram.code" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none uppercase">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Singkat <span class="text-rose-500">*</span></label>
                            <input type="text" name="short_name" :value="currentProgram.short_name" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Panjang Program Studi <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" :value="currentProgram.name" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kode Warna Tema <span class="text-rose-500">*</span></label>
                        <div class="flex gap-2">
                            <input type="color" name="color_code" id="color_picker_edit" :value="currentProgram.color_code" class="w-8 h-8 rounded border border-slate-200 cursor-pointer p-0 overflow-hidden bg-transparent" oninput="document.getElementById('color_text_edit').value = this.value">
                            <input type="text" id="color_text_edit" :value="currentProgram.color_code" class="border border-slate-200 rounded-lg px-3 py-1 text-xs focus:border-teal-500 focus:ring-0 outline-none uppercase font-mono w-28" readonly>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 py-1">
                        <input type="checkbox" name="is_active" id="is_active_edit" value="1" :checked="currentProgram.is_active" class="rounded border-slate-200 text-teal-500 focus:ring-0">
                        <label Bureau for="is_active_edit" class="text-xs font-semibold text-slate-700 cursor-pointer">Program Studi Aktif</label>
                    </div>
                    <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs transition-colors shadow-sm">Perbarui Prodi</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- MODAL 3: DELETE CONFIRMATION (SLIM - 320PX) --}}
        {{-- ========================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-in fade-in duration-200" x-show="openDeleteModal" style="display: none;">
            <div class="bg-white rounded-2xl border border-slate-200 max-w-[320px] overflow-hidden shadow-2xl mx-auto" @click.away="openDeleteModal = false">
                <div class="p-5 pb-4 text-center">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-sm shrink-0 border border-rose-100 shadow-sm mx-auto mb-3">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="leading-relaxed">
                        <h3 class="text-[14.5px] font-bold text-slate-900 tracking-tight">Hapus Program Studi?</h3>
                        <p class="text-[11.5px] text-textCustom-600 mt-1">
                            Program Studi <span class="font-semibold text-slate-900" x-text="currentProgram.name"></span> akan dihapus permanen dari sistem beserta data ikatan akademik di dalamnya.
                        </p>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-2 p-2 border-t border-slate-100 bg-slate-50">
                    <button type="button" @click="openDeleteModal = false" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 font-semibold rounded-lg text-[11px] transition-colors">
                        Batal
                    </button>
                    <form method="POST" :action="`{{ url('admin/programs') }}/${currentProgram.id}`" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg text-[11px] transition-colors shadow-sm">
                            <i class="fa-regular fa-trash-can"></i> Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
