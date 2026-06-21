
<x-app-layout>
    <x-slot:title>Formulir Pengajuan Proyek Baru — JTIK POLSUB</x-slot:title>

    <div class="bg-slate-50 min-h-screen py-10">
        <div class="mx-auto max-w-3xl px-6">

            <div class="mb-4">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-navy-900 transition font-medium">
                    ← Kembali ke Dashboard Saya
                </a>
            </div>

            <div class="border-b border-slate-200 pb-4 mb-8">
                <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">Formulir Pengajuan Proyek</h1>
                <p class="mt-1 text-xs text-slate-500">Lengkapi berkas informasi, unggah lembar tangkapan layar, dan daftarkan anggota kelompok luaran PBL Anda.</p>
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

            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="card p-6 space-y-4">
                    <h3 class="text-sm font-bold text-navy-900 border-b border-slate-100 pb-2">1. Informasi Akademik Proyek</h3>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Program Studi <span class="text-rose-500">*</span></label>
                            <select name="program_id" required class="w-full text-xs rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                                <option value="">-- Pilih Program Studi --</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori Utama Aplikasi <span class="text-rose-500">*</span></label>
                            <select name="category_id" required class="w-full text-xs rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                                <option value="">-- Pilih Rumpun Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Mata Kuliah & Kelas Kelas <span class="text-rose-500">*</span></label>
                            <select name="course_class_id" required class="w-full text-xs rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                                <option value="">-- Pilih Kelas Pengampu --</option>
                                @foreach($courseClasses as $cc)
                                    <option value="{{ $cc->id }}" {{ old('course_class_id') == $cc->id ? 'selected' : '' }}>
                                        {{ $cc->course?->name }} - {{ $cc->name }} ({{ $cc->semester?->name ?? 'PBL' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Tahun Angkatan Proyek <span class="text-rose-500">*</span></label>
                            <input type="number" name="cohort" required min="2000" max="{{ date('Y') + 1 }}" value="{{ old('cohort', date('Y')) }}" placeholder="Contoh: 2026" class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                        </div>
                    </div>
                </div>

                <div class="card p-6 space-y-4">
                    <h3 class="text-sm font-bold text-navy-900 border-b border-slate-100 pb-2">2. Deskripsi & Detail Aplikasi</h3>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Resmi Proyek <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: AgriSmart IoT Analytics Dashboard" class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Singkat Proyek (Satu Kalimat Excerpt)</label>
                        <input type="text" name="short_description" value="{{ old('short_description') }}" placeholder="Sistem monitoring lahan pertanian berbasis IoT dengan dashboard analitik real-time..." class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Lengkap Proyek <span class="text-rose-500">*</span></label>
                        <textarea name="description" rows="5" required placeholder="Tuliskan latar belakang masalah, solusi, serta modul teknis aplikasi kelompok Anda di sini..." class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Teknologi / Tech Stack Utama Kelompok</label>
                        <div class="grid grid-cols-2 gap-2 sm:grid-cols-4 p-3 bg-slate-50 border border-slate-200 rounded-lg max-h-36 overflow-y-auto">
                            @foreach($tags as $tag)
                                <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }} class="rounded border-slate-300 text-navy-700 focus:ring-navy-500">
                                    <span>{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                @livewire('team-member-picker')

                <div class="card p-6 space-y-4">
                    <h3 class="text-sm font-bold text-navy-900 border-b border-slate-100 pb-2">4. Tautan Deploy Aplikasi (URLs)</h3>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">URL GitHub / Git Repository</label>
                            <input type="url" name="repository_url" value="{{ old('repository_url') }}" placeholder="https://github.com/username/repository-name" class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">URL Live Aplikasi Demo (Jika Ada)</label>
                            <input type="url" name="demo_url" value="{{ old('demo_url') }}" placeholder="https://smartagriculture.polsub.ac.id" class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">URL Google Drive Berkas Dokumen Laporan (Opsional)</label>
                            <input type="url" name="documentation_url" value="{{ old('documentation_url') }}" placeholder="https://drive.google.com/..." class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-navy-500">
                        </div>
                    </div>
                </div>

                <div class="card p-6 space-y-4">
                    <h3 class="text-sm font-bold text-navy-900 border-b border-slate-100 pb-2">5. Berkas Gambar Aplikasi</h3>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Foto Sampul Utama / Thumbnail Proyek <span class="text-rose-500">*</span></label>
                            <input type="file" name="thumbnail" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 border rounded-lg p-1.5 bg-white">
                            <span class="text-[10px] text-slate-400 mt-1 block">Rekomendasi rasio gambar 16:9 (Max berkas: 10MB)</span>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Lembar Screenshot Aplikasi Tambahan (Multi-Upload)</label>
                            <input type="file" name="screenshots[]" multiple class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 border rounded-lg p-1.5 bg-white">
                            <span class="text-[10px] text-slate-400 mt-1 block">Bisa pilih sekaligus hingga maksimal 5 lembar tangkapan layar</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('projects.index') }}" class="btn-outline text-xs">Batalkan</a>
                    <button type="submit" class="btn-primary py-2 px-5 text-xs shadow-sm">
                        Submit Proyek Saya
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

