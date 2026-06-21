@php
    $unreadCount = auth()->user()->unreadNotifications->count();
    $notifications = auth()->user()->notifications()->take(5)->get();
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false">
    <button
        @click="open = !open"
        type="button"
        class="w-[38px] h-[38px] rounded-[9px] flex items-center justify-center bg-surface border border-slate-200 text-textCustom-600 relative text-[14.5px] hover:bg-white hover:text-navy-900 hover:border-textCustom-400 transition-all outline-none"
        aria-label="Notifikasi"
    >
        <i class="fa-regular fa-bell"></i>

        @if($unreadCount > 0)
            <span class="absolute top-2 right-2 w-[7px] h-[7px] rounded-full bg-red-600 border-[1.5px] border-white animate-pulse"></span>
        @endif
    </button>

    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
        class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-slate-200 overflow-hidden z-50 divide-y divide-slate-100 animate-in fade-in"
        style="display: none;"
    >
        <div class="px-4 py-3 bg-navy-900 text-white flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="font-bold text-xs tracking-tight">Notifikasi</span>
                @if($unreadCount > 0)
                    <span class="px-1.5 py-0.5 text-[10px] font-bold bg-teal-500 text-white rounded font-mono">
                        {{ $unreadCount }} Baru
                    </span>
                @endif
            </div>
            @if($unreadCount > 0)
                <form action="{{ route('notifications.markAllRead') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-[11px] font-semibold text-teal-400 hover:text-teal-300 transition-colors outline-none">
                        Tandai semua dibaca
                    </button>
                </form>
            @endif
        </div>

        <div class="max-h-80 overflow-y-auto divide-y divide-slate-50">
            @forelse($notifications as $notif)
                <a
                    href="{{ route('notifications.read', $notif->id) }}"
                    class="block px-4 py-3 transition-colors {{ $notif->read_at ? 'bg-white hover:bg-slate-50/80 text-slate-500' : 'bg-slate-50/70 hover:bg-slate-50 text-slate-900 font-medium' }}"
                >
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-0.5">
                            @php
                                $color = $notif->data['color'] ?? 'blue';
                                $icon  = $notif->data['icon'] ?? 'bell';

                                // Mapping warna kustom agar masuk ke tema antarmuka Anda
                                $colorMap = [
                                    'green' => 'bg-teal-50 text-teal-600 border border-teal-100',
                                    'red'   => 'bg-rose-50 text-rose-600 border border-rose-100',
                                    'blue'  => 'bg-indigo-50 text-indigo-600 border border-indigo-100',
                                ];
                            @endphp
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs shadow-sm {{ $colorMap[$color] ?? $colorMap['blue'] }}">
                                @if($icon === 'check-circle')
                                    <i class="fa-solid fa-circle-check"></i>
                                @elseif($icon === 'x-circle')
                                    <i class="fa-solid fa-circle-xmark"></i>
                                @else
                                    <i class="fa-solid fa-bell"></i>
                                @endif
                            </div>
                        </div>

                        <div class="flex-1 min-w-0 leading-normal">
                            <p class="text-xs {{ $notif->read_at ? 'text-slate-600' : 'text-slate-900 font-semibold' }}">
                                {{ $notif->data['message'] ?? 'Notifikasi baru diterima' }}
                            </p>
                            <span class="text-[10px] text-slate-400 block mt-1 font-medium">
                                <i class="fa-regular fa-clock mr-0.5"></i>{{ $notif->created_at->diffForHumans() }}
                            </span>
                        </div>

                        @if(!$notif->read_at)
                            <span class="w-1.5 h-1.5 bg-teal-500 rounded-full flex-shrink-0 mt-2 shadow-sm"></span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="px-4 py-8 text-center text-slate-400 text-xs space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-300 flex items-center justify-center text-sm mx-auto border border-slate-100/60 shadow-sm">
                        <i class="fa-regular fa-folder-open"></i>
                    </div>
                    <p class="italic">Belum ada notifikasi baru untuk Anda.</p>
                </div>
            @endforelse
        </div>

        @if($notifications->isNotEmpty())
            <div class="px-4 py-2 bg-slate-50 border-t border-slate-100 text-center">
                <a href="{{ route('notifications.index') }}" class="text-[11px] text-navy-900 hover:text-teal-600 font-bold transition-colors inline-block">
                    Lihat Semua Notifikasi <i class="fa-solid fa-arrow-right-long ml-0.5 text-[10px]"></i>
                </a>
            </div>
        @endif
    </div>
</div>
