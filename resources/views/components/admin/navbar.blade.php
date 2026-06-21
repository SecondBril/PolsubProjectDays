@props(['title'])

<header class="h-[68px] bg-panel border-b border-slate-200 flex items-center justify-between px-7 sticky top-0 z-30" x-data="{ userMenuOpen: false }">
    {{-- BAGIAN KIRI: BREADCRUMB & JUDUL HALAMAN --}}
    <div class="flex items-center gap-4">
        <div class="flex flex-col">
            <div class="text-[11px] font-semibold text-textCustom-400 uppercase tracking-[0.6px]">
                @if(request()->routeIs('admin.dashboard'))
                    Admin / Overview
                @elseif(request()->routeIs('admin.projects.*'))
                    Admin / Project Management
                @elseif(request()->routeIs('admin.users.*'))
                    Admin / User Management
                @else
                    Admin / Panel Data
                @endif
            </div>
            <h1 class="text-[18px] font-bold text-textCustom-900 mt-0.5">{{ $title }}</h1>
        </div>
    </div>

    {{-- BAGIAN KANAN: FITUR GLOBAL SEARCH, NOTIFIKASI, & PROFIL --}}
    <div class="flex items-center gap-2.5">
        {{-- Input Pencarian Global Admin --}}
        <form method="GET" action="{{ route('admin.projects.index') }}" class="hidden md:flex items-center gap-2.5 bg-surface border border-slate-200 rounded-[9px] p-[8px_12px] w-[260px] text-textCustom-400 focus-within:border-teal-500 focus-within:bg-white transition-colors">
            <i class="fa-solid fa-magnifying-glass text-[13px]"></i>
            <input class="border-none bg-transparent outline-none p-0 focus:ring-0 text-[13px] text-textCustom-900 w-full placeholder-textCustom-400" type="text" name="search" value="{{ request('search') }}" placeholder="Cari project, tim, mahasiswa...">
            <span class="text-[10.5px] text-textCustom-400 border border-slate-200 rounded-[5px] px-[5px] py-0.5 font-mono pointer-events-none">⌘K</span>
        </form>

        {{-- LONCENG NOTIFIKASI REALTIME (Mengambil Komponen yang Sama dengan User) --}}
        <div class="relative">
            <x-notification-bell />
        </div>

        {{-- PEMBATAS VISUAL --}}
        <div class="h-5 w-[1px] bg-slate-200 mx-1 hidden sm:block"></div>

        {{-- INTERAKSI DROPDOWN MENU PROFIL ADMIN --}}
        <div class="relative">
            <button type="button" @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2 outline-none focus:outline-none">
                <div class="w-[38px] h-[38px] rounded-[9px] bg-gradient-to-br from-[#6C7DFF] to-[#7C5CFC] flex items-center justify-center text-white font-bold text-[13px] shadow-sm uppercase shrink-0 transition-transform active:scale-95">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="hidden sm:flex flex-col text-left leading-tight">
                    <span class="text-xs font-semibold text-textCustom-900 truncate max-w-[100px]">{{ Auth::user()->name }}</span>
                    <span class="text-[10px] font-medium text-textCustom-400 capitalize">{{ Auth::user()->role ?? 'Admin' }}</span>
                </div>
                <i class="fa-solid fa-chevron-down text-textCustom-400 text-[10px] hidden sm:block transition-transform duration-200" :class="userMenuOpen ? 'rotate-180' : ''"></i>
            </button>

            {{-- PANEL DROPDOWN KONTEN --}}
            <div class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-xl p-1.5 shadow-xl space-y-0.5 z-50 transform origin-top-right transition-all"
                 x-show="userMenuOpen"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 @click.away="userMenuOpen = false"
                 style="display: none;">

                <a href="/profile" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium text-slate-600 hover:text-textCustom-900 hover:bg-slate-50 transition-colors">
                    <i class="fa-regular fa-user w-4 text-center text-[13px]"></i>Profil Admin
                </a>
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium text-slate-600 hover:text-textCustom-900 hover:bg-slate-50 transition-colors">
                    <i class="fa-solid fa-globe w-4 text-center text-[13px]"></i>Lihat Web Publik
                </a>

                <div class="h-[1px] bg-slate-100 my-1"></div>

                {{-- FORM METHOD POST LOGOUT (BREEZE / AUTH.PHP COMPATIBLE) --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium text-red-600 hover:text-red-700 hover:bg-red-50 transition-colors w-full text-left">
                        <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center text-[13px]"></i>{{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </div>
    </div>
</header>
