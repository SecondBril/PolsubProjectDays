<x-app-layout>
    <x-slot:title>{{ $project->title }} — JTIK POLSUB Showcase</x-slot:title>

    <section class="relative h-[420px] w-full overflow-hidden">
        <img src="{{ $project->getFirstMediaUrl('thumbnail', 'detail-image') ?: ($project->getFirstMediaUrl('thumbnail') ?: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=1200&auto=format&fit=crop') }}"
            alt="{{ $project->title }}"
            class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-transparent"></div>

        @if($project->demo_status === 'live' || $project->demo_url)
            <span class="absolute right-6 top-6 inline-flex items-center gap-1.5 rounded-md bg-red-600 px-2.5 py-1 text-xs font-bold text-white shadow-md uppercase tracking-wider pointer-events-none">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                </span>
                LIVE
            </span>
        @endif

        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent">
            <div class="mx-auto max-w-7xl px-6 pb-10">

                <div class="flex flex-wrap items-center gap-2">
                    @php
                        $colorCode = $project->program?->color_code ?: '#3B82F6';
                    @endphp
                    <span class="inline-block rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wide text-white"
                        style="background-color: {{ $colorCode }};">
                        {{ $project->program?->short_name ?? ($project->program?->slug ?? 'SI') }}
                    </span>

                    <span class="inline-block rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white ring-1 ring-white/20">
                        {{ $project->category?->name ?? 'IoT System' }}
                    </span>
                </div>

                <h1 class="mt-4 text-3xl font-extrabold text-white tracking-tight sm:text-5xl lg:text-6xl">
                    {{ $project->title }}
                </h1>
                <p class="mt-2 text-sm font-medium text-white/60 sm:text-base">
                    {{ $project->team_name ?? 'Tim Developer' }} &mdash; Angkatan {{ $project->cohort ?? '2024' }}
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    @if($project->repository_url)
                        <a href="{{ $project->repository_url }}" target="_blank"
                        class="inline-flex items-center gap-2 rounded-lg border border-white/20 bg-white/5 px-4 py-2.5 text-sm font-semibold text-white backdrop-blur-sm hover:bg-white/15 transition shadow-sm">
                            <i class="fa-brands fa-github text-base"></i>
                            GitHub
                        </a>
                    @endif

                    @if($project->documentation_url)
                        <a href="{{ asset($project->documentation_url) }}" target="_blank"
                        class="inline-flex items-center gap-2 rounded-lg border border-white/20 bg-white/5 px-4 py-2.5 text-sm font-semibold text-white backdrop-blur-sm hover:bg-white/15 transition shadow-sm">
                            <i class="fa-regular fa-file-lines text-base"></i>
                            Laporan
                        </a>
                    @endif

                    @if($project->demo_url)
                        <a href="{{ $project->demo_url }}" target="_blank"
                        class="inline-flex items-center gap-2 rounded-lg bg-white px-5 py-2.5 text-sm font-bold text-slate-950 hover:bg-slate-100 transition shadow-md">
                            <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                            Buka Demo
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-10">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">

            <div class="space-y-10 lg:col-span-2">

                @if($project->demo_url)
                    <div class="card p-5">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <h2 class="flex items-center gap-2 font-bold text-navy-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="12" rx="2"/><path stroke-linecap="round" d="M8 20h8M12 16v4"/></svg>
                                Live Demo
                            </h2>
                            <a href="{{ $project->demo_url }}" target="_blank" class="btn-outline px-3 py-1.5 text-xs">Buka Demo di Tab Baru</a>
                        </div>

                        <div class="mt-4 border border-slate-200 rounded-lg overflow-hidden bg-slate-100 shadow-inner relative">
                            <img src="https://s0.wp.com/mshots/v1/{{ urlencode($project->demo_url) }}?w=1000"
                                class="w-full h-auto object-cover opacity-90 hover:opacity-100 transition max-h-[400px]"
                                loading="lazy"
                                onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='flex';"
                                alt="Live Demo Preview - {{ $project->title ?? 'Project' }}">

                            {{-- Fallback kalau screenshot gagal di-generate --}}
                            <div class="hidden w-full h-[300px] flex-col items-center justify-center text-slate-400 gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="12" rx="2"/><path stroke-linecap="round" d="M8 20h8M12 16v4"/></svg>
                                <p class="text-sm">Preview belum tersedia, lihat langsung di demo</p>
                            </div>
                        </div>
                    </div>
                @endif
                <div>
                    <h2 class="text-xl font-bold text-navy-900">Tentang Project</h2>
                    <div class="mt-3 text-justify leading-relaxed text-slate-600 space-y-4">
                        {!! nl2br(e($project->description ?? $project->short_description)) !!}
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-navy-900">Fitur Utama</h2>
                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="card flex flex-col items-center gap-3 px-4 py-6 text-center">
                            <span class="text-navy-700"><svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19V9m6 10V5m6 14v-7"/></svg></span>
                            <p class="font-semibold text-navy-900 text-sm">Real-time Monitoring</p>
                        </div>
                        <div class="card flex flex-col items-center gap-3 px-4 py-6 text-center">
                            <span class="text-navy-700"><svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 17l5-5 4 4 8-8m0 0h-5m5 0v5"/></svg></span>
                            <p class="font-semibold text-navy-900 text-sm">Predictive Analytics</p>
                        </div>
                        <div class="card flex flex-col items-center gap-3 px-4 py-6 text-center">
                            <span class="text-navy-700"><svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3s6 6.5 6 10.5a6 6 0 11-12 0C6 9.5 12 3 12 3z"/></svg></span>
                            <p class="font-semibold text-navy-900 text-sm">Automated Systems</p>
                        </div>
                    </div>
                </div>

                @if($project->tags->isNotEmpty())
                    <div>
                        <h2 class="text-xl font-bold text-navy-900">Tech Stack</h2>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($project->tags as $tag)
                                <span class="rounded-full bg-slate-100 px-4 py-1.5 text-xs font-medium text-slate-600">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div>
                    <h2 class="text-xl font-bold text-navy-900">Anggota Tim</h2>
                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        @forelse($project->teamMembers as $member)
                            <div class="card flex flex-col items-center gap-2 px-4 py-6 text-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=E2E8F0&color=1E293B"
                                     class="h-16 w-16 rounded-full ring-2 ring-navy-100 object-cover"
                                     alt="{{ $member->name }}">
                                <p class="font-bold text-navy-900 text-sm line-clamp-1">{{ $member->name }}</p>
                                <p class="text-xs text-slate-400">{{ $member->nim_nidn }}</p>
                                <span class="badge bg-slate-100 text-slate-600">
                                    {{ $member->pivot->role ?? ($project->team_lead_id === $member->id ? 'Project Leader' : 'Developer') }}
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400 italic">Data anggota tidak terdaftar.</p>
                        @endforelse
                    </div>
                </div>

                @if($screenshots->isNotEmpty())
                    <div>
                        <h2 class="text-xl font-bold text-navy-900">Galeri Screenshot</h2>
                        <div class="mt-4 flex gap-4 overflow-x-auto pb-2 snap-x">
                            @foreach($screenshots as $screenshot)
                                <a href="{{ $screenshot->getUrl() }}" target="_blank" class="flex-none snap-start">
                                    <img src="{{ $screenshot->getUrl('card-thumbnail') ?? $screenshot->getUrl() }}"
                                         class="h-32 w-48 rounded-lg object-cover border border-slate-200 shadow-sm hover:shadow-md transition"
                                         alt="Screenshot Galeri">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <aside class="card h-fit p-6 sticky top-24">
                <h3 class="border-b border-slate-100 pb-4 font-bold text-navy-900 text-sm">Metadata Project</h3>
                <dl class="space-y-4 pt-4 text-xs">
                    <div>
                        <dt class="text-slate-500">Dosen Pembimbing / Pengampu</dt>
                        <dd class="mt-0.5 font-semibold text-navy-900 flex flex-wrap gap-1.5">
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
                        <dt class="text-slate-500">Semester</dt>
                        <dd class="mt-0.5 font-semibold text-navy-900">
                            {{ $project->courseClass?->semester?->name ?? 'Genap 2025/2026' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Mata Kuliah</dt>
                        <dd class="mt-0.5 font-semibold text-navy-900">
                            {{ $project->courseClass?->course?->name ?? 'Project Based Learning' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Prodi</dt>
                        <dd class="mt-0.5 font-semibold text-navy-900">
                            {{ $project->program?->name ?? 'Teknologi Rekayasa Perangkat Lunak' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Kategori</dt>
                        <dd class="mt-0.5 font-semibold text-navy-900">{{ $project->category?->name ?? 'IoT System' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Tanggal Publish</dt>
                        <dd class="mt-0.5 font-semibold text-navy-900">
                            {{ $project->published_at ? $project->published_at->translatedFormat('d F Y') : '1 Januari 2026' }}
                        </dd>
                    </div>
                </dl>

                <div class="my-5 border-t border-slate-100"></div>

                <div class="bg-slate-50 rounded-xl p-3.5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 shadow-sm">
                            <i class="fa-regular fa-eye text-sm"></i>
                        </span>
                        <p class="text-xs font-semibold text-slate-500">Total Kunjungan Publik</p>
                    </div>
                    <p class="text-xl font-black text-navy-900 tracking-tight">
                        {{ number_format($project->views_count ?? 0) }}
                    </p>
                </div>

                <div class="mt-6 space-y-3">
                    @if($project->repository_url)
                        <a href="{{ $project->repository_url }}" target="_blank" class="btn-primary w-full text-center py-2.5 text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5L21 3m0 0h-5.5M21 3v5.5M10 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-4"/></svg>
                            GitHub Repository
                        </a>
                    @endif

                    @if($project->documentation_url)
                        <a href="{{ asset($project->documentation_url) }}" download class="btn-outline w-full text-center py-2.5 text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
                            Download Laporan
                        </a>
                    @endif
                </div>
            </aside>
        </div>
    </section>
</x-app-layout>
