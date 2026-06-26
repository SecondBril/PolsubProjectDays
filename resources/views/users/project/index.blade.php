<x-app-layout>
    <x-slot:title>Manajemen Pengajuan Proyek — POLS-HUB JTIK</x-slot:title>

    <div class="bg-slate-50 min-h-screen py-10">
        <div class="mx-auto max-w-7xl px-6">

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-slate-200 pb-6">
                <div>
                    <h1 class="text-2xl font-extrabold text-navy-900 tracking-tight">Pengajuan Proyek Saya</h1>
                    <p class="mt-1 text-sm text-slate-500">Kelola, pantau, dan ajukan hasil Project Based Learning (PBL) tim Anda di sini.</p>
                </div>
                <div>
                    <a href="{{ route('projects.create') }}" class="btn-primary flex items-center gap-2 shadow-sm text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Ajukan Proyek Baru
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mt-8">
                <div class="card p-5 flex items-center justify-between border-l-4 border-l-amber-500">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Menunggu Verifikasi</p>
                        <p class="text-2xl font-bold text-navy-900 mt-1">{{ $projects->where('status', 'pending')->count() }}</p>
                    </div>
                    <span class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                </div>
                <div class="card p-5 flex items-center justify-between border-l-4 border-l-emerald-500">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Telah Dipublikasi</p>
                        <p class="text-2xl font-bold text-navy-900 mt-1">{{ $projects->where('status', 'published')->count() }}</p>
                    </div>
                    <span class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                </div>
                <div class="card p-5 flex items-center justify-between border-l-4 border-l-rose-500">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Ditolak / Perlu Revisi</p>
                        <p class="text-2xl font-bold text-navy-900 mt-1">{{ $projects->where('status', 'rejected')->count() }}</p>
                    </div>
                    <span class="p-3 bg-rose-50 text-rose-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                    </span>
                </div>
            </div>

            <div class="mt-8">
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    <th class="px-6 py-4">Informasi Proyek</th>
                                    <th class="px-6 py-4">Mata Kuliah / Kelas</th>
                                    <th class="px-6 py-4">Tanggal Pengajuan</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-slate-100">
                                @forelse($projects as $project)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden flex-none">
                                                    @php
                                                        $rawUrl = $project->getFirstMediaUrl('thumbnail', 'card-thumbnail');

                                                        if (!$rawUrl) {
                                                            $rawUrl = $project->getFirstMediaUrl('thumbnail');
                                                        }

                                                        // FIX: Lakukan pembersihan URL jika mengandung karakter kurung kaki ()
                                                        $thumbnailUrl = null;
                                                        if ($rawUrl) {
                                                            // Pisahkan bagian path dan nama file agar domain tidak ikut ter-encode salah
                                                            $thumbnailUrl = str_replace(['(', ')'], ['%28', '%29'], $rawUrl);
                                                        }
                                                    @endphp

                                                    <img src="{{ $thumbnailUrl ?: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=150&auto=format&fit=crop' }}"
                                                        class="w-full h-full object-cover"
                                                        alt="{{ $project->title }}">
                                                </div>

                                                <div class="min-w-0">
                                                    <p class="font-bold text-navy-900 truncate max-w-xs">{{ $project->title }}</p>
                                                    <p class="text-xs text-slate-400 mt-0.5">
                                                        {{ $project->program?->name ?? 'Prodi N/A' }} &bull; Kelompok {{ $project->cohort ?? date('Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 vertical-align-middle">
                                            <p class="font-medium text-slate-700 truncate max-w-[180px]">{{ $project->courseClass?->course?->name ?? 'PBL Utama' }}</p>
                                            <p class="text-xs text-slate-400 mt-0.5">{{ $project->courseClass?->name ?? 'Kelas' }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                                            {{ $project->submitted_at ? $project->submitted_at->translatedFormat('d M Y, H:i') : $project->created_at->format('d M Y') }} WIB
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($project->status === 'published')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published
                                                </span>
                                            @elseif($project->status === 'rejected')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-50 text-rose-700 border border-rose-200" title="Alasan: {{ $project->rejected_reason }}">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Rejected
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending Review
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-3">
                                                @if($project->status === 'published')
                                                    <a href="{{ route('projects.edit', $project) }}" class="text-xs font-bold text-amber-600 hover:text-amber-900 hover:underline flex items-center gap-1">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        Edit
                                                    </a>

                                                    <span class="text-slate-300">|</span>

                                                    <a href="{{ route('project.show', $project->slug) }}" target="_blank" class="text-xs font-bold text-navy-600 hover:text-navy-900 hover:underline">
                                                        Lihat Publikasi →
                                                    </a>
                                                @elseif($project->status === 'rejected' && $project->rejected_reason)
                                                    <div x-data="{ showReason: false }" class="relative inline-block">
                                                        <button type="button" @click="showReason = !showReason" class="text-xs font-semibold text-rose-600 hover:text-rose-900 hover:underline">
                                                            Alasan Ditolak
                                                        </button>
                                                        <div x-show="showReason" x-cloak @click.outside="showReason = false" class="absolute right-0 mt-2 p-3 bg-slate-900 text-white text-xs rounded-lg w-64 shadow-xl text-left z-20 leading-relaxed">
                                                            <p class="font-bold text-rose-400 border-b border-white/10 pb-1 mb-1">Catatan Penolakan:</p>
                                                            {{ $project->rejected_reason }}
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-xs text-slate-400 italic">No action required</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                            <p class="mt-2 text-sm font-semibold text-slate-900">Belum ada pengajuan proyek</p>
                                            <p class="text-xs text-slate-400 mt-1">Gunakan tombol di atas untuk mengajukan luaran PBL Anda ke sistem platform showcase.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($projects->hasPages())
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                            {{ $projects->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
