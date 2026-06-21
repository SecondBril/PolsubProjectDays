<x-admin-layout title="Kategori Aplikasi">
    <div class="space-y-6" x-data="{ openCreateModal: false, openEditModal: false, openDeleteModal: false, currentCategory: {} }">

        {{-- FLASH MESSAGE ALERT --}}
        @if(session('success'))
            <div class="p-4 bg-teal-500/10 border border-teal-500/30 text-teal-600 rounded-xl text-sm font-medium flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-base"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        {{-- TOP PANEL: INFO & BUTTON ACTION --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div>
                <p class="text-textCustom-600 text-xs">Kelola rumpun kategori aplikasi luaran proyek mahasiswa JTIK POLSUB.</p>
            </div>
            <button type="button" @click="openCreateModal = true" class="w-fit flex items-center justify-center gap-2 px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors shrink-0">
                <i class="fa-solid fa-plus text-[12px]"></i> Tambah Kategori
            </button>
        </div>

        {{-- TABEL DATA MASTER KATEGORI --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-textCustom-400 font-bold text-[11px] uppercase tracking-wider">
                            <th class="py-3.5 px-5 w-16 text-center">Urutan</th>
                            <th class="py-3.5 px-5">Nama Kategori / Slug</th>
                            <th class="py-3.5 px-5">Deskripsi</th>
                            <th class="py-3.5 px-5 text-center">Status</th>
                            <th class="py-3.5 px-5 text-right w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-textCustom-900 font-medium">
                        @forelse($categories as $category)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-5 text-center font-mono font-bold text-slate-500">
                                    {{ $category->sort_order ?? 0 }}
                                </td>
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center text-sm shrink-0">
                                            <i class="{{ $category->icon ?: 'fa-solid fa-layer-group' }}"></i>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-slate-900 text-sm">{{ $category->name }}</span>
                                            <span class="text-textCustom-400 text-[11px] font-mono mt-0.5">{{ $category->slug }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-textCustom-600 max-w-xs truncate">
                                    {{ $category->description ?: '-' }}
                                </td>
                                <td class="py-4 px-5 text-center">
                                    @if($category->is_active)
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-teal-500/10 text-teal-600 border border-teal-500/20">Aktif</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-400 border border-slate-200">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        {{-- Trigger Button Edit --}}
                                        <button type="button"
                                                @click="currentCategory = {{ json_encode($category) }}; openEditModal = true"
                                                class="p-1.5 bg-slate-100 text-slate-600 border border-slate-200 rounded-md hover:bg-navy-900 hover:text-white transition-all" title="Ubah Data">
                                            <i class="fa-solid fa-pen-to-square text-[13px]"></i>
                                        </button>

                                        {{-- Trigger Button Delete --}}
                                        <button type="button"
                                                @click="currentCategory = {{ json_encode($category) }}; openDeleteModal = true"
                                                class="p-1.5 bg-rose-500/10 text-rose-600 border border-rose-500/20 rounded-md hover:bg-rose-500 hover:text-white transition-all" title="Hapus Kategori">
                                            <i class="fa-regular fa-trash-can text-[13px]"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-textCustom-400 font-medium">
                                    Belum ada data kategori terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

        {{-- ========================================== --}}
        {{-- MODAL 1: TAMBAH KATEGORI BARU               --}}
        {{-- ========================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-in fade-in duration-200" x-show="openCreateModal" style="display: none;">
            <div class="bg-white rounded-2xl border border-slate-200 max-w-md overflow-hidden shadow-2xl" @click.away="openCreateModal = false">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-bold text-base text-slate-900">Tambah Kategori</h3>
                    <button type="button" @click="openCreateModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-base"></i></button>
                </div>
                <form method="POST" action="{{ route('admin.category.store') }}" class="p-5 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Kategori <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="Contoh: Sistem Informasi (SI)" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Icon Class (FontAwesome)</label>
                            <input type="text" name="icon" placeholder="Contoh: fa-solid fa-database" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Urutan urut (Sort Order)</label>
                            <input type="number" name="sort_order" min="0" value="0" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Deskripsi Kategori</label>
                        <textarea name="description" rows="3" placeholder="Tulis lingkup rumpun aplikasi kategori ini..." class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none resize-none"></textarea>
                    </div>
                    <div class="flex items-center gap-2 py-1">
                        <input type="checkbox" name="is_active" id="is_active_create" checked value="1" class="rounded border-slate-200 text-teal-500 focus:ring-0">
                        <label Bureau for="is_active_create" class="text-xs font-semibold text-slate-700 cursor-pointer">Aktifkan Kategori Langsung</label>
                    </div>
                    <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="openCreateModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs transition-colors shadow-sm">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- MODAL 2: UBAH DATA KATEGORI (EDIT)          --}}
        {{-- ========================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-in fade-in duration-200" x-show="openEditModal" style="display: none;">
            <div class="bg-white rounded-2xl border border-slate-200 max-w-md overflow-hidden shadow-2xl" @click.away="openEditModal = false">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-bold text-base text-slate-900">Ubah Kategori</h3>
                    <button type="button" @click="openEditModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-base"></i></button>
                </div>
                <form method="POST" :action="`{{ url('admin/category') }}/${currentCategory.id}`" class="p-5 space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Kategori <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" :value="currentCategory.name" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Icon Class (FontAwesome)</label>
                            <input type="text" name="icon" :value="currentCategory.icon" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Urutan urut (Sort Order)</label>
                            <input type="number" name="sort_order" min="0" :value="currentCategory.sort_order" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Deskripsi Kategori</label>
                        <textarea name="description" rows="3" :value="currentCategory.description" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-teal-500 focus:ring-0 outline-none resize-none"></textarea>
                    </div>
                    <div class="flex items-center gap-2 py-1">
                        <input type="checkbox" name="is_active" id="is_active_edit" value="1" :checked="currentCategory.is_active" class="rounded border-slate-200 text-teal-500 focus:ring-0">
                        <label Bureau for="is_active_edit" class="text-xs font-semibold text-slate-700 cursor-pointer">Kategori Aktif</label>
                    </div>
                    <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs transition-colors shadow-sm">Perbarui Kategori</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- MODAL 3: CONFIRM DELETE (SLIM - 320PX)     --}}
        {{-- ========================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-in fade-in duration-200" x-show="openDeleteModal" style="display: none;">
            <div class="bg-white rounded-2xl border border-slate-200 max-w-[320px] overflow-hidden shadow-2xl" @click.away="openDeleteModal = false">
                <div class="p-5 pb-4 text-center">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-sm shrink-0 border border-rose-100 shadow-sm mx-auto mb-3">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="leading-relaxed">
                        <h3 class="text-[14.5px] font-bold text-slate-900 tracking-tight">Hapus Kategori?</h3>
                        <p class="text-[11.5px] text-textCustom-600 mt-1">
                            Kategori <span class="font-semibold text-slate-900" x-text="currentCategory.name"></span> akan dihapus permanen. Seluruh project yang terikat ke kategori ini mungkin akan kehilangan relasinya.
                        </p>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-2 p-2 border-t border-slate-100 bg-slate-50">
                    <button type="button" @click="openDeleteModal = false" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 font-semibold rounded-lg text-[11px] transition-colors">
                        Batal
                    </button>
                    <form method="POST" :action="`{{ url('admin/category') }}/${currentCategory.id}`" class="inline">
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
