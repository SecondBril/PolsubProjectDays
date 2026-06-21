<x-admin-layout title="Tag Teknologi">
    <div class="space-y-6" x-data="{ openCreateModal: false, openEditModal: false, openDeleteModal: false, currentTag: {} }">

        {{-- FLASH MESSAGE NOTIFICATION --}}
        @if(session('success'))
            <div class="p-4 bg-teal-500/10 border border-teal-500/30 text-teal-600 rounded-xl text-sm font-medium flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-base"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-rose-500/10 border border-rose-500/30 text-rose-600 rounded-xl text-sm font-medium flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation text-base"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        {{-- TOP CONTROL PANEL --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div>
                <p class="text-textCustom-600 text-xs">Kelola tag ekosistem teknologi (Framework, Library, Bahasa Pemrograman) luaran PBL.</p>
            </div>
            <button type="button" @click="openCreateModal = true" class="w-fit flex items-center justify-center gap-2 px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors shrink-0">
                <i class="fa-solid fa-plus text-[12px]"></i> Tambah Tag
            </button>
        </div>

        {{-- MASTER DATA TABLE --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-textCustom-400 font-bold text-[11px] uppercase tracking-wider">
                            <th class="py-3.5 px-5">Nama Tag Teknologi</th>
                            <th class="py-3.5 px-5">Slug URI</th>
                            <th class="py-3.5 px-5 text-center w-36">Digunakan Oleh</th>
                            <th class="py-3.5 px-5 text-right w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-textCustom-900 font-medium">
                        @forelse($tags as $tag)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-2.5">
                                        <i class="fa-solid fa-tag text-slate-400 text-[11px]"></i>
                                        <span class="font-semibold text-slate-900 text-sm bg-slate-50 border border-slate-200 px-2.5 py-0.5 rounded-md shadow-sm">{{ $tag->name }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-5 font-mono text-textCustom-400 text-[11px]">{{ $tag->slug }}</td>
                                <td class="py-4 px-5 text-center">
                                    @if($tag->projects_count > 0)
                                        <span class="inline-flex px-2.5 py-0.5 rounded font-bold bg-indigo-50 border border-indigo-200 text-indigo-600 font-mono text-[11px]">
                                            {{ $tag->projects_count }} Project
                                        </span>
                                    @else
                                        <span class="text-textCustom-400 italic text-[11px]">Belum dipakai</span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        {{-- Edit Trigger Button --}}
                                        <button type="button"
                                                @click="currentTag = {{ json_encode($tag) }}; openEditModal = true"
                                                class="p-1.5 bg-slate-100 text-slate-600 border border-slate-200 rounded-md hover:bg-navy-900 hover:text-white transition-all" title="Ubah Data">
                                            <i class="fa-solid fa-pen-to-square text-[13px]"></i>
                                        </button>

                                        {{-- Delete Trigger Button --}}
                                        <button type="button"
                                                @click="currentTag = {{ json_encode($tag) }}; openDeleteModal = true"
                                                class="p-1.5 bg-rose-500/10 text-rose-600 border border-rose-500/20 rounded-md hover:bg-rose-500 hover:text-white transition-all" title="Hapus Tag">
                                            <i class="fa-regular fa-trash-can text-[13px]"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-textCustom-400 font-medium">
                                    Belum ada data tag teknologi terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tags->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $tags->links() }}
                </div>
            @endif
        </div>

        {{-- ========================================== --}}
        {{-- MODAL 1: TAMBAH TAG BARU                   --}}
        {{-- ========================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-in fade-in duration-200" x-show="openCreateModal" style="display: none;">
            <div class="bg-white rounded-2xl border border-slate-200 max-w-sm w-full overflow-hidden shadow-2xl" @click.away="openCreateModal = false">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-bold text-base text-slate-900">Tambah Tag Baru</h3>
                    <button type="button" @click="openCreateModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-base"></i></button>
                </div>
                <form method="POST" action="{{ route('admin.tags.store') }}" class="p-5 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Tag / Teknologi <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="Contoh: Tailwind CSS, Flutter, Laravel" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kustom Kunci Slug (Opsional)</label>
                        <input type="text" name="slug" placeholder="Kosongkan untuk auto-slug otomasi" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none font-mono">
                    </div>
                    <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="openCreateModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs transition-colors shadow-sm">Simpan Tag</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- MODAL 2: UBAH DATA TAG (EDIT)              --}}
        {{-- ========================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-in fade-in duration-200" x-show="openEditModal" style="display: none;">
            <div class="bg-white rounded-2xl border border-slate-200 max-w-sm w-full overflow-hidden shadow-2xl" @click.away="openEditModal = false">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-bold text-base text-slate-900">Ubah Tag Teknologi</h3>
                    <button type="button" @click="openEditModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-base"></i></button>
                </div>
                <form method="POST" :action="`{{ url('admin/tags') }}/${currentTag.id}`" class="p-5 space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Tag / Teknologi <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" :value="currentTag.name" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kustom Kunci Slug</label>
                        <input type="text" name="slug" :value="currentTag.slug" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none font-mono">
                    </div>
                    <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs transition-colors shadow-sm">Perbarui Tag</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- MODAL 3: CONFIRM DELETE (SLIM - 320PX LOCK)--}}
        {{-- ========================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-in fade-in duration-200" x-show="openDeleteModal" style="display: none;">
            <div class="bg-white rounded-2xl border border-slate-200 max-w-[320px] w-full overflow-hidden shadow-2xl mx-auto" @click.away="openDeleteModal = false">
                <div class="p-5 pb-4 text-center">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-sm shrink-0 border border-rose-100 shadow-sm mx-auto mb-3">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="leading-relaxed">
                        <h3 class="text-[14.5px] font-bold text-slate-900 tracking-tight">Hapus Tag?</h3>
                        <p class="text-[11.5px] text-textCustom-600 mt-1">
                            Tag <span class="font-semibold text-slate-900" x-text="currentTag.name"></span> akan dihapus permanen. Aksi ini aman hanya jika tag tidak terikat pada project manapun.
                        </p>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-2 p-[12px_20px] border-t border-slate-100 bg-slate-50">
                    <button type="button" @click="openDeleteModal = false" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 font-semibold rounded-lg text-[11px] transition-colors">
                        Batal
                    </button>
                    <form method="POST" :action="`{{ url('admin/tags') }}/${currentTag.id}`" class="inline">
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
