<x-admin-layout>
    <x-slot:title>Kelola Project</x-slot:title>

    <div class="flex items-start justify-between mb-5">
        <div>
            <p class="text-textCustom-600 text-[13.5px] mt-0.5">Kelola seluruh project showcase mahasiswa — tambah, ubah, atau hapus data.</p>
        </div>
        <div class="flex gap-2.5">
            <button class="inline-flex items-center gap-2 py-[9.5px] px-4 rounded-[9px] text-[13.5px] font-semibold bg-white text-textCustom-900 border border-slate-200 hover:border-textCustom-400 whitespace-nowrap transition-colors">
                <i class="fa-solid fa-arrow-up-from-bracket text-[12.5px]"></i>Export CSV
            </button>
            <button class="inline-flex items-center gap-2 py-[9.5px] px-4 rounded-[9px] text-[13.5px] font-semibold bg-navy-900 text-white hover:bg-navy-800 whitespace-nowrap transition-colors" onclick="openFormModal('create')">
                <i class="fa-solid fa-plus text-[12.5px]"></i>Tambah Project
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-[18px] mb-5">
        <div class="bg-panel border border-slate-200 rounded-admin-md p-4 flex items-center gap-[13px] shadow-admin-sm">
            <div class="w-10 h-10 rounded-[10px] flex items-center justify-center text-[15px] shrink-0 bg-teal-100 text-teal-600">
                <i class="fa-solid fa-diagram-project"></i>
            </div>
            <div>
                <div class="text-[19px] font-extrabold text-textCustom-900 font-mono">128</div>
                <div class="text-[11.5px] text-textCustom-600 font-medium mt-0.5">Total Project</div>
            </div>
        </div>
        <div class="bg-panel border border-slate-200 rounded-admin-md p-4 flex items-center gap-[13px] shadow-admin-sm">
            <div class="w-10 h-10 rounded-[10px] flex items-center justify-center text-[15px] shrink-0 bg-teal-50 text-teal-600">
                <i class="fa-solid fa-satellite-dish"></i>
            </div>
            <div>
                <div class="text-[19px] font-extrabold text-textCustom-900 font-mono">46</div>
                <div class="text-[11.5px] text-textCustom-600 font-medium mt-0.5">Status Live</div>
            </div>
        </div>
        <div class="bg-panel border border-slate-200 rounded-admin-md p-4 flex items-center gap-[13px] shadow-admin-sm">
            <div class="w-10 h-10 rounded-[10px] flex items-center justify-center text-[15px] shrink-0 bg-amber-50 text-amber-600">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <div class="text-[19px] font-extrabold text-textCustom-900 font-mono">17</div>
                <div class="text-[11.5px] text-textCustom-600 font-medium mt-0.5">Menunggu Review</div>
            </div>
        </div>
        <div class="bg-panel border border-slate-200 rounded-admin-md p-4 flex items-center gap-[13px] shadow-admin-sm">
            <div class="w-10 h-10 rounded-[10px] flex items-center justify-center text-[15px] shrink-0 bg-borderSoft text-textCustom-600">
                <i class="fa-regular fa-file-lines"></i>
            </div>
            <div>
                <div class="text-[19px] font-extrabold text-textCustom-900 font-mono">9</div>
                <div class="text-[11.5px] text-textCustom-600 font-medium mt-0.5">Draft</div>
            </div>
        </div>
    </div>

    <div class="bg-panel border border-slate-200 rounded-admin-md shadow-admin-sm overflow-hidden">
        <div class="flex items-center justify-between p-[16px_20px] border-b border-slate-200 gap-4 flex-wrap">
            <div class="flex items-center gap-2.5 flex-wrap">
                <div class="flex items-center gap-2 bg-surface border border-slate-200 rounded-lg p-[8px_12px] w-[230px] text-textCustom-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input class="border-none bg-transparent outline-none p-0 focus:ring-0 text-[13px] text-textCustom-900 w-full placeholder-textCustom-400" type="text" placeholder="Cari nama project / tim...">
                </div>
                <button class="flex items-center gap-[7px] bg-white border border-slate-200 rounded-lg p-[8px_12px] text-[13px] font-medium text-textCustom-600 hover:bg-slate-50">
                    <i class="fa-solid fa-layer-group"></i>Semua Kategori<i class="fa-solid fa-chevron-down text-[10px] text-textCustom-400"></i>
                </button>
                <button class="flex items-center gap-[7px] bg-white border border-slate-200 rounded-lg p-[8px_12px] text-[13px] font-medium text-textCustom-600 hover:bg-slate-50">
                    <i class="fa-solid fa-circle-dot"></i>Semua Status<i class="fa-solid fa-chevron-down text-[10px] text-textCustom-400"></i>
                </button>
            </div>
            <div class="flex bg-surface border border-slate-200 rounded-lg p-0.5">
                <button class="py-1.5 px-3.5 text-[12.5px] font-semibold rounded-md bg-white text-navy-900 shadow-admin-sm">Tabel</button>
                <button class="py-1.5 px-3.5 text-[12.5px] font-semibold rounded-md text-textCustom-600">Grid</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-left text-[11px] font-bold text-textCustom-400 uppercase tracking-wider bg-surface border-b border-slate-200">
                        <th class="p-[13px_16px] pl-5 w-9"><input class="w-4 h-4 rounded text-navy-900 focus:ring-navy-900 cursor-pointer" type="checkbox"></th>
                        <th class="p-[13px_16px]">Project</th>
                        <th class="p-[13px_16px]">Tim</th>
                        <th class="p-[13px_16px]">Kategori</th>
                        <th class="p-[13px_16px]">Status</th>
                        <th class="p-[13px_16px]">Vote</th>
                        <th class="p-[13px_16px]">Dibuat</th>
                        <th class="p-[13px_16px] pr-5 w-[120px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    {{-- Row 1 --}}
                    <tr class="hover:bg-surface transition-colors">
                        <td class="p-3.5 px-[16px] pl-5"><input class="w-4 h-4 rounded text-navy-900 focus:ring-navy-900 cursor-pointer" type="checkbox"></td>
                        <td class="p-3.5 px-[16px]">
                            <div class="flex items-center gap-[11px]">
                                <div class="w-4 h-40 rounded-gamma bg-teal-50 text-teal-600 w-10 h-10 rounded-lg flex items-center justify-center text-sm shrink-0">
                                    <i class="fa-solid fa-seedling"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-textCustom-900 text-[13.3px]">AgriSmart IoT Analytics</div>
                                    <div class="text-[11.5px] text-textCustom-400 font-mono mt-0.5">PRJ-0128</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-3.5 px-[16px] text-textCustom-900 font-medium">Tim Alpha</td>
                        <td class="p-3.5 px-[16px]"><span class="inline-flex items-center font-bold px-2 py-0.5 rounded-full text-[11px] bg-blue-50 text-blue-600">SI</span></td>
                        <td class="p-3.5 px-[16px]"><span class="inline-flex items-center gap-1 font-bold px-2 py-0.5 rounded-full text-[11px] bg-emerald-50 text-emerald-600"><span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>Live</span></td>
                        <td class="p-3.5 px-[16px]"><div class="flex items-center gap-1.5 text-textCustom-600"><i class="fa-solid fa-heart text-red-600 text-[11.5px]"></i><span class="font-mono font-medium">482</span></div></td>
                        <td class="p-3.5 px-[16px] font-mono text-textCustom-600">18 Jun 2026</td>
                        <td class="p-3.5 px-[16px] pr-5">
                            <div class="flex items-center gap-1">
                                <button class="w-[31px] h-[31px] rounded-md flex items-center justify-center text-textCustom-400 hover:bg-white hover:text-textCustom-900 hover:shadow-admin-sm transition-all" title="Lihat"><i class="fa-regular fa-eye"></i></button>
                                <button class="w-[31px] h-[31px] rounded-md flex items-center justify-center text-textCustom-400 hover:bg-white hover:text-textCustom-900 hover:shadow-admin-sm transition-all" title="Ubah" onclick="openFormModal('edit')"><i class="fa-regular fa-pen-to-square"></i></button>
                                <button class="w-[31px] h-[31px] rounded-md flex items-center justify-center text-textCustom-400 hover:bg-white hover:text-red-600 hover:shadow-admin-sm transition-all" title="Hapus" onclick="openDeleteModal('AgriSmart IoT Analytics')"><i class="fa-regular fa-trash-can"></i></button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 2 --}}
                    <tr class="hover:bg-surface transition-colors">
                        <td class="p-3.5 px-[16px] pl-5"><input class="w-4 h-4 rounded text-navy-900 focus:ring-navy-900 cursor-pointer" type="checkbox"></td>
                        <td class="p-3.5 px-[16px]">
                            <div class="flex items-center gap-[11px]">
                                <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center text-sm shrink-0">
                                    <i class="fa-solid fa-chart-line"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-textCustom-900 text-[13.3px]">PoultryWatch Dashboard</div>
                                    <div class="text-[11.5px] text-textCustom-400 font-mono mt-0.5">PRJ-0127</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-3.5 px-[16px] text-textCustom-900 font-medium">Tim Beta</td>
                        <td class="p-3.5 px-[16px]"><span class="inline-flex items-center font-bold px-2 py-0.5 rounded-full text-[11px] bg-emerald-50 text-emerald-600">BD</span></td>
                        <td class="p-3.5 px-[16px]"><span class="inline-flex items-center font-bold px-2 py-0.5 rounded-full text-[11px] bg-amber-50 text-amber-600">Review</span></td>
                        <td class="p-3.5 px-[16px]"><div class="flex items-center gap-1.5 text-textCustom-600"><i class="fa-solid fa-heart text-red-600 text-[11.5px]"></i><span class="font-mono font-medium">214</span></div></td>
                        <td class="p-3.5 px-[16px] font-mono text-textCustom-600">17 Jun 2026</td>
                        <td class="p-3.5 px-[16px] pr-5">
                            <div class="flex items-center gap-1">
                                <button class="w-[31px] h-[31px] rounded-md flex items-center justify-center text-textCustom-400 hover:bg-white hover:text-textCustom-900 hover:shadow-admin-sm transition-all" title="Lihat"><i class="fa-regular fa-eye"></i></button>
                                <button class="w-[31px] h-[31px] rounded-md flex items-center justify-center text-textCustom-400 hover:bg-white hover:text-textCustom-900 hover:shadow-admin-sm transition-all" title="Ubah" onclick="openFormModal('edit')"><i class="fa-regular fa-pen-to-square"></i></button>
                                <button class="w-[31px] h-[31px] rounded-md flex items-center justify-center text-textCustom-400 hover:bg-white hover:text-red-600 hover:shadow-admin-sm transition-all" title="Hapus" onclick="openDeleteModal('PoultryWatch Dashboard')"><i class="fa-regular fa-trash-can"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between p-[14px_20px] border-t border-slate-200 flex-wrap gap-3">
            <div class="text-[12.5px] text-textCustom-600">Menampilkan <b>1–6</b> dari <b>128</b> project</div>
            <div class="flex items-center gap-[5px]">
                <button class="min-w-[32px] h-32 h-[32px] px-2 rounded-md flex items-center justify-center text-[12.5px] font-semibold text-textCustom-600 border border-slate-200 bg-white disabled:opacity-40 disabled:cursor-not-allowed" disabled>
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button class="min-w-[32px] h-[32px] px-2 rounded-md flex items-center justify-center text-[12.5px] font-semibold bg-navy-900 text-white border border-navy-900">1</button>
                <button class="min-w-[32px] h-[32px] px-2 rounded-md flex items-center justify-center text-[12.5px] font-semibold text-textCustom-600 border border-slate-200 bg-white hover:border-textCustom-400 hover:text-textCustom-900">2</button>
                <button class="min-w-[32px] h-[32px] px-2 rounded-md flex items-center justify-center text-[12.5px] font-semibold text-textCustom-600 border border-slate-200 bg-white hover:border-textCustom-400 hover:text-textCustom-900">3</button>
                <button class="min-w-[32px] h-[32px] px-2 rounded-md flex items-center justify-center text-[12.5px] font-semibold text-textCustom-600 border border-slate-200 bg-white disabled:cursor-not-allowed" disabled>…</button>
                <button class="min-w-[32px] h-[32px] px-2 rounded-md flex items-center justify-center text-[12.5px] font-semibold text-textCustom-600 border border-slate-200 bg-white hover:border-textCustom-400 hover:text-textCustom-900">22</button>
                <button class="min-w-[32px] h-[32px] px-2 rounded-md flex items-center justify-center text-[12.5px] font-semibold text-textCustom-600 border border-slate-200 bg-white hover:border-textCustom-400 hover:text-textCustom-900">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="fixed inset-0 bg-navy-950/55 backdrop-blur-[2px] hidden items-start justify-center p-[40px_20px] z-50 overflow-y-auto" id="formModalOverlay">
        <div class="bg-white rounded-admin-lg w-full max-w-[640px] shadow-[0_20px_50px_rgba(16,23,42,0.18),_0_4px_14px_rgba(16,23,42,0.08)] scale-99 opacity-0 transition-all duration-200 ease-out clean-modal-animate">
            <div class="flex items-center justify-between p-[20px_24px] border-b border-slate-200">
                <div>
                    <h3 class="text-[16px] font-bold text-textCustom-900" id="formModalTitle">Tambah Project Baru</h3>
                    <p class="text-[12.5px] text-textCustom-400 font-medium mt-0.5">Lengkapi detail project untuk ditampilkan di showcase</p>
                </div>
                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-textCustom-400 hover:bg-surface hover:text-textCustom-900 text-[14px]" onclick="closeFormModal()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="p-[22px_24px] max-h-[62vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-[12.5px] font-semibold text-textCustom-900 mb-1.5">Nama Project</label>
                        <input class="w-full p-[9.5px_12px] border border-slate-200 rounded-lg text-[13px] outline-none focus:border-teal-500 focus:ring-0 text-textCustom-900" type="text" placeholder="Contoh: AgriSmart IoT Analytics">
                    </div>

                    <div>
                        <label class="block text-[12.5px] font-semibold text-textCustom-900 mb-1.5">Tim</label>
                        <select class="w-full p-[9.5px_12px] pr-8 border border-slate-200 rounded-lg text-[13px] outline-none focus:border-teal-500 focus:ring-0 text-textCustom-900 bg-no-repeat bg-[right_12px_center]" style="appearance:none; background-image:url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'10\' height=\'6\'%3E%3Cpath d=\'M1 1l4 4 4-4\' stroke=\'%2394A0B4\' stroke-width=\'1.5\' fill=\'none\'/%3E%3C/svg%3E');">
                            <option>Tim Alpha</option>
                            <option>Tim Beta</option>
                            <option>Tim Gamma</option>
                            <option>Tim Delta</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[12.5px] font-semibold text-textCustom-900 mb-1.5">Kategori</label>
                        <select class="w-full p-[9.5px_12px] pr-8 border border-slate-200 rounded-lg text-[13px] outline-none focus:border-teal-500 focus:ring-0 text-textCustom-900 bg-no-repeat bg-[right_12px_center]" style="appearance:none; background-image:url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'10\' height=\'6\'%3E%3Cpath d=\'M1 1l4 4 4-4\' stroke=\'%2394A0B4\' stroke-width=\'1.5\' fill=\'none\'/%3E%3C/svg%3E');">
                            <option>Sistem Informasi (SI)</option>
                            <option>Rekayasa Perangkat Lunak (TRPL)</option>
                            <option>Big Data (BD)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[12.5px] font-semibold text-textCustom-900 mb-1.5">Dosen Pembimbing</label>
                        <input class="w-full p-[9.5px_12px] border border-slate-200 rounded-lg text-[13px] outline-none focus:border-teal-500 focus:ring-0 text-textCustom-900" type="text" placeholder="Nama dosen pembimbing">
                    </div>
                    <div>
                        <label class="block text-[12.5px] font-semibold text-textCustom-900 mb-1.5">Semester / Angkatan</label>
                        <input class="w-full p-[9.5px_12px] border border-slate-200 rounded-lg text-[13px] outline-none focus:border-teal-500 focus:ring-0 text-textCustom-900" type="text" placeholder="Contoh: Semester 6 — 2024">
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-[12.5px] font-semibold text-textCustom-900 mb-1.5">Deskripsi Project</label>
                        <textarea class="w-full p-[9.5px_12px] border border-slate-200 rounded-lg text-[13px] outline-none focus:border-teal-500 focus:ring-0 text-textCustom-900 min-h-[78px] resize-vertical" placeholder="Jelaskan fungsi dan tujuan project secara singkat..."></textarea>
                    </div>

                    <div>
                        <label class="block text-[12.5px] font-semibold text-textCustom-900 mb-1.5">Link Demo</label>
                        <input class="w-full p-[9.5px_12px] border border-slate-200 rounded-lg text-[13px] outline-none focus:border-teal-500 focus:ring-0 text-textCustom-900" type="url" placeholder="https://...">
                    </div>
                    <div>
                        <label class="block text-[12.5px] font-semibold text-textCustom-900 mb-1.5">Link Repository</label>
                        <input class="w-full p-[9.5px_12px] border border-slate-200 rounded-lg text-[13px] outline-none focus:border-teal-500 focus:ring-0 text-textCustom-900" type="url" placeholder="https://github.com/...">
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-[12.5px] font-semibold text-textCustom-900 mb-1.5">Thumbnail Project</label>
                        <div class="border-2 border-dashed border-slate-200 rounded-lg p-[22px] flex flex-col items-center justify-center gap-2 text-center text-textCustom-400 cursor-pointer hover:border-teal-500 hover:bg-teal-50/40 transition-all">
                            <i class="fa-regular fa-image text-[20px]"></i>
                            <span class="text-[13px] font-semibold text-textCustom-600">Klik untuk unggah, atau seret file ke sini</span>
                            <span class="text-[11.5px]">PNG atau JPG, maksimal 2MB, rasio 16:9 disarankan</span>
                        </div>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-[12.5px] font-semibold text-textCustom-900 mb-1.5">Status Publikasi</label>
                        <div class="flex gap-2 status-options">
                            <div class="status-opt flex-1 flex items-center justify-center gap-1.5 p-2.5 border border-slate-200 rounded-lg text-[12.5px] font-semibold text-textCustom-600 cursor-pointer transition-all border-emerald-600 bg-emerald-50 text-emerald-600 sel-live">
                                <i class="fa-solid fa-satellite-dish"></i>Live
                            </div>
                            <div class="status-opt flex-1 flex items-center justify-center gap-1.5 p-2.5 border border-slate-200 rounded-lg text-[12.5px] font-semibold text-textCustom-600 cursor-pointer transition-all">
                                <i class="fa-solid fa-hourglass-half"></i>Review
                            </div>
                            <div class="status-opt flex-1 flex items-center justify-center gap-1.5 p-2.5 border border-slate-200 rounded-lg text-[12.5px] font-semibold text-textCustom-600 cursor-pointer transition-all">
                                <i class="fa-regular fa-file-lines"></i>Draft
                            </div>
                        </div>
                        <div class="text-[11px] text-textCustom-400 font-medium mt-1.5">"Live" akan langsung tampil di halaman showcase publik.</div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-2.5 p-[16px_24px] border-t border-slate-200 bg-surface rounded-b-admin-lg">
                <button class="py-2 px-4 text-[13.5px] font-semibold text-textCustom-600 hover:bg-slate-200/40 rounded-lg transition-colors" onclick="closeFormModal()">Batal</button>
                <button class="inline-flex items-center gap-1.5 py-2 px-4 text-[13.5px] font-semibold bg-navy-900 text-white hover:bg-navy-800 rounded-lg transition-colors" onclick="closeFormModal()">
                    <i class="fa-solid fa-check"></i>Simpan Project
                </button>
            </div>
        </div>
    </div>

    <div class="fixed inset-0 bg-navy-950/55 backdrop-blur-[2px] hidden items-start justify-center p-[40px_20px] z-50 overflow-y-auto" id="deleteModalOverlay">
        <div class="bg-white rounded-admin-lg w-full max-w-[400px] shadow-[0_20px_50px_rgba(16,23,42,0.18),_0_4px_14px_rgba(16,23,42,0.08)] scale-99 opacity-0 transition-all duration-200 ease-out clean-modal-animate">
            <div class="p-6 pt-6">
                <div class="w-[52px] h-[52px] rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-[20px] mb-3.5">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="leading-relaxed">
                    <h3 class="text-[16px] font-bold text-textCustom-900 mb-1.5">Hapus project ini?</h3>
                    <p class="text-[13px] text-textCustom-600">Project <b class="text-textCustom-900 font-semibold" id="deleteProjectName">AgriSmart IoT Analytics</b> akan dihapus permanen beserta seluruh data vote dan galeri terkait. Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>
            <div class="flex items-center justify-end gap-2.5 p-[16px_24px] border-t border-slate-200 bg-surface rounded-b-admin-lg">
                <button class="py-2 px-4 text-[13.5px] font-semibold text-textCustom-600 hover:bg-slate-200/40 rounded-lg transition-colors" onclick="closeDeleteModal()">Batal</button>
                <button class="inline-flex items-center gap-1.5 py-2 px-4 text-[13.5px] font-semibold bg-red-600 text-white hover:bg-red-700 rounded-lg transition-colors" onclick="closeDeleteModal()">
                    <i class="fa-regular fa-trash-can"></i>Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <script>
        function openFormModal(mode) {
            const overlay = document.getElementById('formModalOverlay');
            const title = document.getElementById('formModalTitle');
            const innerContainer = overlay.firstElementChild;

            title.textContent = mode === 'edit' ? 'Ubah Project' : 'Tambah Project Baru';

            overlay.classList.replace('hidden', 'flex');
            setTimeout(() => {
                innerContainer.classList.remove('scale-99', 'opacity-0');
            }, 20);
        }

        function closeFormModal() {
            const overlay = document.getElementById('formModalOverlay');
            const innerContainer = overlay.firstElementChild;

            innerContainer.classList.add('scale-99', 'opacity-0');
            setTimeout(() => {
                overlay.classList.replace('flex', 'hidden');
            }, 180);
        }

        function openDeleteModal(name) {
            const overlay = document.getElementById('deleteModalOverlay');
            const targetText = document.getElementById('deleteProjectName');
            const innerContainer = overlay.firstElementChild;

            targetText.textContent = name;
            overlay.classList.replace('hidden', 'flex');
            setTimeout(() => {
                innerContainer.classList.remove('scale-99', 'opacity-0');
            }, 20);
        }

        function closeDeleteModal() {
            const overlay = document.getElementById('deleteModalOverlay');
            const innerContainer = overlay.firstElementChild;

            innerContainer.classList.add('scale-99', 'opacity-0');
            setTimeout(() => {
                overlay.classList.replace('flex', 'hidden');
            }, 180);
        }

        // Close on background overlay backdrop click
        document.querySelectorAll('[id$="ModalOverlay"]').forEach(ov => {
            ov.addEventListener('click', e => {
                if (e.target === ov) {
                    if (ov.id === 'formModalOverlay') closeFormModal();
                    if (ov.id === 'deleteModalOverlay') closeDeleteModal();
                }
            });
        });

        // Mock State Interaction for Status publication selection
        document.querySelectorAll('.status-opt').forEach(opt => {
            opt.addEventListener('click', () => {
                const parent = opt.parentNode;
                parent.querySelectorAll('.status-opt').forEach(o => {
                    o.className = "status-opt flex-1 flex items-center justify-center gap-1.5 p-2.5 border border-slate-200 rounded-lg text-[12.5px] font-semibold text-textCustom-600 cursor-pointer transition-all";
                });

                const idx = [...parent.children].indexOf(opt);
                if (idx === 0) opt.classList.add('border-emerald-600', 'bg-emerald-50', 'text-emerald-600', 'sel-live');
                if (idx === 1) opt.classList.add('border-amber-600', 'bg-amber-50', 'text-amber-600');
                if (idx === 2) opt.classList.add('border-slate-400', 'bg-slate-100', 'text-textCustom-600');
            });
        });
    </script>
</x-admin-layout>
