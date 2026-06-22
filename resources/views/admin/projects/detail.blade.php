<x-admin-layout>
    <x-slot:title>Detail Project — Admin Panel</x-slot:title>

    {{-- ALERT NOTIFIKASI --}}
    @if(session('success'))
        <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-500"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- HEADER LAYOUT ADMIN --}}
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between pb-5 mb-5 border-b border-slate-200 gap-4">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.projects.index') }}" class="text-textCustom-400 hover:text-textCustom-900 transition-colors">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <h1 class="text-xl font-bold text-textCustom-900 tracking-tight">{{ $project->title }}</h1>
            </div>
            <p class="text-textCustom-600 text-[13px] mt-1">Review detail submission berkas showcase mahasiswa secara menyeluruh.</p>
        </div>

        {{-- ALUR KERJA APPROVAL / CRUD ACTION UNTUK ADMIN --}}
        <div class="flex items-center gap-2 flex-wrap">
            @if($project->status === 'pending')
                <form action="{{ route('admin.projects.approve', $project->id) }}" method="POST" class="inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="inline-flex items-center gap-1.5 py-2 px-4 rounded-[9px] text-[13px] font-bold bg-emerald-600 text-white hover:bg-emerald-700 shadow-admin-sm transition-colors">
                        <i class="fa-solid fa-check"></i> Approve Publikasi
                    </button>
                </form>
                <button type="button" onclick="openRejectModal()" class="inline-flex items-center gap-1.5 py-2 px-4 rounded-[9px] text-[13px] font-bold bg-rose-100 text-rose-700 hover:bg-rose-200 transition-colors">
                    <i class="fa-solid fa-xmark"></i> Tolak Berkas
                </button>
            @endif

            <a href="{{ route('admin.projects.edit', $project->id) }}" class="inline-flex items-center gap-1.5 py-2 px-4 rounded-[9px] text-[13px] font-semibold bg-white text-textCustom-900 border border-slate-200 hover:border-textCustom-400 transition-colors">
                <i class="fa-regular fa-pen-to-square"></i> Ubah Data
            </a>
        </div>
    </div>

    {{-- KONTEN UTAMA BERBASIS LAYOUT PANEL ADMIN --}}
    <div class="grid grid-cols-1 xl:grid-cols-[1.7fr_1fr] gap-5 items-start">

        {{-- LEFT COLUMN: DETAIL DATA & MEDIA --}}
        <div class="space-y-5">
            {{-- Informasi Pokok & Deskripsi --}}
            <div class="bg-panel border border-slate-200 rounded-admin-md p-6 shadow-admin-sm">
                <h2 class="text-sm font-bold text-textCustom-900 border-b border-slate-100 pb-3 mb-4">Informasi Deskripsi Proyek</h2>

                <div class="space-y-4">
                    <div>
                        <span class="text-xs font-semibold text-textCustom-400 block mb-1">Sinopsis / Ringkasan Pendek</span>
                        <p class="text-[13.5px] text-textCustom-900 leading-relaxed bg-surface border border-slate-100 p-3 rounded-lg">{{ $project->short_description ?? 'Tidak ada ringkasan pendek.' }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-textCustom-400 block mb-1">Deskripsi Lengkap Sistem</span>
                        <div class="text-[13.5px] text-textCustom-600 leading-relaxed text-justify space-y-3">
                            {!! nl2br(e($project->description ?? 'Tidak ada deskripsi lengkap.')) !!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- REVISI 1: KOMPONEN LIST DAFTAR FITUR UTAMA APLIKASI --}}
            <div class="bg-panel border border-slate-200 rounded-admin-md p-6 shadow-admin-sm">
                <h2 class="text-sm font-bold text-textCustom-900 border-b border-slate-100 pb-3 mb-4">Fitur Unggulan Sistem Perangkat Lunak</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @forelse($project->features->sortBy('order') as $feature)
                        <div class="flex items-start gap-3.5 p-3.5 border border-slate-150 rounded-xl bg-surface shadow-sm">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center text-sm shrink-0">
                                <i class="{{ $feature->icon ?? 'fa-solid fa-cube' }}"></i>
                            </div>
                            <div class="min-w-0 flex-1 pt-0.5">
                                <span class="text-xs font-bold text-textCustom-900 block leading-tight mb-0.5">Fitur #{{ $loop->iteration }}</span>
                                <p class="text-[12.5px] text-textCustom-600 leading-relaxed">{{ $feature->name }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-textCustom-400 italic col-span-full py-2">Kelompok belum mendaftarkan fitur/modul utama aplikasi.</p>
                    @endforelse
                </div>
            </div>

            {{-- Komponen Link Eksternal Asset --}}
            <div class="bg-panel border border-slate-200 rounded-admin-md p-6 shadow-admin-sm">
                <h2 class="text-sm font-bold text-textCustom-900 border-b border-slate-100 pb-3 mb-4">Tautan Berkas & Aset Proyek</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @if($project->demo_url)
                        <a href="{{ $project->demo_url }}" target="_blank" class="flex items-center gap-3 p-3 border border-slate-200 rounded-lg bg-surface hover:border-teal-500 hover:bg-teal-50/20 transition-all group">
                            <div class="w-9 h-9 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center text-sm shrink-0"><i class="fa-solid fa-arrow-up-right-from-square"></i></div>
                            <div class="min-w-0 flex-1">
                                <span class="text-xs font-bold text-textCustom-900 block">Link Demo Live</span>
                                <span class="text-[11px] text-textCustom-400 truncate block">{{ $project->demo_url }}</span>
                            </div>
                        </a>
                    @endif

                    @if($project->repository_url)
                        <a href="{{ $project->repository_url }}" target="_blank" class="flex items-center gap-3 p-3 border border-slate-200 rounded-lg bg-surface hover:border-navy-500 hover:bg-slate-50 transition-all group">
                            <div class="w-9 h-9 rounded-lg bg-slate-100 text-textCustom-900 flex items-center justify-center text-sm shrink-0"><i class="fa-brands fa-github text-base"></i></div>
                            <div class="min-w-0 flex-1">
                                <span class="text-xs font-bold text-textCustom-900 block">Repository Kode</span>
                                <span class="text-[11px] text-textCustom-400 truncate block">{{ $project->repository_url }}</span>
                            </div>
                        </a>
                    @endif

                    @if($project->documentation_url)
                        <a href="{{ asset($project->documentation_url) }}" target="_blank" class="flex items-center gap-3 p-3 border border-slate-200 rounded-lg bg-surface hover:border-blue-500 hover:bg-blue-50/20 transition-all group">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm shrink-0"><i class="fa-regular fa-file-lines"></i></div>
                            <div class="min-w-0 flex-1">
                                <span class="text-xs font-bold text-textCustom-900 block">Berkas Laporan PDF</span>
                                <span class="text-[11px] text-textCustom-400 block">Klik untuk mengunduh</span>
                            </div>
                        </a>
                    @endif
                </div>
            </div>

            {{-- REVISI 2: TIM PENGEMBANG & DETAIL KONTRIBUSI INDIVIDU --}}
            <div class="bg-panel border border-slate-200 rounded-admin-md p-6 shadow-admin-sm">
                <h2 class="text-sm font-bold text-textCustom-900 border-b border-slate-100 pb-3 mb-4">Struktur Anggota Tim Pengembang & Kontribusi</h2>
                <div class="mb-3">
                    <span class="text-xs font-semibold text-textCustom-400 block mb-1">Nama Tim/Kelompok</span>
                    <p class="text-[13.5px] text-textCustom-900 leading-relaxed bg-surface border border-slate-100 p-3 rounded-lg">{{ $project->team_name ?? 'Tidak ada' }}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($project->teamMembers as $member)
                        <div class="border border-slate-150 rounded-xl p-4 flex flex-col justify-between bg-surface shadow-sm transition hover:shadow">
                            <div class="flex items-start gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=F1F5F9&color=0F172A" class="w-11 h-11 rounded-full object-cover shrink-0 border border-slate-100" alt="Avatar">
                                <div class="min-w-0 flex-1">
                                    <div class="text-xs font-extrabold text-textCustom-900 truncate leading-tight">{{ $member->name }}</div>
                                    <div class="text-[10px] text-textCustom-400 font-mono mt-0.5">{{ $member->nim_nidn }}</div>

                                    <div class="mt-2">
                                        <span @class([
                                            'text-[9px] font-bold px-2 py-0.5 rounded border tracking-wide uppercase',
                                            'bg-indigo-50 border-indigo-200/60 text-indigo-700' => (($member->pivot->role ?? '') === 'ketua' || $project->team_lead_id === $member->id),
                                            'bg-slate-50 border-slate-200 text-textCustom-600' => (($member->pivot->role ?? '') !== 'ketua' && $project->team_lead_id !== $member->id)
                                        ])>
                                            {{ ($member->pivot->role ?? '') === 'ketua' || $project->team_lead_id === $member->id ? 'Ketua Tim' : 'Anggota Developer' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Area Cetak Teks Kontribusi Kerja Tugas Mandiri --}}
                            <div class="mt-3.5 pt-3.5 border-t border-slate-100">
                                <span class="text-[10px] font-bold text-textCustom-400 uppercase tracking-wide block mb-1">Tugas / Kontribusi Kerja:</span>
                                <p class="text-[12px] text-textCustom-700 font-medium leading-relaxed bg-slate-50/50 p-2.5 rounded-lg border border-slate-100 min-h-[50px]">
                                    {{ $member->pivot->contribution ?? 'Tidak ada rincian deskripsi tugas mandiri yang dilampirkan.' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-textCustom-400 italic col-span-full py-2">Data anggota tim tidak ditemukan.</p>
                    @endforelse
                </div>
            </div>

            {{-- Galeri Screenshot (Spatie Media Library) --}}
            @if($project->media->where('collection_name', 'screenshots')->isNotEmpty())
                <div class="bg-panel border border-slate-200 rounded-admin-md p-6 shadow-admin-sm">
                    <h2 class="text-sm font-bold text-textCustom-900 border-b border-slate-100 pb-3 mb-4">Galeri Dokumentasi Antarmuka (Screenshots)</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @foreach($project->media->where('collection_name', 'screenshots') as $screenshot)
                            <a href="{{ $screenshot->getUrl() }}" target="_blank" class="group block border border-slate-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all">
                                <img src="{{ $screenshot->getUrl('card-thumbnail') ?? $screenshot->getUrl() }}" class="w-full h-24 object-cover" alt="Screenshot">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- RIGHT COLUMN: SIDEBAR METADATA & STATUS --}}
        <div class="space-y-5">
            {{-- Status & Info Publikasi --}}
            <div class="bg-panel border border-slate-200 rounded-admin-md p-5 shadow-admin-sm">
                <h3 class="text-xs font-bold text-textCustom-400 uppercase tracking-wider mb-3">Status Manajemen</h3>

                <div class="space-y-3">
                    <div class="flex items-center justify-between text-xs p-2.5 rounded-lg bg-surface border border-slate-100">
                        <span class="text-textCustom-600 font-medium">Status Publikasi</span>
                        @if($project->status === 'published')
                            <span class="font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 text-[11px]">LIVE / PUBLIC</span>
                        @elseif($project->status === 'pending')
                            <span class="font-bold px-2 py-0.5 rounded bg-amber-50 text-amber-600 text-[11px]">MENUGGU REVIEW</span>
                        @else
                            <span class="font-bold px-2 py-0.5 rounded bg-rose-50 text-rose-600 text-[11px]">DITOLAK</span>
                        @endif
                    </div>

                    @if($project->status === 'rejected' && $project->rejected_reason)
                        <div class="p-3 bg-rose-50 border border-rose-100 rounded-lg text-xs text-rose-700">
                            <span class="font-bold block mb-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>Alasan Penolakan Admin:</span>
                            {{ $project->rejected_reason }}
                        </div>
                    @endif

                    <div class="flex items-center justify-between text-xs p-2.5 rounded-lg bg-surface border border-slate-100">
                        <span class="text-textCustom-600 font-medium">Total Kunjungan</span>
                        <span class="font-mono font-bold text-textCustom-900 text-sm">{{ number_format($project->views_count ?? 0) }} kali</span>
                    </div>
                </div>
            </div>

            {{-- Komponen Metadata Relasi --}}
            <div class="bg-panel border border-slate-200 rounded-admin-md p-5 shadow-admin-sm">
                <h3 class="text-xs font-bold text-textCustom-400 uppercase tracking-wider border-b border-slate-100 pb-3 mb-3">Metadata Proyek</h3>

                <dl class="space-y-3.5 text-xs">
                    <div>
                        <span class="text-textCustom-400 font-medium">Nama Kelompok / Tim</span>
                        <dd class="mt-0.5 font-bold text-textCustom-900">{{ $project->team_name ?? 'Individual' }}</dd>
                    </div>
                    <div>
                        <span class="text-textCustom-400 font-medium">Dosen Pembimbing / Pengampu</span>
                        <dd class="mt-1.5 flex flex-wrap gap-1.5">
                            @if($project->courseClass && $project->courseClass->lecturers->isNotEmpty())
                                @foreach($project->courseClass->lecturers as $lecturer)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-50 border border-slate-200 text-xs font-bold text-textCustom-900">
                                        <i class="fa-solid fa-user-tie text-[11px] text-textCustom-400"></i>
                                        {{ $lecturer->name }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-xs text-textCustom-400 italic font-medium">N/A</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <span class="text-textCustom-400 font-medium">Mata Kuliah Konteks</span>
                        <dd class="mt-0.5 font-bold text-textCustom-900">{{ $project->courseClass?->course?->name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <span class="text-textCustom-400 font-medium">Program Studi</span>
                        <dd class="mt-0.5 font-bold text-textCustom-900">{{ $project->program?->name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <span class="text-textCustom-400 font-medium">Kategori Rumpun Ilmu</span>
                        <dd class="mt-0.5 font-bold text-textCustom-900">{{ $project->category?->name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <span class="text-textCustom-400 font-medium">Angkatan (Cohort) / Semester</span>
                        <dd class="mt-0.5 font-bold text-textCustom-900">Angkatan {{ $project->cohort ?? '-' }} — {{ $project->courseClass?->semester?->name ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Tech Stack Tags --}}
            @if($project->tags->isNotEmpty())
                <div class="bg-panel border border-slate-200 rounded-admin-md p-5 shadow-admin-sm">
                    <h3 class="text-xs font-bold text-textCustom-400 uppercase tracking-wider border-b border-slate-100 pb-3 mb-3">Teknologi Terikat (Tags)</h3>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($project->tags as $tag)
                            <span class="rounded bg-slate-100 border border-slate-200 px-2 py-1 text-[11px] font-semibold text-textCustom-700">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- MODAL REJECT WORKFLOW --}}
    @if($project->status === 'pending')
        <div class="fixed inset-0 bg-navy-950/55 backdrop-blur-[2px] hidden items-start justify-center p-[40px_20px] z-50 overflow-y-auto" id="rejectModalOverlay">
            <div class="bg-white rounded-admin-lg w-full max-w-[450px] shadow-admin-lg scale-99 opacity-0 transition-all duration-200 ease-out">
                <form method="POST" action="{{ route('admin.projects.reject', $project->id) }}">
                    @csrf @method('PATCH')
                    <div class="p-6">
                        <h3 class="text-[16px] font-bold text-textCustom-900 mb-2">Tolak Berkas Proyek</h3>
                        <p class="text-[13px] text-textCustom-600 mb-4">Berikan alasan penolakan berkas mahasiswa agar mereka dapat melakukan perbaikan.</p>

                        <label class="block text-[12.5px] font-semibold text-textCustom-900 mb-1.5">Alasan Penolakan</label>
                        <textarea name="rejected_reason" required class="w-full p-3 border border-slate-200 rounded-lg text-[13px] outline-none focus:border-rose-500 text-textCustom-900 min-h-[100px]" placeholder="Contoh: Link video demo aplikasi rusak atau folder github masih di-private..."></textarea>
                    </div>
                    <div class="flex items-center justify-end gap-2.5 p-[16px_24px] border-t border-slate-200 bg-surface rounded-b-admin-lg">
                        <button type="button" class="py-2 px-4 text-[13.5px] font-semibold text-textCustom-600 hover:bg-slate-200/40 rounded-lg" onclick="closeRejectModal()">Batal</button>
                        <button type="submit" class="py-2 px-4 text-[13.5px] font-semibold bg-rose-600 text-white hover:bg-rose-700 rounded-lg">Kirim Penolakan</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openRejectModal() {
                const overlay = document.getElementById('rejectModalOverlay');
                overlay.classList.replace('hidden', 'flex');
                setTimeout(() => overlay.firstElementChild.classList.remove('scale-99', 'opacity-0'), 20);
            }

            function closeRejectModal() {
                const overlay = document.getElementById('rejectModalOverlay');
                overlay.firstElementChild.classList.add('scale-99', 'opacity-0');
                setTimeout(() => overlay.classList.replace('flex', 'hidden'), 180);
            }

            document.getElementById('rejectModalOverlay').addEventListener('click', function(e) {
                if (e.target === this) closeRejectModal();
            });
        </script>
    @endif
</x-admin-layout>
