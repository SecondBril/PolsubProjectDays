<header x-data="{ mobileOpen: false, userDropdown: false }" class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/80 backdrop-blur-md">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-3.5">

        {{-- BRAND LOGO --}}
        <a href="/" class="text-base font-black tracking-tight text-navy-900 flex items-center gap-2 outline-none">
            <span class="w-2.5 h-5 bg-navy-800 rounded-sm inline-block sm:hidden"></span>
            POLS-HUB JTIK
        </a>

        {{-- DESKTOP NAVIGATION --}}
        <nav class="hidden items-center gap-7 text-xs font-semibold text-slate-500 md:flex">
            <a href="/" @class([
                'relative py-1.5 transition-colors duration-150 outline-none',
                'text-navy-900 font-bold' => request()->is('/'),
                'hover:text-navy-900' => !request()->is('/')
            ])>
                Home
                @if(request()->is('/'))
                    <span class="absolute bottom-0 left-0 h-[2px] w-full rounded-full bg-navy-800"></span>
                @endif
            </a>

            <a href="/project" @class([
                'relative py-1.5 transition-colors duration-150 outline-none',
                'text-navy-900 font-bold' => request()->routeIs('project*'),
                'hover:text-navy-900' => !request()->routeIs('project*')
            ])>
                Projects
                @if(request()->routeIs('project*'))
                    <span class="absolute bottom-0 left-0 h-[2px] w-full rounded-full bg-navy-800"></span>
                @endif
            </a>

            <a href="/about" @class([
                'relative py-1.5 transition-colors duration-150 outline-none',
                'text-navy-900 font-bold' => request()->is('about'),
                'hover:text-navy-900' => !request()->is('about')
            ])>
                About
                @if(request()->is('about'))
                    <span class="absolute bottom-0 left-0 h-[2px] w-full rounded-full bg-navy-800"></span>
                @endif
            </a>
        </nav>

        {{-- DESKTOP RIGHT UTILITIES --}}
        <div class="hidden items-center gap-4 md:flex">
            @auth
                <a href="/submit-project" class="inline-flex items-center justify-center px-3.5 py-1.5 bg-navy-800 hover:bg-teal-600 text-white rounded-lg text-xs font-semibold shadow-sm transition-colors">Submit Project</a>

                <x-notification-bell />

                {{-- USER DROPDOWN KUSTOM --}}
                <div class="relative">
                    <button @click="userDropdown = !userDropdown"
                            @click.away="userDropdown = false"
                            class="inline-flex items-center gap-2 pl-2 pr-2.5 py-1 border border-slate-200 rounded-full text-xs font-bold text-slate-700 bg-slate-50 hover:bg-slate-100/80 transition-colors focus:outline-none">
                        <div class="w-6 h-6 rounded-full bg-navy-900 text-white flex items-center justify-center font-mono text-[10px] shadow-sm uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <span class="max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200" :class="userDropdown ? 'rotate-180' : ''"></i>
                    </button>

                    {{-- MENU DROPDOWN CONTENT --}}
                    <div x-show="userDropdown"
                         x-cloak
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 rounded-xl border border-slate-200 bg-white py-1.5 shadow-xl z-50">

                        <div class="px-3 py-2 border-b border-slate-100 mb-1">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nomor Induk</p>
                            <p class="font-mono text-xs font-semibold text-slate-700 truncate">{{ Auth::user()->nim_nidn ?? '-' }}</p>
                        </div>

                        <a href="/profile" class="flex items-center gap-2 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                            <i class="fa-regular fa-circle-user text-slate-400 text-sm w-4"></i> Profile Saya
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="flex items-center gap-2 px-3 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50/60 transition-colors">
                                <i class="fa-solid fa-arrow-right-from-bracket text-rose-400 text-sm w-4"></i> {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-xs font-bold text-slate-600 hover:text-navy-900 transition-colors">Sign In</a>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-3.5 py-1.5 bg-navy-900 hover:bg-navy-950 text-white rounded-lg text-xs font-semibold shadow-sm transition-colors">Register</a>
            @endauth
        </div>

        {{-- MOBILE UTILITIES (HAMBURGER & NOTIFICATION) --}}
        <div class="flex items-center gap-3 md:hidden">
            @auth
                {{-- PENDEKATAN A: Notifikasi ditaruh di sini agar selalu terlihat di luar --}}
                <div class="scale-90 origin-right">
                    <x-notification-bell />
                </div>
            @endauth

            <button @click="mobileOpen = !mobileOpen" class="text-slate-600 p-1 rounded-lg hover:bg-slate-100 focus:outline-none transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- MOBILE NAVIGATION PANEL --}}
    <div x-show="mobileOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="absolute left-0 right-0 border-b border-slate-200 bg-white px-6 py-4 md:hidden shadow-xl space-y-4 z-50">

        <div class="space-y-1">
            <a href="/" @class([
                'block py-2 px-3 rounded-lg text-xs font-semibold transition-colors',
                'bg-slate-50 text-navy-900 font-bold' => request()->is('/'),
                'text-slate-600 hover:bg-slate-50/50 hover:text-slate-900' => !request()->is('/')
            ])>Home</a>

            <a href="/project" @class([
                'block py-2 px-3 rounded-lg text-xs font-semibold transition-colors',
                'bg-slate-50 text-navy-900 font-bold' => request()->routeIs('project*'),
                'text-slate-600 hover:bg-slate-50/50 hover:text-slate-900' => !request()->routeIs('project*')
            ])>Projects</a>

            <a href="/about" @class([
                'block py-2 px-3 rounded-lg text-xs font-semibold transition-colors',
                'bg-slate-50 text-navy-900 font-bold' => request()->is('about'),
                'text-slate-600 hover:bg-slate-50/50 hover:text-slate-900' => !request()->is('about')
            ])>About</a>

            @auth
                <a href="/submit-project" @class([
                    'block py-2 px-3 rounded-lg text-xs font-semibold transition-colors',
                    'bg-slate-50 text-navy-900 font-bold' => request()->is('submit-project'),
                    'text-slate-600 hover:bg-slate-50/50 hover:text-slate-900' => !request()->is('submit-project')
                ])>Submit Project</a>
            @endauth
        </div>

        <div class="border-t border-slate-100 pt-3">
            @auth
                {{-- Panel Informasi Pengguna Mobile --}}
                <div class="flex items-center justify-between px-3 py-2 bg-slate-50 rounded-xl mb-2 border border-slate-100">
                    <div class="flex items-center gap-3 truncate">
                        <div class="w-8 h-8 rounded-full bg-navy-900 text-white flex items-center justify-center font-mono text-xs font-bold uppercase shrink-0">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="flex flex-col truncate">
                            <span class="text-xs font-bold text-slate-800 truncate">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] font-mono text-slate-400 truncate">{{ Auth::user()->email }}</span>
                        </div>
                    </div>

                    {{-- PENDEKATAN B: Jika ingin di dalam dropdown juga ada, hapus komen di bawah ini --}}
                    {{-- <div class="shrink-0"><x-notification-bell /></div> --}}
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <a href="/profile" class="flex items-center justify-center gap-1.5 py-2 rounded-lg border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50">
                        <i class="fa-regular fa-circle-user text-slate-400"></i> Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-1.5 py-2 rounded-lg bg-rose-50 border border-rose-100 text-xs font-bold text-rose-600 hover:bg-rose-100/80">
                            <i class="fa-solid fa-arrow-right-from-bracket text-rose-400"></i> Log Out
                        </button>
                    </form>
                </div>
            @else
                <div class="grid grid-cols-2 gap-2 pt-1">
                    <a href="{{ route('login') }}" class="flex items-center justify-center text-xs font-bold text-slate-600 py-2 border border-slate-200 rounded-xl hover:bg-slate-50">Sign In</a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center text-xs font-bold text-white py-2 bg-navy-900 hover:bg-navy-950 rounded-xl shadow-sm">Register</a>
                </div>
            @endauth
        </div>
    </div>
</header>
