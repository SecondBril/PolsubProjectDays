<x-admin-layout>
    <x-slot:title>Tambah Project Baru — Admin Panel</x-slot:title>

    <div class="flex items-center gap-2 pb-4 mb-6 border-b border-slate-200">
        <a href="{{ route('admin.projects.index') }}" class="text-textCustom-400 hover:text-textCustom-900 transition-colors">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-lg font-bold text-textCustom-900 tracking-tight">Tambah Project Baru</h1>
            <p class="text-xs text-textCustom-400 mt-0.5">Daftarkan luaran berkas PBL atau tugas kelompok mahasiswa langsung dari panel manajemen.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-5 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs space-y-1 shadow-admin-sm">
            <p class="font-bold text-rose-900">Gagal memproses formulir. Silakan periksa kesalahan berikut:</p>
            <ul class="list-disc pl-4 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-[1.8fr_1fr] gap-6 items-start">
        @csrf

        {{-- LEFT COLUMN: FORM DATA UTAMA --}}
        <div class="space-y-5">
            {{-- Identitas Pokok --}}
            <div class="bg-panel border border-slate-200 rounded-admin-md p-5 shadow-admin-sm space-y-4">
                <h3 class="text-xs font-bold text-textCustom-900 uppercase tracking-wider border-b border-slate-100 pb-2">1. Detail Informasi Berkas</h3>

                <div>
                    <label class="block text-xs font-semibold text-textCustom-700 mb-1.5">Judul Resmi Project <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: AgriSmart IoT Analytics Dashboard" class="w-full text-xs rounded-lg border border-slate-200 p-[9.5px_12px] outline-none focus:border-teal-500 text-textCustom-900 bg-white">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-textCustom-700 mb-1.5">Deskripsi Singkat (Satu Kalimat Ringkasan)</label>
                    <input type="text" name="short_description" value="{{ old('short_description') }}" placeholder="Sistem monitoring lahan pertanian berbasis IoT dengan dashboard analitik real-time..." class="w-full text-xs rounded-lg border border-slate-200 p-[9.5px_12px] outline-none focus:border-teal-500 text-textCustom-900 bg-white">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-textCustom-700 mb-1.5">Deskripsi Lengkap Project <span class="text-rose-500">*</span></label>
                    <textarea name="description" rows="6" required placeholder="Jelaskan latar belakang masalah, fitur utama, dan arsitektur sistem luaran kelompok di sini..." class="w-full text-xs rounded-lg border border-slate-200 p-[9.5px_12px] outline-none focus:border-teal-500 text-textCustom-900 bg-white min-h-[120px] resize-vertical">{{ old('description') }}</textarea>
                </div>
            </div>

            {{-- Relasi Komponen & Picker --}}
            <div class="bg-panel border border-slate-200 rounded-admin-md p-5 shadow-admin-sm space-y-4">
                <h3 class="text-xs font-bold text-textCustom-900 uppercase tracking-wider border-b border-slate-100 pb-2">2. Komposisi Tim Pengembang</h3>

                <div>
                    <label class="block text-xs font-semibold text-textCustom-700 mb-1.5">Nama Kelompok / Nama Tim</label>
                    <input type="text" name="team_name" value="{{ old('team_name') }}" placeholder="Contoh: Tim Alpha / Kelompok 3" class="w-full text-xs rounded-lg border border-slate-200 p-[9.5px_12px] outline-none focus:border-teal-500 text-textCustom-900 bg-white">
                </div>

                @livewire('team-lead-picker')
                @livewire('team-member-picker')
            </div>

            {{-- INSTALASI KUSTOM: MANAJEMEN DINAMIS FITUR UTAMA APLIKASI (ALPINJS) --}}
            <div class="bg-panel border border-slate-200 rounded-admin-md p-5 shadow-admin-sm space-y-4" x-data="{
                features: {{ json_encode(old('features', [])) }} || [],
                iconSearch: '',
                activePickerIndex: null,
                fontAwesomeIcons: {{ json_encode($fontAwesomeIcons) }},
                addFeature() {
                    this.features.push({ name: '', icon: 'fa-solid fa-cube' });
                },
                removeFeature(index) {
                    this.features.splice(index, 1);
                },
                get filteredIcons() {
                    if (!this.iconSearch) return this.fontAwesomeIcons;
                    return this.fontAwesomeIcons.filter(icon => icon.toLowerCase().includes(this.iconSearch.toLowerCase()));
                }
            }" x-init="if(features.length === 0) addFeature()">

                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <h3 class="text-xs font-bold text-textCustom-900 uppercase tracking-wider">3. Fitur Utama Sistem Aplikasi</h3>
                    <button type="button" @click="addFeature()" class="inline-flex items-center gap-1 px-2.5 py-1 bg-navy-900 hover:bg-navy-800 text-white text-[11px] font-bold rounded-md transition shadow-sm">
                        <i class="fa-solid fa-plus"></i> Tambah Baris Fitur
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="(feature, index) in features" :key="index">
                        <div class="flex items-start gap-3 bg-surface p-3 rounded-xl border border-slate-200/60 relative">

                            {{-- Input Nama Fitur --}}
                            <div class="flex-1">
                                <label class="block text-[10px] font-bold text-textCustom-400 uppercase mb-1" x-text="`Nama Fitur Unggulan #${index + 1}`"></label>
                                <input type="text" :name="`features[${index}][name]`" x-model="feature.name" required placeholder="Contoh: Real-time Ingestion Layer via Kafka" class="w-full text-xs rounded-lg border border-slate-200 px-3 py-2 text-textCustom-900 focus:outline-none focus:border-teal-500 bg-white">
                            </div>

                            {{-- Dropdown Font Awesome Icon Picker --}}
                            <div class="w-40 relative">
                                <label class="block text-[10px] font-bold text-textCustom-400 uppercase mb-1">Visual Ikon</label>
                                <button type="button" @click="activePickerIndex = (activePickerIndex === index ? null : index); iconSearch = ''" class="w-full flex items-center justify-between gap-2 text-xs rounded-lg border border-slate-200 px-3 py-2 text-textCustom-900 bg-white hover:bg-slate-50 text-left outline-none">
                                    <span class="flex items-center gap-2 truncate">
                                        <i :class="feature.icon || 'fa-solid fa-cube'" class="text-indigo-600 text-sm"></i>
                                        <span x-text="feature.icon ? feature.icon.replace('fa-solid ', '') : 'Pilih Ikon'"></span>
                                    </span>
                                    <i class="fa-solid fa-chevron-down text-[10px] text-textCustom-400"></i>
                                </button>

                                <input type="hidden" :name="`features[${index}][icon]`" x-model="feature.icon">

                                <div class="absolute right-0 mt-1 w-64 bg-white border border-slate-200 rounded-xl shadow-xl z-30 p-3 space-y-2" x-show="activePickerIndex === index" @click.away="activePickerIndex = null" x-transition style="display: none;">
                                    <input type="text" x-model="iconSearch" placeholder="Cari ikon..." class="w-full text-[11px] rounded-md border border-slate-200 px-2.5 py-1.5 text-textCustom-900 outline-none focus:border-teal-500">
                                    <div class="grid grid-cols-5 gap-1.5 max-h-32 overflow-y-auto p-0.5 custom-scrollbar">
                                        <template x-for="icon in filteredIcons" :key="icon">
                                            <button type="button" @click="feature.icon = icon; activePickerIndex = null" :class="feature.icon === icon ? 'bg-teal-500 text-white border-teal-500' : 'bg-slate-50 text-textCustom-700 border-slate-200'" class="p-2 text-center rounded-md border transition flex items-center justify-center text-sm">
                                                <i :class="icon"></i>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol Hapus Baris --}}
                            <div class="pt-5">
                                <button type="button" @click="removeFeature(index)" class="p-2 bg-rose-50 border border-rose-100 text-rose-600 rounded-lg hover:bg-rose-600 hover:text-white transition-all">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Media Upload --}}
            <div class="bg-panel border border-slate-200 rounded-admin-md p-5 shadow-admin-sm space-y-4">
                <h3 class="text-xs font-bold text-textCustom-900 uppercase tracking-wider border-b border-slate-100 pb-2">4. Unggah Berkas Dokumentasi</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-textCustom-700 mb-1.5">Foto Sampul / Thumbnail Proyek <span class="text-rose-500">*</span></label>
                        <input type="file" name="thumbnail" required class="w-full text-xs text-textCustom-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-textCustom-700 hover:file:bg-slate-200 border border-slate-200 rounded-lg p-1 bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-textCustom-700 mb-1.5">Screenshots Tambahan (Multi-Upload)</label>
                        <input type="file" name="screenshots[]" multiple class="w-full text-xs text-textCustom-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-textCustom-700 hover:file:bg-slate-200 border border-slate-200 rounded-lg p-1 bg-white">
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: SIDEBAR METADATA & STATUS PUBLIKASI --}}
        <div class="space-y-5">
            <div class="bg-panel border border-slate-200 rounded-admin-md p-5 shadow-admin-sm space-y-4">
                <h3 class="text-xs font-bold text-textCustom-400 uppercase tracking-wider border-b border-slate-100 pb-2">Kontrol Manajemen</h3>

                <div>
                    <label class="block text-xs font-semibold text-textCustom-700 mb-1.5">Status Publikasi Awal</label>
                    <select name="status" class="w-full text-xs rounded-lg border border-slate-200 p-[9.5px_12px] outline-none text-textCustom-900 bg-white">
                        <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Langsung Live (Public)</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Antrean Review (Pending)</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft Internal</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-textCustom-700 mb-1.5">Program Studi Terkait <span class="text-rose-500">*</span></label>
                    <select name="program_id" required class="w-full text-xs rounded-lg border border-slate-200 p-[9.5px_12px] outline-none text-textCustom-900 bg-white">
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-textCustom-700 mb-1.5">Kategori Aplikasi <span class="text-rose-500">*</span></label>
                    <select name="category_id" required class="w-full text-xs rounded-lg border border-slate-200 p-[9.5px_12px] outline-none text-textCustom-900 bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-textCustom-700 mb-1.5">Kelas & Mata Kuliah <span class="text-rose-500">*</span></label>
                    <select name="course_class_id" required class="w-full text-xs rounded-lg border border-slate-200 p-[9.5px_12px] outline-none text-textCustom-900 bg-white">
                        <option value="">-- Pilih Kelas Pengampu --</option>
                        @foreach($courseClasses as $cc)
                            <option value="{{ $cc->id }}" {{ old('course_class_id') == $cc->id ? 'selected' : '' }}>
                                {{ $cc->course?->name }} - {{ $cc->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-textCustom-700 mb-1.5">Tahun Angkatan (Cohort) <span class="text-rose-500">*</span></label>
                    <input type="number" name="cohort" required min="2000" max="{{ date('Y') + 1 }}" value="{{ old('cohort', date('Y')) }}" class="w-full text-xs rounded-lg border border-slate-200 p-[9.5px_12px] outline-none text-textCustom-900 bg-white">
                </div>
            </div>

            <div class="bg-panel border border-slate-200 rounded-admin-md p-5 shadow-admin-sm space-y-4">
                <h3 class="text-xs font-bold text-textCustom-400 uppercase tracking-wider border-b border-slate-100 pb-2">Tautan Eksternal (URLs)</h3>

                <div>
                    <label class="block text-xs font-semibold text-textCustom-700 mb-1">URL Git Repository</label>
                    <input type="url" name="repository_url" value="{{ old('repository_url') }}" placeholder="https://github.com/..." class="w-full text-xs rounded-lg border border-slate-200 p-[9.5px_12px] outline-none text-textCustom-900 bg-white">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-textCustom-700 mb-1">URL Demo Live</label>
                    <input type="url" name="demo_url" value="{{ old('demo_url') }}" placeholder="https://..." class="w-full text-xs rounded-lg border border-slate-200 p-[9.5px_12px] outline-none text-textCustom-900 bg-white">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-textCustom-700 mb-1">URL Dokumentasi Laporan</label>
                    <input type="url" name="documentation_url" value="{{ old('documentation_url') }}" placeholder="https://drive.google.com/..." class="w-full text-xs rounded-lg border border-slate-200 p-[9.5px_12px] outline-none text-textCustom-900 bg-white">
                </div>
            </div>

            {{-- Tech Stack Tags --}}
            <div class="bg-panel border border-slate-200 rounded-admin-md p-5 shadow-admin-sm">
                <h3 class="text-xs font-bold text-textCustom-400 uppercase tracking-wider border-b border-slate-100 pb-2 mb-3">Teknologi Terikat</h3>
                <div class="grid grid-cols-2 gap-2 max-h-36 overflow-y-auto p-1">
                    @foreach($tags as $tag)
                        <label class="flex items-center gap-2 text-xs text-textCustom-600 cursor-pointer">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }} class="rounded border-slate-200 text-navy-900 focus:ring-0">
                            <span>{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.projects.index') }}" class="py-2 px-4 text-xs font-semibold text-textCustom-600 hover:bg-slate-100 rounded-lg transition-colors">Batal</a>
                <button type="submit" class="py-2 px-5 text-xs font-bold bg-navy-900 text-white hover:bg-navy-800 rounded-lg shadow-admin-sm transition-colors">Simpan Project</button>
            </div>
        </div>
    </form>
</x-admin-layout>
