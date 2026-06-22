<x-app-layout>
    <x-slot:title>Daftar Showcase Project — JTIK POLSUB</x-slot:title>

    <section class="bg-gradient-to-b from-slate-100 to-slate-50 border-b border-slate-200 py-10">
        <div class="mx-auto max-w-7xl px-6">
            <h1 class="text-3xl font-extrabold text-navy-900 md:text-4xl">Semua Project Mahasiswa</h1>
            <p class="mt-2 text-sm text-slate-500">Jelajahi hasil Project Based Learning (PBL) inovatif dari seluruh prodi di JTIK POLSUB.</p>

            <form action="{{ request()->url() }}" method="GET" class="mt-6 max-w-xl flex gap-2">
                @foreach(request()->except('search', 'page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach

                <div class="relative flex-1">
                    <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul project, teknologi, atau nama tim..." class="w-full ps-10 pe-4 py-2.5 bg-white border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent">
                </div>
                <button type="submit" class="btn-primary py-2.5 text-sm">Cari</button>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 pb-16 mt-8"
             x-data="{
                submitFilter() { $refs.filterForm.submit(); }
             }">

        <form id="filterForm" x-ref="filterForm" action="{{ request()->url() }}" method="GET">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

                <div class="lg:col-span-2">

                    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 pb-4">
                        <div class="flex flex-wrap gap-2">
                            <input type="hidden" name="program_id" id="program_id_input" value="{{ request('program_id') }}">

                            <button type="button"
                                    @click="document.getElementById('program_id_input').value = ''; submitFilter();"
                                    class="rounded-full border px-4 py-1.5 text-xs font-semibold transition {{ !request('program_id') ? 'bg-navy-800 text-white border-navy-800' : 'border-slate-300 text-slate-600 hover:bg-slate-100' }}">
                                Semua Prodi
                            </button>

                            @foreach($programs as $program)
                                <button type="button"
                                        @click="document.getElementById('program_id_input').value = '{{ $program->id }}'; submitFilter();"
                                        class="rounded-full border px-4 py-1.5 text-xs font-semibold transition {{ request('program_id') == $program->id ? 'bg-navy-800 text-white border-navy-800' : 'border-slate-300 text-slate-600 hover:bg-slate-100' }}">
                                    {{ $program->slug ?? $program->name }}
                                </button>
                            @endforeach
                        </div>

                        <div>
                            <select name="sort" @change="submitFilter()" class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-medium text-slate-600 focus:outline-none focus:ring-1 focus:ring-navy-500">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                                <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>A-Z (Judul)</option>
                                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Z-A (Judul)</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            </select>
                        </div>
                    </div>

                    @if(request()->anyFilled(['search', 'program_id', 'category_id', 'semester_id', 'tag_id']))
                        <div class="mt-4 flex flex-wrap gap-2 items-center">
                            <span class="text-xs text-slate-500 font-medium">Filter aktif:</span>
                            <a href="{{ request()->url() }}" class="badge bg-slate-200 text-slate-700 hover:bg-slate-300 transition">
                                Hapus Semua Filter ✕
                            </a>
                        </div>
                    @endif

                    <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2">
                        @forelse($projects as $project)
                            <article class="card overflow-hidden hover:shadow-lg transition flex flex-col h-full bg-white rounded-xl border border-slate-100 shadow-sm group">

                                <div class="relative overflow-hidden">
                                    <a href="{{ route('project.show', $project->slug) }}" class="block overflow-hidden">
                                        <img src="{{ $project->getFirstMediaUrl('thumbnail', 'card-thumbnail') ?: ($project->getFirstMediaUrl('thumbnail') ?: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=600&auto=format&fit=crop') }}"
                                            class="h-52 w-full object-cover group-hover:scale-105 transition duration-500"
                                            alt="{{ $project->title }}">
                                    </a>

                                    @if($project->demo_status === 'active' || $project->demo_url)
                                        <span class="absolute right-3 top-3 inline-flex items-center gap-1.5 rounded-md bg-red-600 px-2.5 py-1 text-xs font-bold text-white shadow-sm pointer-events-none">
                                            <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span> LIVE
                                        </span>
                                    @endif
                                </div>

                                <div class="p-6 flex flex-col flex-1 justify-between space-y-4">
                                    <div>
                                        <div class="flex items-center gap-2 mb-3">
                                            @php
                                                $colorCode = $project->program?->color_code ?: '#3B82F6';
                                            @endphp
                                            <span class="inline-block rounded px-2 py-0.5 text-xs font-bold uppercase tracking-wide pointer-events-none"
                                                style="--badge-color: {{ $colorCode }}; color: var(--badge-color); background-color: rgb(from var(--badge-color) r g b / 0.15);">
                                                {{ $project->program?->short_name ?? ($project->program?->slug ?? 'TRPL') }}
                                            </span>
                                            <span class="text-sm font-medium text-slate-400">&bull;</span>
                                            <span class="text-sm font-medium text-slate-500">
                                                {{ $project->cohort ?? date('Y') }}
                                            </span>
                                        </div>

                                        <h3 class="text-lg font-bold text-slate-900 hover:text-navy-700 transition line-clamp-1">
                                            <a href="{{ route('project.show', $project->slug) }}">
                                                {{ $project->title }}
                                            </a>
                                        </h3>

                                        <p class="mt-2 text-sm leading-relaxed text-slate-500 line-clamp-2">
                                            {{ $project->short_description ?? ($project->description ?? 'Sistem monitoring dengan dashboard analitik.') }}
                                        </p>

                                        {{-- REVISI KUSTOM 1: PRATINJAU INDIKATOR FITUR UTAMA --}}
                                        @if($project->features->isNotEmpty())
                                            <div class="mt-4 space-y-1.5">
                                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Fitur Utama:</span>
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($project->features->take(3) as $feature)
                                                        <span class="inline-flex items-center gap-1 text-[11px] font-medium text-navy-700 border border-slate-100 rounded-md px-2 py-0.5 max-w-full truncate" title="{{ $feature->name }}">
                                                            <i class="{{ $feature->icon ?? 'fa-solid fa-cube' }} text-navy-700 text-[10px]"></i>
                                                            <span class="truncate">{{ $feature->name }}</span>
                                                        </span>
                                                    @endforeach
                                                    @if($project->features->count() > 3)
                                                        <span class="text-[10px] font-bold text-indigo-600 self-center pl-1">+{{ $project->features->count() - 3 }} Lainnya</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        <div class="my-4 border-t border-slate-200/80"></div>

                                        <div class="flex items-center justify-between text-sm">
                                            <div class="flex items-center gap-2 text-slate-600 min-w-0">
                                                <i class="fa-regular fa-user text-xs text-slate-400 flex-shrink-0"></i>
                                                <span class="font-medium truncate max-w-[150px]">
                                                    {{ $project->team_name ?? 'Team-anonymous' }}
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
                        @empty
                            <div class="col-span-full py-12 text-center bg-slate-50/50 rounded-xl border border-dashed border-slate-200">
                                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-semibold text-slate-900">Project tidak ditemukan</h3>
                                <p class="mt-1 text-sm text-slate-500">Coba ubah kata kunci pencarian Anda atau bersihkan filter sisi samping.</p>
                            </div>
                        @endforelse
                    </div>



                    <div class="mt-10">
                        {{ $projects->links() }}
                    </div>
                </div>

                <aside class="space-y-6">

                    <div class="card p-5">
                        <h3 class="font-bold text-navy-900 text-sm">Periode Akademik</h3>
                        <div class="mt-3">
                            <select name="semester_id" @change="submitFilter()" class="w-full text-xs rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-600 focus:outline-none focus:ring-1 focus:ring-navy-500">
                                <option value="">Semua Semester</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->name }} ({{ $semester->year }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card p-5">
                        <h3 class="font-bold text-navy-900 text-sm">Kategori Utama</h3>
                        <p class="text-[11px] text-slate-400">Pilih rumpun aplikasi</p>

                        <div class="mt-4 space-y-2.5">
                            <label class="flex items-center gap-2.5 text-xs text-slate-600 cursor-pointer">
                                <input type="radio" name="category_id" value="" @change="submitFilter()" {{ !request('category_id') ? 'checked' : '' }} class="rounded-full border-slate-300 text-navy-700 focus:ring-navy-500">
                                <span>Semua Kategori</span>
                            </label>
                            @foreach($categories as $category)
                                <label class="flex items-center gap-2.5 text-xs text-slate-600 cursor-pointer">
                                    <input type="radio" name="category_id" value="{{ $category->id }}" @change="submitFilter()" {{ request('category_id') == $category->id ? 'checked' : '' }} class="rounded-full border-slate-300 text-navy-700 focus:ring-navy-500">
                                    <span>{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="card p-5">
                        <h3 class="font-bold text-navy-900 text-sm">Tags / Teknologi</h3>
                        <div class="mt-3 flex flex-wrap gap-1.5">
                            <input type="hidden" name="tag_id" id="tag_id_input" value="{{ request('tag_id') }}">
                            @foreach($tags as $tag)
                                <button type="button"
                                        @click="document.getElementById('tag_id_input').value = (document.getElementById('tag_id_input').value == '{{ $tag->id }}') ? '' : '{{ $tag->id }}'; submitFilter();"
                                        class="px-2.5 py-1 rounded text-[11px] font-medium transition {{ request('tag_id') == $tag->id ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                    #{{ $tag->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                </aside>
            </div>
        </form>
    </section>
</x-app-layout>
