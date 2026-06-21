<x-admin-layout>
    <x-slot:title>Kelola Project</x-slot:title>

    {{-- ALERT NOTIFIKASI --}}
    @if(session('success'))
        <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-500"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-start justify-between mb-5">
        <div>
            <p class="text-textCustom-600 text-[13.5px] mt-0.5">Kelola seluruh project showcase mahasiswa — tambah, ubah, atau hapus data serta kelola persetujuan.</p>
        </div>
        <div class="flex gap-2.5">
            {{-- <button class="inline-flex items-center gap-2 py-[9.5px] px-4 rounded-[9px] text-[13.5px] font-semibold bg-white text-textCustom-900 border border-slate-200 hover:border-textCustom-400 whitespace-nowrap transition-colors">
                <i class="fa-solid fa-arrow-up-from-bracket text-[12.5px]"></i>Export CSV
            </button> --}}
            <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-2 py-[9.5px] px-4 rounded-[9px] text-[13.5px] font-semibold bg-navy-900 text-white hover:bg-navy-800 whitespace-nowrap transition-colors shadow-sm outline-none">
                <i class="fa-solid fa-plus text-[12.5px]"></i> Tambah Project
            </a>
        </div>
    </div>

    {{-- GRID STATISTIK DINAMIS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-[18px] mb-5">
        <div class="bg-panel border border-slate-200 rounded-admin-md p-4 flex items-center gap-[13px] shadow-admin-sm">
            <div class="w-10 h-10 rounded-[10px] flex items-center justify-center text-[15px] shrink-0 bg-teal-100 text-teal-600">
                <i class="fa-solid fa-diagram-project"></i>
            </div>
            <div>
                <div class="text-[19px] font-extrabold text-textCustom-900 font-mono">{{ $projects->total() }}</div>
                <div class="text-[11.5px] text-textCustom-600 font-medium mt-0.5">Total Project</div>
            </div>
        </div>
        <div class="bg-panel border border-slate-200 rounded-admin-md p-4 flex items-center gap-[13px] shadow-admin-sm">
            <div class="w-10 h-10 rounded-[10px] flex items-center justify-center text-[15px] shrink-0 bg-emerald-50 text-emerald-600">
                <i class="fa-solid fa-satellite-dish"></i>
            </div>
            <div>
                <div class="text-[19px] font-extrabold text-textCustom-900 font-mono">{{ $projects->where('status', 'published')->count() }}</div>
                <div class="text-[11.5px] text-textCustom-600 font-medium mt-0.5">Status Live</div>
            </div>
        </div>
        <div class="bg-panel border border-slate-200 rounded-admin-md p-4 flex items-center gap-[13px] shadow-admin-sm">
            <div class="w-10 h-10 rounded-[10px] flex items-center justify-center text-[15px] shrink-0 bg-amber-50 text-amber-600">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <div class="text-[19px] font-extrabold text-textCustom-900 font-mono">{{ $projects->where('status', 'pending')->count() }}</div>
                <div class="text-[11.5px] text-textCustom-600 font-medium mt-0.5">Menunggu Review</div>
            </div>
        </div>
        <div class="bg-panel border border-slate-200 rounded-admin-md p-4 flex items-center gap-[13px] shadow-admin-sm">
            <div class="w-10 h-10 rounded-[10px] flex items-center justify-center text-[15px] shrink-0 bg-red-50 text-red-600">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div>
                <div class="text-[19px] font-extrabold text-textCustom-900 font-mono">{{ $projects->where('status', 'rejected')->count() }}</div>
                <div class="text-[11.5px] text-textCustom-600 font-medium mt-0.5">Ditolak</div>
            </div>
        </div>
    </div>

    {{-- FILTER DATA --}}
    <div class="bg-panel border border-slate-200 rounded-admin-md shadow-admin-sm overflow-hidden">
        <form method="GET" action="{{ route('admin.projects.index') }}" class="flex items-center justify-between p-[16px_20px] border-b border-slate-200 gap-4 flex-wrap">
            <div class="flex items-center gap-2.5 flex-wrap">
                <div class="flex items-center gap-2 bg-surface border border-slate-200 rounded-lg p-[8px_12px] w-[230px] text-textCustom-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input class="border-none bg-transparent outline-none p-0 focus:ring-0 text-[13px] text-textCustom-900 w-full placeholder-textCustom-400" type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama project / tim...">
                </div>

                <select name="status" onchange="this.form.submit()" class="bg-white border border-slate-200 rounded-lg p-[8px_12px] text-[13px] font-medium text-textCustom-600 outline-none focus:ring-0">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Live</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Review</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
        </form>

        {{-- TABEL WORKSPACE --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-left text-[11px] font-bold text-textCustom-400 uppercase tracking-wider bg-surface border-b border-slate-200">
                        <th class="p-[13px_16px] pl-5 w-9"><input class="w-4 h-4 rounded text-navy-900 focus:ring-navy-900 cursor-pointer" type="checkbox"></th>
                        <th class="p-[13px_16px]">Project</th>
                        <th class="p-[13px_16px]">Tim / Pembuat</th>
                        <th class="p-[13px_16px]">Kategori</th>
                        <th class="p-[13px_16px]">Status</th>
                        <th class="p-[13px_16px]">Views</th>
                        <th class="p-[13px_16px]">Dibuat</th>
                        <th class="p-[13px_16px] pr-5 text-right w-[200px]">Aksi & Alur Kerja</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($projects as $project)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="p-3.5 px-[16px] pl-5"><input class="w-4 h-4 rounded text-navy-900 focus:ring-navy-900 cursor-pointer" type="checkbox"></td>
                            <td class="p-3.5 px-[16px]">
                                <div class="flex items-center gap-[11px]">
                                    <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center text-sm shrink-0">
                                        <i class="fa-solid fa-folder-open"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-textCustom-900 text-[13.3px] max-w-[200px] truncate">{{ $project->title }}</div>
                                        <div class="text-[11.5px] text-textCustom-400 font-mono mt-0.5">{{ Str::upper(substr($project->id, 0, 8)) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3.5 px-[16px] text-textCustom-900 font-medium">
                                {{ $project->team_name ?? 'Individual' }}
                                <div class="text-xs text-textCustom-400 font-normal">Lead: {{ $project->teamLead->name ?? '-' }}</div>
                            </td>
                            <td class="p-3.5 px-[16px]">
                                <span class="inline-flex items-center font-bold px-2 py-0.5 rounded-full text-[11px] bg-blue-50 text-blue-600">
                                    {{ $project->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="p-3.5 px-[16px]">
                                @if($project->status === 'published')
                                    <span class="inline-flex items-center gap-1 font-bold px-2 py-0.5 rounded-full text-[11px] bg-emerald-50 text-emerald-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>Live
                                    </span>
                                @elseif($project->status === 'pending')
                                    <span class="inline-flex items-center gap-1 font-bold px-2 py-0.5 rounded-full text-[11px] bg-amber-50 text-amber-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>Review
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 font-bold px-2 py-0.5 rounded-full text-[11px] bg-rose-50 text-rose-600" title="Alasan: {{ $project->rejected_reason }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="p-3.5 px-[16px]">
                                <div class="flex items-center gap-1.5 text-textCustom-600">
                                    <i class="fa-regular fa-eye text-[11.5px]"></i>
                                    <span class="font-mono font-medium">{{ number_format($project->views_count) }}</span>
                                </div>
                            </td>
                            <td class="p-3.5 px-[16px] font-mono text-textCustom-600 text-xs">{{ $project->created_at->format('d M Y') }}</td>
                            <td class="p-3.5 px-[16px] pr-5">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- WORKFLOW APPROVAL ACTIONS --}}
                                    @if($project->status === 'pending')
                                        <form action="{{ route('admin.projects.approve', $project->id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="p-[4px_8px] rounded-md text-xs font-bold bg-emerald-600 text-white hover:bg-emerald-700 transition-all" title="Approve Project">
                                                <i class="fa-solid fa-check mr-1"></i>Approve
                                            </button>
                                        </form>
                                        <button type="button" onclick="openRejectModal('{{ $project->id }}', '{{ addslashes($project->title) }}')" class="p-[4px_8px] rounded-md text-xs font-bold bg-rose-100 text-rose-700 hover:bg-rose-200 transition-all" title="Reject Project">
                                            <i class="fa-solid fa-xmark mr-1"></i>Reject
                                        </button>
                                    @endif

                                    {{-- STANDARD CRUD ACTIONS --}}
                                    <a href="{{ route('admin.projects.show', $project->id) }}" class="w-[31px] h-[31px] rounded-md flex items-center justify-center text-textCustom-400 hover:bg-white hover:text-textCustom-900 hover:shadow-admin-sm transition-all" title="Lihat Detail"><i class="fa-regular fa-eye"></i></a>
                                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="w-[31px] h-[31px] rounded-md flex items-center justify-center text-textCustom-400 hover:bg-white hover:text-textCustom-900 hover:shadow-admin-sm transition-all" title="Ubah"><i class="fa-regular fa-pen-to-square"></i></a>

                                    <button type="button" class="w-[31px] h-[31px] rounded-md flex items-center justify-center text-textCustom-400 hover:bg-white hover:text-red-600 hover:shadow-admin-sm transition-all" title="Hapus" onclick="openDeleteModal('{{ $project->id }}', '{{ addslashes($project->title) }}')">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-xs text-textCustom-400">Tidak ada data project mahasiswa ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINASI LARAVEL TAILWIND --}}
        <div class="p-[14px_20px] border-t border-slate-200">
            {{ $projects->links() }}
        </div>
    </div>

    {{-- MODAL REJECT WORKFLOW --}}
    <div class="fixed inset-0 bg-navy-950/55 backdrop-blur-[2px] hidden items-start justify-center p-[40px_20px] z-50 overflow-y-auto" id="rejectModalOverlay">
        <div class="bg-white rounded-admin-lg w-full max-w-[450px] shadow-admin-lg scale-99 opacity-0 transition-all duration-200 ease-out">
            <form id="rejectForm" method="POST" action="">
                @csrf @method('PATCH')
                <div class="p-6">
                    <h3 class="text-[16px] font-bold text-textCustom-900 mb-2">Tolak Berkas Project</h3>
                    <p class="text-[13px] text-textCustom-600 mb-4">Berikan alasan penolakan untuk project: <b id="rejectProjectTitle" class="text-textCustom-900"></b></p>

                    <label class="block text-[12.5px] font-semibold text-textCustom-900 mb-1.5">Alasan Penolakan</label>
                    <textarea name="rejected_reason" required class="w-full p-3 border border-slate-200 rounded-lg text-[13px] outline-none focus:border-rose-500 text-textCustom-900 min-h-[100px]" placeholder="Contoh: Link repositori GitHub tidak valid atau di-private..."></textarea>
                </div>
                <div class="flex items-center justify-end gap-2.5 p-[16px_24px] border-t border-slate-200 bg-surface rounded-b-admin-lg">
                    <button type="button" class="py-2 px-4 text-[13.5px] font-semibold text-textCustom-600 hover:bg-slate-200/40 rounded-lg" onclick="closeRejectModal()">Batal</button>
                    <button type="submit" class="py-2 px-4 text-[13.5px] font-semibold bg-rose-600 text-white hover:bg-rose-700 rounded-lg">Kirim Penolakan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL DELETE RESOURCE --}}
    <div class="fixed inset-0 bg-navy-950/55 backdrop-blur-[2px] hidden items-start justify-center p-[40px_20px] z-50" id="deleteModalOverlay">
        <div class="bg-white rounded-admin-lg w-full max-w-[400px] shadow-admin-lg scale-99 opacity-0 transition-all duration-200 ease-out">
            <form id="deleteForm" method="POST" action="">
                @csrf @method('DELETE')
                <div class="p-6">
                    <div class="w-[52px] h-[52px] rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-[20px] mb-3.5">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <h3 class="text-[16px] font-bold text-textCustom-900 mb-1.5">Hapus project ini?</h3>
                        <p class="text-[13px] text-textCustom-600">Project <b class="text-textCustom-900 font-semibold" id="deleteProjectName"></b> akan dihapus dari sistem. Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-2.5 p-[16px_24px] border-t border-slate-200 bg-surface rounded-b-admin-lg">
                    <button type="button" class="py-2 px-4 text-[13.5px] font-semibold text-textCustom-600 hover:bg-slate-200/40 rounded-lg" onclick="closeDeleteModal()">Batal</button>
                    <button type="submit" class="py-2 px-4 text-[13.5px] font-semibold bg-red-600 text-white hover:bg-red-700 rounded-lg">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // LOGIKA INTERAKSI MODAL REJECT
        function openRejectModal(id, title) {
            const overlay = document.getElementById('rejectModalOverlay');
            const form = document.getElementById('rejectForm');
            const txtTitle = document.getElementById('rejectProjectTitle');

            // Atur URL Action dinamis menuju route admin.projects.reject
            form.action = `/admin/projects/${id}/reject`;
            txtTitle.textContent = title;

            overlay.classList.replace('hidden', 'flex');
            setTimeout(() => overlay.firstElementChild.classList.remove('scale-99', 'opacity-0'), 20);
        }

        function closeRejectModal() {
            const overlay = document.getElementById('rejectModalOverlay');
            overlay.firstElementChild.classList.add('scale-99', 'opacity-0');
            setTimeout(() => overlay.classList.replace('flex', 'hidden'), 180);
        }

        // LOGIKA INTERAKSI MODAL DELETE
        function openDeleteModal(id, name) {
            const overlay = document.getElementById('deleteModalOverlay');
            const form = document.getElementById('deleteForm');
            const targetText = document.getElementById('deleteProjectName');

            // Atur URL Action dinamis menuju route admin.projects.destroy
            form.action = `/admin/projects/${id}`;
            targetText.textContent = name;

            overlay.classList.replace('hidden', 'flex');
            setTimeout(() => overlay.firstElementChild.classList.remove('scale-99', 'opacity-0'), 20);
        }

        function closeDeleteModal() {
            const overlay = document.getElementById('deleteModalOverlay');
            overlay.firstElementChild.classList.add('scale-99', 'opacity-0');
            setTimeout(() => overlay.classList.replace('flex', 'hidden'), 180);
        }

        // Penutup otomatis saat klik backdrop luar modal
        document.querySelectorAll('[id$="ModalOverlay"]').forEach(ov => {
            ov.addEventListener('click', e => {
                if (e.target === ov) {
                    if (ov.id === 'rejectModalOverlay') closeRejectModal();
                    if (ov.id === 'deleteModalOverlay') closeDeleteModal();
                }
            });
        });
    </script>
</x-admin-layout>
