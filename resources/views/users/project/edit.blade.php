<x-app-layout>
    <x-slot:title>Formulir Edit Proyek — POLS-HUB JTIK</x-slot:title>

    <div class="bg-slate-50 min-h-screen py-10">
        <div class="mx-auto max-w-3xl px-6">

            <div class="mb-4">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-navy-900 transition font-medium">
                    ← Kembali ke Dashboard Saya
                </a>
            </div>

            <div class="border-b border-slate-200 pb-4 mb-8">
                <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">Formulir Perbarui Proyek</h1>
                <p class="mt-1 text-xs text-slate-500">Perbarui berkas informasi, unggah ulang lembar tangkapan layar, atau sesuaikan anggota kelompok luaran PBL Anda.</p>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-lg text-xs space-y-1 shadow-sm">
                    <p class="font-bold text-rose-900">Gagal memproses formulir. Silakan periksa kesalahan berikut:</p>
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('projects.update', ['project' => $project->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="card p-6 space-y-4">
                    <h3 class="text-sm font-bold text-navy-900 border-b border-slate-100 pb-2">Informasi Akademik Proyek</h3>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Program Studi <span class="text-rose-500">*</span></label>
                            <select name="program_id" required class="w-full text-xs rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                                <option value="">-- Pilih Program Studi --</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ old('program_id', $project->program_id) == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori Utama Aplikasi <span class="text-rose-500">*</span></label>
                            <select name="category_id" required class="w-full text-xs rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                                <option value="">-- Pilih Rumpun Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $project->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Mata Kuliah & Kelas <span class="text-rose-500">*</span></label>
                            <select name="course_class_id" required class="w-full text-xs rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                                <option value="">-- Pilih Kelas Pengampu --</option>
                                @foreach($courseClasses as $cc)
                                    <option value="{{ $cc->id }}" {{ old('course_class_id', $project->course_class_id) == $cc->id ? 'selected' : '' }}>
                                        {{ $cc->course?->name }} - {{ $cc->class_code }} ({{ $cc->semester?->name ?? 'PBL' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Tahun Angkatan Proyek <span class="text-rose-500">*</span></label>
                            <input type="number" name="cohort" required min="2000" max="{{ date('Y') + 1 }}" value="{{ old('cohort', $project->cohort) }}" placeholder="Contoh: 2026" class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                        </div>
                    </div>
                </div>

                <div class="card p-6 space-y-4">
                    <h3 class="text-sm font-bold text-navy-900 border-b border-slate-100 pb-2">Deskripsi & Detail Aplikasi</h3>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Kelompok / Nama Tim</label>
                        <input type="text" name="team_name" value="{{ old('team_name', $project->team_name) }}" placeholder="Contoh: Tim Alpha / Kelompok 3" class="w-full text-xs rounded-lg border border-slate-200 p-[9.5px_12px] outline-none focus:border-teal-500 text-slate-900 bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Resmi Proyek <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" required value="{{ old('title', $project->title) }}" placeholder="Contoh: AgriSmart IoT Analytics Dashboard" class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Singkat Proyek (Satu Kalimat Excerpt)</label>
                        <input type="text" name="short_description" value="{{ old('short_description', $project->short_description) }}" placeholder="Sistem monitoring lahan pertanian berbasis IoT dengan dashboard analitik real-time..." class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Lengkap Proyek <span class="text-rose-500">*</span></label>
                        <textarea name="description" rows="5" required placeholder="Tuliskan latar belakang masalah, solusi, serta modul teknis aplikasi kelompok Anda di sini..." class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">{{ old('description', $project->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Teknologi / Tech Stack Utama Kelompok</label>
                        <div class="grid grid-cols-2 gap-2 sm:grid-cols-4 p-3 bg-slate-50 border border-slate-200 rounded-lg max-h-36 overflow-y-auto">
                            @foreach($tags as $tag)
                                <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                        {{ (is_array(old('tags')) && in_array($tag->id, old('tags'))) || (!is_array(old('tags')) && $project->tags->contains($tag->id)) ? 'checked' : '' }}
                                        class="rounded border-slate-300 text-navy-700 focus:ring-navy-500">
                                    <span>{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Picker Anggota Kelompok Mengikat Array Livewire --}}
                @php
                    // 1. Cari record ketua tim dari relasi proyek
                    $leaderMember = $project->teamMembers->where('id', $project->team_lead_id)->first();
                    $leaderPrefill = $leaderMember ? $leaderMember->pivot->contribution : '';

                    // 2. Ekstraksi data anggota selain ketua tim
                    $prefilledMembers = $project->teamMembers->where('id', '!=', $project->team_lead_id)->map(function($m) {
                        return [
                            'id' => $m->id,
                            'name' => $m->name,
                            'nim_nidn' => $m->nim_nidn,
                            'contribution' => $m->pivot->contribution
                        ];
                    })->toArray();
                @endphp

                {{-- Kirim kedua variabel ke dalam komponen Livewire --}}
                @livewire('team-member-picker', [
                    'selectedMembers' => $prefilledMembers,
                    'leaderContribution' => $leaderPrefill
                ])
                {{-- ========================================== --}}
                {{-- INJEKSI DATA DATA FITUR LAMA KE ALPINE.JS  --}}
                {{-- ========================================== --}}
                <div class="card p-6 space-y-4" x-data="{
                    features: {{ json_encode(old('features', $project->features->map(fn($f) => ['name' => $f->name, 'icon' => $f->icon])->toArray())) }},
                    iconSearch: '',
                    activePickerIndex: null,
                    fontAwesomeIcons: {{ json_encode($fontAwesomeIcons) }},

                    addFeature() {
                        this.features.push({ name: '', icon: 'fa-solid fa-star' });
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
                        <h3 class="text-sm font-bold text-navy-900">Fitur Utama Sistem</h3>
                        <button type="button" @click="addFeature()" class="inline-flex items-center gap-1 px-2.5 py-1 bg-teal-500 hover:bg-teal-600 text-white text-[11px] font-bold rounded-md transition shadow-sm">
                            <i class="fa-solid fa-plus"></i> Tambah Fitur
                        </button>
                    </div>

                    <p class="text-[11px] text-slate-500">Daftarkan modul atau fitur keunggulan sistem yang berhasil dikembangkan oleh kelompok Anda beserta representasi ikon visualnya.</p>

                    <div class="space-y-3">
                        <template x-for="(feature, index) in features" :key="index">
                            <div class="flex items-start gap-3 bg-slate-50 p-3 rounded-xl border border-slate-200/60 relative">

                                <div class="flex-1">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1" x-text="`Nama Fitur #${index + 1}`"></label>
                                    <input type="text" :name="`features[${index}][name]`" x-model="feature.name" required placeholder="Contoh: Otentikasi Multi-faktor (MFA)" class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500 bg-white">
                                </div>

                                <div class="w-40 relative">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Ikon Tampilan</label>

                                    <button type="button" @click="activePickerIndex = (activePickerIndex === index ? null : index); iconSearch = ''" class="w-full flex items-center justify-between gap-2 text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 bg-white hover:bg-slate-50 text-left outline-none">
                                        <span class="flex items-center gap-2 truncate">
                                            <i :class="feature.icon || 'fa-solid fa-star'" class="text-teal-600 text-sm"></i>
                                            <span x-text="feature.icon ? feature.icon.replace('fa-solid ', '') : 'Pilih Ikon'"></span>
                                        </span>
                                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                                    </button>

                                    <input type="hidden" :name="`features[${index}][icon]`" x-model="feature.icon">

                                    <div class="absolute right-0 mt-1 w-64 bg-white border border-slate-200 rounded-xl shadow-xl z-30 p-3 space-y-2" x-show="activePickerIndex === index" @click.away="activePickerIndex = null" x-transition style="display: none;">
                                        <input type="text" x-model="iconSearch" placeholder="Cari ikon... (cth: server)" class="w-full text-[11px] rounded-md border border-slate-200 px-2.5 py-1.5 text-slate-700 outline-none focus:border-teal-500">

                                        <div class="grid grid-cols-5 gap-1.5 max-h-36 overflow-y-auto p-0.5 custom-scrollbar">
                                            <template x-for="icon in filteredIcons" :key="icon">
                                                <button type="button" @click="feature.icon = icon; activePickerIndex = null" :class="feature.icon === icon ? 'bg-teal-500 text-white border-teal-500' : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border-slate-200'" class="p-2 text-center rounded-md border transition-all flex items-center justify-center text-sm" :title="icon">
                                                    <i :class="icon"></i>
                                                </button>
                                            </template>
                                            <template x-if="filteredIcons.length === 0">
                                                <div class="col-span-5 text-center py-4 text-[11px] text-slate-400">Ikon tidak ditemukan</div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-5">
                                    <button type="button" @click="removeFeature(index)" class="p-2 bg-rose-50 border border-rose-200 hover:bg-rose-500 hover:text-white text-rose-600 rounded-lg transition-all" title="Hapus Fitur">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </div>

                            </div>
                        </template>
                    </div>
                </div>

                <div class="card p-6 space-y-4">
                    <h3 class="text-sm font-bold text-navy-900 border-b border-slate-100 pb-2">Tautan Deploy Aplikasi (URLs)</h3>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">URL GitHub / Git Repository</label>
                            <input type="url" name="repository_url" value="{{ old('repository_url', $project->repository_url) }}" placeholder="https://github.com/username/repository-name" class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">URL Live Aplikasi Demo (Jika Ada)</label>
                            <input type="url" name="demo_url" value="{{ old('demo_url', $project->demo_url) }}" placeholder="https://smartagriculture.polsub.ac.id" class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">URL Google Drive Berkas Dokumen Laporan (Opsional)</label>
                            <input type="url" name="documentation_url" value="{{ old('documentation_url', $project->documentation_url) }}" placeholder="https://drive.google.com/..." class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                        </div>
                    </div>
                </div>

                <div class="card p-6 space-y-4">
                    <h3 class="text-sm font-bold text-navy-900 border-b border-slate-100 pb-2">Berkas Gambar Aplikasi</h3>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Foto Sampul Utama / Thumbnail Proyek</label>
                            <input type="file" name="thumbnail" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 border rounded-lg p-1.5 bg-white">
                            <span class="text-[10px] text-slate-400 mt-1 block">Biarkan kosong jika tidak ingin mengubah foto sampul utama. (Max: 10MB)</span>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Lembar Screenshot Aplikasi Tambahan (Multi-Upload)</label>
                            <input type="file" name="screenshots[]" multiple class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 border rounded-lg p-1.5 bg-white">
                            <span class="text-[10px] text-slate-400 mt-1 block">Mengunggah file baru akan menggantikan seluruh screenshot lama kelompok Anda.</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('projects.index') }}" class="btn-outline text-xs">Batalkan</a>
                    <button type="submit" class="btn-primary py-2 px-5 text-xs shadow-sm">
                        Simpan Perubahan Proyek
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
