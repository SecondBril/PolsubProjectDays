<div class="card bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-5">
    <div class="relative">
        <label class="flex items-center gap-2 text-sm font-semibold text-slate-800 tracking-tight">
            Cari & Tambah Anggota Tim
        </label>

        {{-- CATATAN SISTEM DINAMIS BERDASARKAN ROLE --}}
        <div class="mt-3">
            @if(Auth::user()->hasAnyRole(['admin', 'dosen']))
                <div class="flex gap-2.5 p-3 bg-amber-50/70 border border-amber-200/80 rounded-lg text-xs text-amber-800 leading-relaxed">
                    <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <strong class="font-semibold block mb-0.5 text-amber-900">Akses Manajemen (Admin/Dosen)</strong>
                        Anda memiliki otoritas penuh. Pastikan mahasiswa yang dipilih sebagai <span class="font-semibold text-amber-900 underline decoration-amber-300">Ketua Proyek</span> tidak ditambahkan kembali sebagai anggota untuk mencegah duplikasi data tim.
                    </div>
                </div>
            @else
                <div class="flex flex-col gap-3 p-4 bg-blue-50/60 border border-blue-200/60 rounded-xl text-xs text-blue-800">
                    <div class="flex gap-2.5 leading-relaxed">
                        <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 111.063.852l-.708 2.836a.75.75 0 001.063.852l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <strong class="font-semibold block mb-0.5 text-blue-900">Sistem Penguncian Otomatis</strong>
                            Akun Anda (<strong>{{ Auth::user()->name }}</strong>) otomatis dikunci sebagai <span class="font-semibold text-blue-900">Ketua Tim</span>. Anda wajib menambahkan minimal 1 hingga maksimal 4 anggota tim tambahan.
                        </div>
                    </div>

                    {{-- REVISI: INPUT KONTRIBUSI KETUA (MAHASISWA) --}}
                    <div class="mt-2 pt-3 border-t border-blue-200/50">
                        <label class="block text-[10px] font-bold text-blue-900 uppercase mb-1.5 tracking-wider">Kontribusi Anda Sebagai Ketua Tim <span class="text-rose-500">*</span></label>
                        <input type="text"
                               name="leader_contribution"
                               value="{{ old('leader_contribution') }}"
                               required
                               placeholder="Contoh: Project Manager, Merancang Arsitektur Database, dan Integrasi API..."
                               class="w-full text-xs rounded-lg border border-slate-200 bg-white px-3 py-2 text-slate-700 outline-none shadow-sm transition focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-4 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" wire:model.live="search" placeholder="Ketik NIM atau Nama Mahasiswa..."
                   class="block w-full pl-9 pr-3 py-2 text-sm rounded-lg border border-slate-200 bg-slate-50/50 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 placeholder:text-slate-400">
        </div>

        {{-- SEARCH RESULTS DROPDOWN --}}
        @if(!empty($searchResults))
            <div class="absolute z-30 mt-1.5 w-full bg-white border border-slate-200 rounded-xl shadow-xl max-h-64 overflow-y-auto divide-y divide-slate-100 overflow-hidden animate-in fade-in slide-in-from-top-1 duration-200">
                @php
                    $currentMemberIds = collect($selectedMembers)->pluck('id')->toArray();
                    $authId = Auth::id();
                    $isManagement = Auth::user()->hasAnyRole(['admin', 'dosen']);
                @endphp

                @foreach($searchResults as $student)
                    @php
                        $isLeader = (!$isManagement && $student->id === $authId);
                        $isChosen = in_array($student->id, $currentMemberIds);
                    @endphp

                    <button type="button"
                            wire:click="addMember('{{ $student->id }}')"
                            @disabled($isLeader || $isChosen)
                            @class([
                                'w-full text-left px-4 py-3 text-sm transition flex justify-between items-center',
                                'bg-slate-50/80 text-slate-400 cursor-not-allowed' => ($isLeader || $isChosen),
                                'hover:bg-slate-50 text-slate-700' => (!$isLeader && !$isChosen)
                            ])>

                        <div class="flex items-center gap-2.5">
                            <span @class([
                                'font-medium',
                                'text-slate-900' => (!$isLeader && !$isChosen)
                            ])>{{ $student->name }}</span>

                            @if($isLeader)
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-200/60 shadow-sm">Ketua Tim</span>
                            @elseif($isChosen)
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200 shadow-sm">Sudah Terpilih</span>
                            @endif
                        </div>

                        <span @class([
                            'text-xs font-mono px-2 py-0.5 rounded-md',
                            'bg-slate-200/50 text-slate-400' => ($isLeader || $isChosen),
                            'bg-slate-100 text-slate-500 border border-slate-200/50' => (!$isLeader && !$isChosen)
                        ])>{{ $student->nim_nidn }}</span>
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    {{-- LIST ANGGOTA TERPILIH --}}
    <div class="mt-4 pt-4 border-t border-slate-100">
        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-3">Daftar Anggota Tim & Kontribusi Pekerjaan:</span>

        <div class="space-y-3">
            @forelse($selectedMembers as $index => $member)
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 bg-slate-50 border border-slate-200/70 p-3 rounded-xl shadow-sm transition hover:border-indigo-200 relative group">

                    {{-- Identitas Mahasiswa --}}
                    <div class="w-full sm:w-1/3 flex flex-col justify-center">
                        <span class="text-xs font-semibold text-slate-800 leading-snug">{{ $member['name'] }}</span>
                        <div class="flex items-center gap-1.5 mt-1">
                            <span class="font-mono text-indigo-600 bg-indigo-50 border border-indigo-100 px-1.5 py-0.5 rounded text-[10px] font-medium">{{ $member['nim_nidn'] }}</span>
                        </div>
                    </div>

                    {{-- Input Teks Kontribusi Tugas Mandiri --}}
                    <div class="flex-1 relative">
                        <input type="text"
                               name="team_members[{{ $index }}][contribution]"
                               value="{{ old("team_members.{$index}.contribution", $member['contribution'] ?? '') }}"
                               required
                               placeholder="Contoh: Mengembangkan API Backend & Integrasi Payment Gateway..."
                               class="w-full text-xs rounded-lg border border-slate-200 bg-white px-3 py-2 text-slate-700 outline-none shadow-inner transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 placeholder:text-slate-400">
                    </div>

                    {{-- Input Hidden untuk Mengirimkan User ID Terkait --}}
                    <input type="hidden" name="team_members[{{ $index }}][user_id]" value="{{ $member['id'] }}">

                    {{-- Tombol Eliminasi Anggota dari Tim --}}
                    <div class="flex items-center justify-end">
                        <button type="button"
                                wire:click="removeMember('{{ $member['id'] }}')"
                                class="p-2 bg-rose-50 border border-rose-100 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition shadow-sm"
                                title="Keluarkan dari Tim">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                </div>
            @empty
                <div class="flex items-center gap-2 text-xs text-slate-400 italic py-3 bg-slate-50/50 rounded-xl border border-dashed border-slate-200 justify-center">
                    <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                    Belum ada anggota tim tambahan yang dipilih.
                </div>
            @endforelse
        </div>
    </div>
</div>
