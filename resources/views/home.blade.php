<x-app-layout>
    <x-slot:title>Home — JTIK POLSUB Showcase</x-slot:title>

    <section id="home" class="overflow-hidden">
        <div class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-12 px-6 py-16 lg:grid-cols-2 lg:py-20">
            <div>
                <span class="badge bg-blue-50 text-blue-700">SHOWCASE PLATFORM</span>
                <h1 class="mt-5 text-4xl font-extrabold leading-tight text-navy-900 sm:text-5xl">Karya Terbaik Mahasiswa JTIK POLSUB</h1>
                <p class="mt-5 max-w-md text-base leading-relaxed text-slate-500">Platform apresiasi dan showcase hasil Project Based Learning (PBL) mahasiswa Jurusan Teknik Informatika dan Komputer Politeknik Negeri Subang.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('project.index') }}" class="btn-primary">
                        Jelajahi Project
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
                    </a>
                    <a href="{{ route('project.index', ['sort' => 'popular']) }}" class="btn-outline">Lihat Terpopuler</a>
                </div>
            </div>
            <div class="relative mx-auto w-full max-w-lg">
                <div class="rounded-2xl bg-white p-3 shadow-2xl ring-1 ring-slate-200 transition-transform duration-500 hover:rotate-0" style="transform: rotate(4deg);">
                    <img src="{{ asset('image/image.png') }}" alt="Dashboard preview" class="w-full rounded-xl" style="transform: rotate(-2deg);">
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 pb-4">
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">

            <div class="card flex items-center gap-3 px-4 py-4">
                <span class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                    <i class="fa-regular fa-folder-open text-lg"></i>
                </span>
                <div>
                    <p class="text-xs text-slate-500">Total Project</p>
                    <p class="text-xl font-bold text-navy-900">{{ number_format($stats['total_projects'] ?? 0) }}</p>
                </div>
            </div>

            <div class="card flex items-center gap-3 px-4 py-4">
                <span class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                    <i class="fa-solid fa-user-graduate text-lg"></i>
                </span>
                <div>
                    <p class="text-xs text-slate-500">Prodi Aktif</p>
                    <p class="text-xl font-bold text-navy-900">{{ $stats['active_programs'] ?? 0 }}</p>
                </div>
            </div>

            <div class="card flex items-center gap-3 px-4 py-4">
                <span class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                    <i class="fa-solid fa-desktop text-lg"></i>
                </span>
                <div>
                    <p class="text-xs text-slate-500">Live Demo</p>
                    <p class="text-xl font-bold text-navy-900">{{ number_format($stats['total_live_demos'] ?? 0) }}</p>
                </div>
            </div>

            <div class="card flex items-center gap-3 px-4 py-4">
                <span class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                    <i class="fa-solid fa-users text-lg"></i>
                </span>
                <div>
                    <p class="text-xs text-slate-500">Total Tim</p>
                    <p class="text-xl font-bold text-navy-900">{{ number_format($stats['total_teams'] ?? 0) }}</p>
                </div>
            </div>

        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-14">
        <div class="flex flex-wrap items-end justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-navy-900">Project Terbaru Mahasiswa</h2>
                <p class="mt-1 text-sm text-slate-500">Luaran Project Based Learning teranyar yang baru saja diterbitkan.</p>
            </div>
            <a href="{{ route('project.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-navy-700 hover:text-navy-900">
                Lihat Semua
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
            </a>
        </div>

        <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-3">
            @forelse($latestProjects as $project)
                @if(isset($project))
                    <article class="card overflow-hidden hover:shadow-lg transition flex flex-col h-full group bg-white rounded-xl border border-slate-100 shadow-sm">

                        <div class="relative overflow-hidden">
                            <a href="{{ route('project.show', data_get($project, 'slug', '')) }}" class="block overflow-hidden">
                                @php
                                    $thumbnailUrl = null;
                                    if (is_object($project)) {
                                        $thumbnailUrl = $project->getFirstMediaUrl('thumbnail', 'card-thumbnail')
                                            ?: $project->getFirstMediaUrl('thumbnail');
                                    } else {
                                        $thumbnailUrl = data_get($project, 'thumbnail_url') ?? data_get($project, 'cached_thumbnail');
                                    }
                                @endphp

                                <img src="{{ $thumbnailUrl ?: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=600&auto=format&fit=crop' }}"
                                    class="h-52 w-full object-cover group-hover:scale-105 transition duration-500"
                                    alt="{{ data_get($project, 'title', '') }}">
                            </a>

                            @if(data_get($project, 'demo_status') === 'active' || data_get($project, 'demo_url'))
                                <span class="absolute right-3 top-3 inline-flex items-center gap-1.5 rounded-md bg-red-600 px-2.5 py-1 text-xs font-bold text-white shadow-sm">
                                    <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span> LIVE
                                </span>
                            @endif
                        </div>

                        <div class="p-6 flex flex-col flex-1 justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-3">
                                    @php
                                        // Ambil kode warna dari database, sediakan fallback jika kosong
                                        $colorCode = data_get($project, 'program.color_code', '#3B82F6');
                                    @endphp

                                    <span class="inline-block rounded px-2 py-0.5 text-xs font-bold uppercase tracking-wide"
                                        style="--badge-color: {{ $colorCode }}; color: var(--badge-color); background-color: rgb(from var(--badge-color) r g b / 0.15);">
                                        {{ data_get($project, 'program.short_name', 'SI') }}
                                    </span>
                                    <span class="text-sm font-medium text-slate-400">&bull;</span>
                                    <span class="text-sm font-medium text-slate-500">
                                        {{ data_get($project, 'cohort', '2024') }}
                                    </span>
                                </div>

                                <h3 class="text-lg font-bold text-slate-900 hover:text-navy-700 transition line-clamp-1">
                                    <a href="{{ route('project.show', data_get($project, 'slug', '')) }}">
                                        {{ data_get($project, 'title', '') }}
                                    </a>
                                </h3>

                                <p class="mt-2 text-sm leading-relaxed text-slate-500 line-clamp-2">
                                    {{ data_get($project, 'short_description') ?? (data_get($project, 'description') ?? 'Sistem monitoring dengan dashboard analitik.') }}
                                </p>
                            </div>

                            <div>
                                <div class="my-4 border-t border-slate-200/80"></div>

                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-2 text-slate-600 min-w-0">
                                        <i class="fa-regular fa-user text-xs text-slate-400 flex-shrink-0"></i>
                                        <span class="font-medium truncate max-w-[160px]">
                                            {{ data_get($project, 'team_name', 'Team Alpha') }}
                                        </span>
                                    </div>

                                    <span class="flex items-center gap-1.5 font-semibold text-slate-500 flex-shrink-0 text-xs">
                                        <i class="fa-regular fa-eye text-slate-400 text-sm"></i>
                                        <span>{{ number_format(data_get($project, 'views_count', 0)) }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </article>
                @endif
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 italic text-sm bg-slate-50/50 rounded-xl border border-dashed border-slate-200">
                    Belum ada data project terbaru yang diterbitkan.
                </div>
            @endforelse
        </div>
    </section>
</x-app-layout>
