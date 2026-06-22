<x-admin-layout>
    <x-slot:title>Dashboard Overview</x-slot:title>

    <div class="flex items-center justify-between mb-[22px]">
        <div>
            <p class="text-textCustom-600 text-[13.5px] mt-0.5">Ringkasan aktivitas platform showcase per hari ini, {{ now()->translatedFormat('d F Y') }}.</p>
        </div>
        <div class="flex gap-2.5">
            <button class="inline-flex items-center gap-2 py-[9.5px] px-4 rounded-[9px] text-[13.5px] font-semibold bg-white text-textCustom-900 border border-slate-200 hover:border-textCustom-400 transition-colors">
                <i class="fa-regular fa-calendar text-[12.5px]"></i>30 Hari Terakhir
            </button>
            <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-2 py-[9.5px] px-4 rounded-[9px] text-[13.5px] font-semibold bg-navy-900 text-white hover:bg-navy-800 transition-colors">
                <i class="fa-solid fa-plus text-[12.5px]"></i>Tambah Project
            </a>
        </div>
    </div>

    {{-- KARTU STATISTIK UTAMA --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-[18px] mb-[22px]">
        {{-- Total Project --}}
        <div class="bg-panel border border-slate-200 rounded-admin-md p-[20px_20px_18px_20px] shadow-admin-sm">
            <div class="flex items-start justify-between mb-3.5">
                <div class="w-[38px] h-[38px] rounded-[10px] flex items-center justify-center text-[15px] bg-teal-100 text-teal-600">
                    <i class="fa-solid fa-diagram-project"></i>
                </div>
            </div>
            <div class="text-[26px] font-extrabold text-textCustom-900 tracking-tight font-mono">{{ number_format($stats['total_projects']) }}</div>
            <div class="text-[12.5px] text-textCustom-600 font-medium mt-0.5">Total Project Disetujui</div>
        </div>

        {{-- Live Demo Aktif --}}
        <div class="bg-panel border border-slate-200 rounded-admin-md p-[20px_20px_18px_20px] shadow-admin-sm">
            <div class="flex items-start justify-between mb-3.5">
                <div class="w-[38px] h-[38px] rounded-[10px] flex items-center justify-center text-[15px] bg-emerald-50 text-emerald-600">
                    <i class="fa-solid fa-satellite-dish"></i>
                </div>
            </div>
            <div class="text-[26px] font-extrabold text-textCustom-900 tracking-tight font-mono">{{ number_format($stats['total_live_demos'] ?? 0) }}</div>
            <div class="text-[12.5px] text-textCustom-600 font-medium mt-0.5">Live Demo Aktif</div>
        </div>

        {{-- Pending Approvals (Kritis untuk Admin) --}}
        <div class="bg-panel border {{ $stats['pending_projects'] > 0 ? 'border-amber-300 bg-amber-50/40' : 'border-slate-200' }} rounded-admin-md p-[20px_20px_18px_20px] shadow-admin-sm">
            <div class="flex items-start justify-between mb-3.5">
                <div class="w-[38px] h-[38px] rounded-[10px] flex items-center justify-center text-[15px] bg-amber-100 text-amber-700">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                @if($stats['pending_projects'] > 0)
                    <div class="text-[11.5px] font-bold py-0.5 px-1.5 rounded-[6px] flex items-center gap-0.5 text-amber-700 bg-amber-100">
                        Butuh Review
                    </div>
                @endif
            </div>
            <div class="text-[26px] font-extrabold text-textCustom-900 tracking-tight font-mono">{{ number_format($stats['pending_projects']) }}</div>
            <div class="text-[12.5px] text-textCustom-600 font-medium mt-0.5">Project Menunggu Review</div>
        </div>

        {{-- Pending Users (Registrasi Mahasiswa Baru) --}}
        <div class="bg-panel border {{ $stats['pending_users'] > 0 ? 'border-purple-300 bg-purple-50/40' : 'border-slate-200' }} rounded-admin-md p-[20px_20px_18px_20px] shadow-admin-sm">
            <div class="flex items-start justify-between mb-3.5">
                <div class="w-[38px] h-[38px] rounded-[10px] flex items-center justify-center text-[15px] bg-purple-100 text-purple-600">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
            </div>
            <div class="text-[26px] font-extrabold text-textCustom-900 tracking-tight font-mono">{{ number_format($stats['pending_users']) }}</div>
            <div class="text-[12.5px] text-textCustom-600 font-medium mt-0.5">User Menunggu Approval</div>
        </div>
    </div>

    {{-- KONTEN UTAMA SPLIT COLUMN --}}
    <div class="grid grid-cols-1 xl:grid-cols-[1.65fr_1fr] gap-[18px] items-start">

        {{-- LEFT COLUMN: GRAFIK & DATA UTAMA --}}
        <div class="space-y-[18px]">
            {{-- Statistik Batang Terbuka (Statis/Semi-Dinamis dari Mockup) --}}
            <div class="bg-panel border border-slate-200 rounded-admin-md shadow-admin-sm">
                <div class="flex items-center justify-between border-b border-slate-100" style="padding: 18px 20px;">
                    <div>
                        <h2 class="text-[14.5px] font-bold text-textCustom-900">Submission Project</h2>
                        <div class="text-[12px] text-textCustom-400 font-medium mt-0.5">Tren aktivitas submission tahun {{ date('Y') }}</div>
                    </div>
                </div>
                <div class="p-5">
                    <div style="padding: 6px 4px 0 4px;">
                        <div class="flex items-end gap-3.5 h-[190px] px-1">
                            @foreach($stats['chart_data'] as $data)
                                <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end" title="Disetujui: {{ $data['approved'] }}, Pending: {{ $data['pending'] }}">
                                    <div class="w-full max-w-[34px] flex flex-col justify-end h-full rounded-md overflow-hidden bg-borderSoft">
                                        {{-- Bar Atas: Menunggu Review (Navy) --}}
                                        @if($data['pending_height'] > 0)
                                            <div class="bg-navy-700 transition-all duration-500" style="height: {{ $data['pending_height'] }}%;"></div>
                                        @endif

                                        {{-- Bar Bawah: Disetujui / Live (Teal) --}}
                                        @if($data['approved_height'] > 0)
                                            <div class="bg-teal-500 transition-all duration-500" style="height: {{ $data['approved_height'] }}%;"></div>
                                        @endif
                                    </div>
                                    <span class="text-[11px] text-textCustom-400 font-semibold">{{ $data['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex gap-[18px] border-t border-slate-100 text-xs font-medium text-textCustom-600" style="margin-top: 1rem; padding-top: 3.5px;">
                        <div class="flex items-center gap-[7px]"><span class="w-2 h-2 rounded-[2px] bg-teal-500"></span>Disetujui (Live)</div>
                        <div class="flex items-center gap-[7px]"><span class="w-2 h-2 rounded-[2px] bg-navy-700"></span>Menunggu Review</div>
                    </div>
                </div>
            </div>

            {{-- Tabel Project Terbaru --}}
            <div class="bg-panel border border-slate-200 rounded-admin-md shadow-admin-sm overflow-hidden">
                <div class="flex items-center justify-between p-[18px_20px] border-b border-slate-100">
                    <div>
                        <h2 class="text-[14.5px] font-bold text-textCustom-900">Project Terbaru (Disetujui)</h2>
                        <div class="text-[12px] text-textCustom-400 font-medium mt-0.5">Daftar submission terakhir yang aktif di sistem</div>
                    </div>
                    <a class="text-[12.5px] font-semibold text-teal-500 hover:text-teal-600 flex items-center gap-1" href="{{ route('admin.projects.index') }}">Lihat Semua<i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="text-left text-[11px] font-bold text-textCustom-400 uppercase tracking-wider border-b border-slate-200">
                                <th class="p-[0_20px_11px_20px]">Project</th>
                                <th class="p-[0_20px_11px_20px]">Program Studi</th>
                                <th class="p-[0_20px_11px_20px]">Status</th>
                                <th class="p-[0_20px_11px_20px]">Anggota Tim</th>
                                <th class="p-[0_20px_11px_20px]">Tanggal rilis</th>
                                <th class="p-[0_20px_11px_20px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($latestProjects as $project)
                                <tr class="hover:bg-surface transition-colors">
                                    <td class="p-[13px_20px] text-xs">
                                        <div class="flex items-center gap-[11px]">
                                            <img src="{{ $project->thumbnail_url ?: asset('images/default-thumbnail.png') }}" class="w-[38px] h-[38px] rounded-lg object-cover bg-teal-50" alt="Thumbnail">
                                            <div>
                                                <div class="font-semibold text-textCustom-900 text-sm truncate max-w-[180px]">{{ $project->title }}</div>
                                                <div class="text-[11.5px] text-textCustom-400">Oleh: {{ $project->team_name ?? 'Individual' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-[13px_20px]">
                                        <span class="inline-flex items-center font-bold px-2 py-0.5 rounded-full text-xs bg-blue-50 text-blue-600">
                                            {{ $project->program->slug ?? $project->program->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="p-[13px_20px]">
                                        <span class="inline-flex items-center gap-1 font-bold px-2 py-0.5 rounded-full text-xs bg-emerald-50 text-emerald-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>Live
                                        </span>
                                    </td>
                                    <td class="p-[13px_20px] font-mono font-medium text-textCustom-700">
                                        {{ $project->team_members_count ?? 0 }} Mhs
                                    </td>
                                    <td class="p-[13px_20px] font-mono text-textCustom-600">
                                        {{ $project->published_at ? $project->published_at->format('d M') : $project->created_at->format('d M') }}
                                    </td>
                                    <td class="p-[13px_20px]">
                                        <div class="flex items-center gap-1">
                                            <a href="{{ route('project.show', $project->slug) }}" target="_blank" class="w-[30px] h-[30px] rounded-md flex items-center justify-center text-textCustom-400 hover:bg-slate-200/50 hover:text-textCustom-900"><i class="fa-regular fa-eye"></i></a>
                                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="w-[30px] h-[30px] rounded-md flex items-center justify-center text-textCustom-400 hover:bg-slate-200/50 hover:text-textCustom-900"><i class="fa-regular fa-pen-to-square"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-xs text-textCustom-400">Belum ada project yang disetujui menduduki platform ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: ACTIONABLE QUEUES & AUDIT TRAIL LOGS --}}
        <div class="space-y-[18px]">

            {{-- Distribusi Ringkasan Data --}}
            <div class="bg-panel border border-slate-200 rounded-admin-md shadow-admin-sm">
                <div class="p-[18px_20px] border-b border-slate-100">
                    <h2 class="text-[14.5px] font-bold text-textCustom-900">Proporsi Showcase</h2>
                    <div class="text-[12px] text-textCustom-400 font-medium mt-0.5">Berdasarkan data operasional saat ini</div>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-[22px] p-1">
                        <div class="w-32 h-32 rounded-full shrink-0 relative" style="background: conic-gradient(#0EA5A8 0% 60%, #7C5CFC 60% 85%, #D97706 85% 100%);">
                            <div class="absolute inset-[18px] bg-white rounded-full"></div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center leading-tight">
                                <span class="text-[19px] font-extrabold text-textCustom-900 font-mono">{{ $stats['total_projects'] }}</span>
                                <span class="text-[10px] text-textCustom-400 font-bold tracking-wide">TOTAL</span>
                            </div>
                        </div>
                        <div class="flex-1 flex flex-col gap-[11px]">
                            <div class="flex items-center justify-between text-[12.5px]">
                                <span class="flex items-center gap-2 text-textCustom-600 font-medium"><span class="w-2 h-2 rounded-[2px] bg-teal-500"></span>Disetujui</span>
                                <span class="font-bold text-textCustom-900 font-mono">Live</span>
                            </div>
                            <div class="flex items-center justify-between text-[12.5px]">
                                <span class="flex items-center gap-2 text-textCustom-600 font-medium"><span class="w-2 h-2 rounded-[2px] bg-[#7C5CFC]"></span>Review</span>
                                <span class="font-bold text-amber-600 font-mono">{{ $stats['pending_projects'] }}</span>
                            </div>
                            <div class="flex items-center justify-between text-[12.5px]">
                                <span class="flex items-center gap-2 text-textCustom-600 font-medium"><span class="w-2 h-2 rounded-[2px] bg-amber-600"></span>Ditolak</span>
                                <span class="font-bold text-red-600 font-mono">{{ $stats['rejected_projects'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Antrean Review Project (Actionable Queue) --}}
            <div class="bg-panel border border-amber-200 rounded-admin-md shadow-admin-sm">
                <div class="p-[18px_20px] border-b border-amber-100 bg-amber-50/50">
                    <h2 class="text-[14.5px] font-bold text-amber-900">Menunggu Review Project</h2>
                    <div class="text-[12px] text-amber-700 font-medium mt-0.5">Perlu tindakan persetujuan secepatnya</div>
                </div>
                <div class="p-5 max-h-[320px] overflow-y-auto">
                    <div class="flex flex-col gap-3.5">
                        @forelse($pendingProjectList as $pProject)
                            <div class="flex items-center gap-3 border-b border-slate-100 pb-3 last:border-0 last:pb-0">
                                <div class="w-9 h-9 rounded-[9px] border border-slate-200 bg-surface flex items-center justify-center font-bold text-xs text-textCustom-600 shrink-0">
                                    {{ strtoupper(substr($pProject->title, 0, 2)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-[13px] font-semibold text-textCustom-900 truncate">{{ $pProject->title }}</div>
                                    <div class="text-[11.5px] text-textCustom-400 truncate">{{ $pProject->program->name ?? 'Prodi N/A' }} · {{ $pProject->created_at->diffForHumans() }}</div>
                                </div>
                                <a href="{{ route('admin.projects.index') }}" class="text-[11px] font-bold text-teal-600 bg-teal-50 border border-teal-200 p-[3px_8px] rounded-[7px] shrink-0 hover:bg-teal-100 transition-colors">
                                    Review
                                </a>
                            </div>
                        @empty
                            <p class="text-xs text-center text-textCustom-400 py-2">Bersih! Tidak ada project tertunda.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Antrean Approval User Registrasi --}}
            <div class="bg-panel border border-purple-200 rounded-admin-md shadow-admin-sm">
                <div class="p-[18px_20px] border-b border-purple-100 bg-purple-50/30">
                    <h2 class="text-[14.5px] font-bold text-purple-900">Persetujuan Akun Mahasiswa</h2>
                    <div class="text-[12px] text-purple-700 font-medium mt-0.5">Akses pendaftaran mahasiswa baru</div>
                </div>
                <div class="p-5">
                    <div class="flex flex-col gap-3.5">
                        @forelse($pendingUserList as $pUser)
                            <div class="flex items-center gap-3 border-b border-slate-100 pb-3 last:border-0 last:pb-0">
                                <div class="w-9 h-9 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($pUser->name, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-[13px] font-semibold text-textCustom-900 truncate">{{ $pUser->name }}</div>
                                    <div class="text-[11.5px] text-textCustom-400 truncate">{{ $pUser->email }}</div>
                                </div>
                                <a href="{{ route('admin.users.index') }}" class="text-[11px] font-bold text-purple-600 bg-purple-50 border border-purple-200 p-[3px_8px] rounded-[7px] shrink-0 hover:bg-purple-100 transition-colors">
                                    Kelola
                                </a>
                            </div>
                        @empty
                            <p class="text-xs text-center text-textCustom-400 py-2">Semua registrasi mahasiswa telah diverifikasi.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Audit Log / Aktivitas Yang Baru Saja Dilakukan Admin --}}
            <div class="bg-panel border border-slate-200 rounded-admin-md shadow-admin-sm overflow-hidden">
                <div class="p-[18px_20px] border-b border-slate-100 bg-slate-50/50">
                    <h2 class="text-[14.5px] font-bold text-textCustom-900">Jejak Aktivitas Anda</h2>
                    <div class="text-[12px] text-textCustom-400 font-medium mt-0.5">Aksi manipulasi data terakhir oleh Anda</div>
                </div>
                <div class="flex flex-col divide-y divide-slate-100 max-h-[290px] overflow-y-auto">
                    @forelse($recentActivities as $activity)
                        {{-- Blok ini jika Anda sudah me-render dari model Spatie Activity / Log manual --}}
                        <div class="flex gap-3 p-[13px_20px] hover:bg-slate-50/40 transition-colors">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-[12.5px] shrink-0 bg-teal-50 text-teal-600">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[13px] text-textCustom-900 static leading-relaxed">
                                    {!! $activity->description ?? 'Melakukan aktivitas sistem' !!}
                                </p>
                                <div class="text-[11.5px] text-textCustom-400 mt-0.5">{{ $activity->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @empty
                        {{-- Fallback UI jika log aktivitas masih kosong/belum diisi --}}
                        <div class="flex gap-3 p-[13px_20px]">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-[12.5px] shrink-0 bg-emerald-50 text-emerald-600"><i class="fa-solid fa-check"></i></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[13px] text-textCustom-900 leading-relaxed">Sistem siap memantau tindakan operasional (Approve/Reject) Anda.</p>
                                <div class="text-[11.5px] text-textCustom-400 mt-0.5">Realtime Active</div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
