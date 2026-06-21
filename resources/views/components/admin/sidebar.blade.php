<aside class="w-sidebar bg-navy-900 bg-gradient-to-b from-navy-900 to-navy-950 fixed top-0 left-0 bottom-0 flex flex-col z-40 border-r border-white/5" x-data="{ openProfile: false }">
    {{-- LOGO PANEL --}}
    <div class="flex items-center gap-[11px] p-[22px_22px_20px_22px] border-b border-white/5">
        <div class="w-9 h-9 rounded-[10px] bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center text-white font-extrabold text-[14px] shadow-[0_2px_8px_rgba(14,165,168,0.35)] shrink-0">
            JT
        </div>
        <div class="flex flex-col leading-[1.25]">
            <span class="text-white font-bold text-[14.5px] tracking-[0.2px]">JTIK Showcase</span>
            <span class="text-white/45 text-[11px] font-medium">Admin Panel</span>
        </div>
    </div>

    {{-- NAVIGASI UTAMA --}}
    <nav class="flex-1 overflow-y-auto p-[18px_14px]">
        {{-- Group Utama --}}
        <div class="mb-[22px]">
            <div class="text-white/30 text-[10.5px] font-bold uppercase tracking-[0.8px] px-2.5 pb-2">Utama</div>

            {{-- Dashboard Link --}}
            <a class="flex items-center gap-[11px] py-[9.5px] px-3 rounded-[9px] text-[13.5px] font-medium mb-0.5 relative transition-colors duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-teal-500/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}"
               href="{{ route('admin.dashboard') }}">
                @if(request()->routeIs('admin.dashboard'))
                    <span class="absolute left-[-14px] top-1/2 -translate-y-1/2 w-[3px] h-[18px] bg-teal-500 rounded-r-[3px]"></span>
                @endif
                <i class="fa-solid fa-chart-pie w-[17px] text-center text-[14.5px] shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-teal-500' : '' }}"></i>Dashboard
            </a>

            {{-- Kelola Project Link --}}
            <a class="flex items-center gap-[11px] py-[9.5px] px-3 rounded-[9px] text-[13.5px] font-medium mb-0.5 relative transition-colors duration-150 {{ request()->routeIs('admin.projects.*') ? 'bg-teal-500/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}"
               href="{{ route('admin.projects.index') }}">
                @if(request()->routeIs('admin.projects.*'))
                    <span class="absolute left-[-14px] top-1/2 -translate-y-1/2 w-[3px] h-[18px] bg-teal-500 rounded-r-[3px]"></span>
                @endif
                <i class="fa-solid fa-diagram-project w-[17px] text-center text-[14.5px] shrink-0 {{ request()->routeIs('admin.projects.*') ? 'text-teal-500' : '' }}"></i>Kelola Project
            </a>
        </div>

        {{-- Group Manajemen Data Akademik & Master Data --}}
        <div class="mb-[22px]">
            <div class="text-white/30 text-[10.5px] font-bold uppercase tracking-[0.8px] px-2.5 pb-2">Manajemen</div>

            {{-- Kelola Users --}}
            <a class="flex items-center gap-[11px] py-[9.5px] px-3 rounded-[9px] text-[13.5px] font-medium mb-0.5 relative transition-colors duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-teal-500/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}"
               href="{{ route('admin.users.index') }}">
                @if(request()->routeIs('admin.users.*'))
                    <span class="absolute left-[-14px] top-1/2 -translate-y-1/2 w-[3px] h-[18px] bg-teal-500 rounded-r-[3px]"></span>
                @endif
                <i class="fa-solid fa-users w-[17px] text-center text-[14.5px] shrink-0 {{ request()->routeIs('admin.users.*') ? 'text-teal-500' : '' }}"></i>Persetujuan User
            </a>

            {{-- Kelola Kategori --}}
            <a class="flex items-center gap-[11px] py-[9.5px] px-3 rounded-[9px] text-[13.5px] font-medium mb-0.5 relative transition-colors duration-150 {{ request()->routeIs('admin.category.*') ? 'bg-teal-500/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}"
               href="{{ route('admin.category.index') }}">
                @if(request()->routeIs('admin.category.*'))
                    <span class="absolute left-[-14px] top-1/2 -translate-y-1/2 w-[3px] h-[18px] bg-teal-500 rounded-r-[3px]"></span>
                @endif
                <i class="fa-solid fa-layer-group w-[17px] text-center text-[14.5px] shrink-0 {{ request()->routeIs('admin.category.*') ? 'text-teal-500' : '' }}"></i>Kategori Aplikasi
            </a>

            {{-- Kelola Program Studi --}}
            <a class="flex items-center gap-[11px] py-[9.5px] px-3 rounded-[9px] text-[13.5px] font-medium mb-0.5 relative transition-colors duration-150 {{ request()->routeIs('admin.programs.*') ? 'bg-teal-500/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}"
               href="{{ route('admin.programs.index') }}">
                @if(request()->routeIs('admin.programs.*'))
                    <span class="absolute left-[-14px] top-1/2 -translate-y-1/2 w-[3px] h-[18px] bg-teal-500 rounded-r-[3px]"></span>
                @endif
                <i class="fa-solid fa-graduation-cap w-[17px] text-center text-[14.5px] shrink-0 {{ request()->routeIs('admin.programs.*') ? 'text-teal-500' : '' }}"></i>Program Studi
            </a>

            {{-- Kelola Kelas Kuliah --}}
            <a class="flex items-center gap-[11px] py-[9.5px] px-3 rounded-[9px] text-[13.5px] font-medium mb-0.5 relative transition-colors duration-150 {{ request()->routeIs('admin.academic.*') ? 'bg-teal-500/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}"
               href="{{ route('admin.academic.index') }}">
                @if(request()->routeIs('admin.academic.*'))
                    <span class="absolute left-[-14px] top-1/2 -translate-y-1/2 w-[3px] h-[18px] bg-teal-500 rounded-r-[3px]"></span>
                @endif
                <i class="fa-solid fa-chalkboard-user w-[17px] text-center text-[14.5px] shrink-0 {{ request()->routeIs('admin.academic.*') ? 'text-teal-500' : '' }}"></i>Kelas &amp; Matkul
            </a>

            {{-- Kelola Tag Teknologi --}}
            <a class="flex items-center gap-[11px] py-[9.5px] px-3 rounded-[9px] text-[13.5px] font-medium mb-0.5 relative transition-colors duration-150 {{ request()->routeIs('admin.tags.*') ? 'bg-teal-500/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}"
               href="{{ route('admin.tags.index') }}">
                @if(request()->routeIs('admin.tags.*'))
                    <span class="absolute left-[-14px] top-1/2 -translate-y-1/2 w-[3px] h-[18px] bg-teal-500 rounded-r-[3px]"></span>
                @endif
                <i class="fa-solid fa-tags w-[17px] text-center text-[14.5px] shrink-0 {{ request()->routeIs('admin.tags.*') ? 'text-teal-500' : '' }}"></i>Tag Teknologi
            </a>
        </div>

        {{-- Group Sistem --}}
        <div>
            <div class="text-white/30 text-[10.5px] font-bold uppercase tracking-[0.8px] px-2.5 pb-2">Sistem</div>
            <a class="flex items-center gap-[11px] py-[9.5px] px-3 rounded-[9px] text-white/60 hover:text-white hover:bg-white/5 text-[13.5px] font-medium mb-0.5 relative transition-colors duration-150" href="{{ route('home') }}" target="_blank">
                <i class="fa-solid fa-globe w-[17px] text-center text-[14.5px] shrink-0"></i>Lihat Web Publik
            </a>
        </div>
    </nav>

    {{-- FOOTER PROFILE DENGAN INTERAKSI DROPDOWN (LOGOUT & PROFILE) --}}
    <div class="p-3.5 border-t border-white/5 relative">
        {{-- Dropdown Menu Popover --}}
        <div class="absolute bottom-[75px] left-3.5 right-3.5 bg-navy-950 border border-white/10 rounded-xl p-1.5 shadow-xl space-y-0.5 z-50 transition-all"
             x-show="openProfile"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             @click.away="openProfile = false" style="display: none;">

            <a href="/profile" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium text-white/70 hover:text-white hover:bg-white/5 transition-colors">
                <i class="fa-regular fa-user w-4 text-center text-[13px]"></i>Profil Saya
            </a>
            <div class="h-[1px] bg-white/5 my-1"></div>

            {{-- POST LOGOUT FORM --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 transition-colors text-left">
                    <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center text-[13px]"></i>Keluar Aplikasi
                </button>
            </form>
        </div>

        {{-- Tombol Trigger Profil Aktif --}}
        <button type="button" class="w-full flex items-center gap-2.5 p-2.5 rounded-[10px] hover:bg-white/5 transition-colors duration-150 text-left outline-none" @click="openProfile = !openProfile">
            <div class="w-[34px] h-[34px] rounded-[9px] bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center text-white font-bold text-[12.5px] shrink-0 uppercase">
                {{ substr(Auth::user()->name, 0, 2) }}
            </div>
            <div class="flex-1 min-w-0 leading-snug">
                <div class="text-white text-[13px] font-semibold truncate">{{ Auth::user()->name }}</div>
                <div class="text-white/40 text-[11px] capitalize">{{ Auth::user()->role ?? 'Administrator' }}</div>
            </div>
            <i class="fa-solid fa-chevron-down text-white/40 text-[12px] transition-transform duration-200" :class="openProfile ? 'rotate-180' : ''"></i>
        </button>
    </div>
</aside>
