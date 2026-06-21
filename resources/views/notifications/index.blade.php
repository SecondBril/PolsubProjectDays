<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🔔 Notifikasi Saya
                @if($unreadCount > 0)
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        {{ $unreadCount }} baru
                    </span>
                @endif
            </h2>

            @if($notifications->count() > 0)
                <div class="flex gap-2">
                    @if($unreadCount > 0)
                        <form action="{{ route('notifications.markAllRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                                ✓ Tandai Semua Dibaca
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('notifications.clearAll') }}" method="POST"
                          onsubmit="return confirm('Hapus semua notifikasi?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition">
                            🗑 Hapus Semua
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            @forelse($notifications as $notif)
                <div class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition {{ $notif->read_at ? '' : 'bg-blue-50' }}">
                    <div class="p-5 flex items-start gap-4">
                        <!-- Icon -->
                        @php
                            $color = $notif->data['color'] ?? 'blue';
                            $icon  = $notif->data['icon'] ?? 'bell';
                            $colorMap = [
                                'green' => 'bg-green-100 text-green-600',
                                'red'   => 'bg-red-100 text-red-600',
                                'blue'  => 'bg-blue-100 text-blue-600',
                            ];
                        @endphp
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $colorMap[$color] ?? $colorMap['blue'] }}">
                                @if($icon === 'check-circle')
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @elseif($icon === 'x-circle')
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                                    </svg>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-base text-gray-900 {{ $notif->read_at ? '' : 'font-semibold' }}">
                                        {{ $notif->data['message'] ?? 'Notifikasi' }}
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $notif->created_at->format('d M Y, H:i') }}
                                        ({{ $notif->created_at->diffForHumans() }})
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    {{-- <a href="{{ route('notifications.read', $notif->id) }}"
                                       class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                        Buka →
                                    </a> --}}
                                    <form action="{{ route('notifications.destroy', $notif->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus notifikasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                            ✕
                                        </button>
                                    </form>
                                </div>
                            </div>

                            @if(isset($notif->data['reason']) && $notif->data['reason'])
                                <div class="mt-3 p-3 bg-red-50 border-l-4 border-red-400 rounded text-sm text-red-800">
                                    <strong>Alasan:</strong> {{ $notif->data['reason'] }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-gray-500 text-lg">Belum ada notifikasi</p>
                    <p class="text-gray-400 text-sm mt-1">Notifikasi akan muncul saat ada aktivitas terkait akun Anda.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
