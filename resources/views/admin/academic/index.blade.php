<x-admin-layout title="Master Data Akademik">
    {{-- Container Utama dengan State Tab Aktif dan Data Riil --}}
    <div class="space-y-6" x-data="{
        currentTab: 'courses',
        openCreateModal: false,
        openEditModal: false,
        openDeleteModal: false,
        currentData: {},
        lecturer_ids: []
    }">

        {{-- FLASH MESSAGE SUCCESS --}}
        @if(session('success'))
            <div class="p-4 bg-teal-500/10 border border-teal-500/30 text-teal-600 rounded-xl text-sm font-medium flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-base"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        {{-- NAVIGATION TABS YANG ELEGAN --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex bg-slate-100 p-1 rounded-xl w-full sm:w-auto">
                <button type="button" @click="currentTab = 'courses'" :class="currentTab === 'courses' ? 'bg-white text-navy-900 shadow-sm' : 'text-textCustom-600 hover:text-navy-900'" class="flex-1 sm:flex-none py-2 px-4 text-xs font-semibold rounded-lg transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-book-bookmark"></i> Mata Kuliah
                </button>
                <button type="button" @click="currentTab = 'semesters'" :class="currentTab === 'semesters' ? 'bg-white text-navy-900 shadow-sm' : 'text-textCustom-600 hover:text-navy-900'" class="flex-1 sm:flex-none py-2 px-4 text-xs font-semibold rounded-lg transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-calendar-days"></i> Semester
                </button>
                <button type="button" @click="currentTab = 'classes'" :class="currentTab === 'classes' ? 'bg-white text-navy-900 shadow-sm' : 'text-textCustom-600 hover:text-navy-900'" class="flex-1 sm:flex-none py-2 px-4 text-xs font-semibold rounded-lg transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-chalkboard-user"></i> Kelas Kuliah
                </button>
            </div>

            {{-- TOMBOL TAMBAH DINAMIS MENGIKUTI TAB YANG AKTIF --}}
            <button type="button" @click="openCreateModal = true; lecturer_ids = []; currentData = {}" class="w-fit flex items-center justify-center gap-2 px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors shrink-0">
                <i class="fa-solid fa-plus text-[12px]"></i>
                <span x-text="currentTab === 'courses' ? 'Tambah MK' : (currentTab === 'semesters' ? 'Tambah Semester' : 'Buka Kelas')"></span>
            </button>
        </div>

        {{-- ================================================================== --}}
        {{-- KONTEN TAB 1: MATA KULIAH                                          --}}
        {{-- ================================================================== --}}
        <div x-show="currentTab === 'courses'" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden animate-in fade-in duration-150">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-textCustom-400 font-bold text-[11px] uppercase tracking-wider">
                            <th class="py-3.5 px-5 w-28">Kode MK</th>
                            <th class="py-3.5 px-5">Nama Mata Kuliah</th>
                            <th class="py-3.5 px-5">Program Studi</th>
                            <th class="py-3.5 px-5 text-center w-20">Bobot</th>
                            <th class="py-3.5 px-5 text-right w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-textCustom-900 font-medium">
                        @forelse($courses as $course)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-5 font-mono font-bold text-slate-600">{{ $course->code }}</td>
                                <td class="py-4 px-5">
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-slate-900 text-sm">{{ $course->name }}</span>
                                        <span class="text-textCustom-400 text-[11px] mt-0.5 max-w-xs truncate">{{ $course->description ?: 'Tidak ada deskripsi' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-slate-700">{{ $course->program->name ?? '-' }}</td>
                                <td class="py-4 px-5 text-center font-bold text-teal-600 bg-slate-50/40">{{ $course->sks }} SKS</td>
                                <td class="py-4 px-5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button" @click="currentData = {{ json_encode($course) }}; openEditModal = true" class="p-1.5 bg-slate-100 text-slate-600 border border-slate-200 rounded-md hover:bg-navy-900 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button type="button" @click="currentData = {{ json_encode($course) }}; openDeleteModal = true" class="p-1.5 bg-rose-500/10 text-rose-600 border border-rose-500/20 rounded-md hover:bg-rose-500 hover:text-white transition-all"><i class="fa-regular fa-trash-can"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-10 text-center text-textCustom-400">Belum ada data mata kuliah.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ================================================================== --}}
        {{-- KONTEN TAB 2: SEMESTER                                             --}}
        {{-- ================================================================== --}}
        <div x-show="currentTab === 'semesters'" style="display: none;" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden animate-in fade-in duration-150">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-textCustom-400 font-bold text-[11px] uppercase tracking-wider">
                            <th class="py-3.5 px-5">Nama Semester</th>
                            <th class="py-3.5 px-5">Tahun Akademik</th>
                            <th class="py-3.5 px-5">Sesi Term</th>
                            <th class="py-3.5 px-5 text-right w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-textCustom-900 font-medium">
                        @forelse($semesters as $sem)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-5 font-semibold text-sm text-slate-900">{{ $sem->name }}</td>
                                <td class="py-4 px-5 font-mono text-slate-700">{{ $sem->year }}/{{ $sem->year + 1 }}</td>
                                <td class="py-4 px-5"><span class="px-2 py-0.5 rounded text-[10px] font-bold border {{ $sem->term === 'Ganjil' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-purple-50 text-purple-600 border-purple-200' }}">{{ $sem->term }}</span></td>
                                {{-- <td class="py-4 px-5 text-center">
                                    @if($sem->is_active)
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-teal-500/10 text-teal-600 border border-teal-500/20">Aktif</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-400 border border-slate-200">Arsip</span>
                                    @endif
                                </td> --}}
                                <td class="py-4 px-5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button" @click="currentData = {{ json_encode($sem) }}; openEditModal = true" class="p-1.5 bg-slate-100 text-slate-600 border border-slate-200 rounded-md hover:bg-navy-900 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button type="button" @click="currentData = {{ json_encode($sem) }}; openDeleteModal = true" class="p-1.5 bg-rose-500/10 text-rose-600 border border-rose-500/20 rounded-md hover:bg-rose-500 hover:text-white transition-all"><i class="fa-regular fa-trash-can"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-10 text-center text-textCustom-400">Belum ada data semester.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ================================================================== --}}
        {{-- KONTEN TAB 3: KELAS KULIAH (MULTI-DOSEN SUPPORT)                   --}}
        {{-- ================================================================== --}}
        <div x-show="currentTab === 'classes'" style="display: none;" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden animate-in fade-in duration-150">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-textCustom-400 font-bold text-[11px] uppercase tracking-wider">
                            <th class="py-3.5 px-5 w-24">Kode Kelas</th>
                            <th class="py-3.5 px-5">Mata Kuliah / Prodi</th>
                            <th class="py-3.5 px-5">Semester</th>
                            <th class="py-3.5 px-5">Dosen Pengampu (Team Teaching)</th>
                            <th class="py-3.5 px-5 text-right w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-textCustom-900 font-medium">
                        @forelse($classes as $class)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-5 font-mono font-bold text-sm text-indigo-600 bg-slate-50/30">{{ $class->class_code }}</td>
                                <td class="py-4 px-5">
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-slate-900 text-sm">{{ $class->course?->name }}</span>
                                        <span class="text-textCustom-400 text-[11px] mt-0.5">{{ $class->course?->program?->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-slate-700 font-medium">{{ $class->semester?->name }}</td>
                                <td class="py-4 px-5">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($class->lecturers as $lecturer)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-slate-100 border border-slate-200 text-slate-700 font-medium text-[11px]">
                                                {{ $lecturer->name }}
                                            </span>
                                        @empty
                                            <span class="text-textCustom-400 italic text-[11px]">Belum diplot tim dosen</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button" @click="currentData = {{ json_encode($class) }}; lecturer_ids = {{ json_encode($class->lecturers->pluck('id')->toArray()) }}; openEditModal = true" class="p-1.5 bg-slate-100 text-slate-600 border border-slate-200 rounded-md hover:bg-navy-900 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button type="button" @click="currentData = {{ json_encode($class) }}; openDeleteModal = true" class="p-1.5 bg-rose-500/10 text-rose-600 border border-rose-500/20 rounded-md hover:bg-rose-500 hover:text-white transition-all"><i class="fa-regular fa-trash-can"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-10 text-center text-textCustom-400">Belum ada distribusi rombel kelas dibentuk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ================================================================== --}}
        {{-- MODAL GLOBAL CONTAINER: TAMBAH DATA (CREATE)                       --}}
        {{-- ================================================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-in fade-in duration-200" x-show="openCreateModal" style="display: none;">
            <div class="bg-white rounded-2xl border border-slate-200 w-full max-w-md overflow-hidden shadow-2xl transition-all" @click.away="openCreateModal = false">

                {{-- HEADER MODAL DENGAN INDIKATOR TAB KONTEKSTUAL --}}
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <div>
                        <h3 class="font-bold text-sm text-slate-900 uppercase tracking-wide">
                            Tambah <span x-text="currentTab === 'courses' ? 'Mata Kuliah' : (currentTab === 'semesters' ? 'Semester' : 'Kelas Kuliah')"></span> Baru
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">Lengkapi formulir di bawah ini dengan data yang valid.</p>
                    </div>
                    <button type="button" @click="openCreateModal = false" class="text-slate-400 hover:text-slate-600 p-1.5 hover:bg-slate-200/60 rounded-lg transition-colors">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                {{-- ================================================================== --}}
                {{-- 1. FORM CREATE: MATA KULIAH                                       --}}
                {{-- ================================================================== --}}
                <form method="POST" action="{{ route('admin.courses.store') }}" x-show="currentTab === 'courses'" class="p-5 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Program Studi <span class="text-rose-500">*</span></label>
                        <select name="program_id" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none bg-white focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                            <option value="" disabled selected>-- Pilih Program Studi --</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kode MK <span class="text-rose-500">*</span></label>
                            <input type="text" name="code" required placeholder="INF201" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs uppercase outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Mata Kuliah <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" required placeholder="Pemrograman Web Lanjut" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Bobot SKS <span class="text-rose-500">*</span></label>
                        <input type="number" name="sks" min="1" max="6" value="2" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                        <span class="text-[10px] text-slate-400 mt-1 block">Batas beban sks minimum 1 dan maksimum 6.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Mata Kuliah</label>
                        <textarea name="description" placeholder="Uraikan deskripsi singkat mengenai silabus atau capaian mata kuliah..." rows="3" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs resize-none outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                        <button type="button" @click="openCreateModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs shadow-sm transition-colors">Simpan MK</button>
                    </div>
                </form>

                {{-- ================================================================== --}}
                {{-- 2. FORM CREATE: SEMESTER                                          --}}
                {{-- ================================================================== --}}
                <form method="POST" action="{{ route('admin.semesters.store') }}" x-show="currentTab === 'semesters'" style="display: none;" class="p-5 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kalender Semester <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="Ganjil 2026/2027" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                        <span class="text-[10px] text-slate-400 mt-1 block">Format baku rekomendasi: [Ganjil/Genap] [Tahun Akademik]</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tahun Akademik <span class="text-rose-500">*</span></label>
                            <input type="number" name="year" value="{{ date('Y') }}" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Sesi Term <span class="text-rose-500">*</span></label>
                            <select name="term" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none bg-white focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Mulai Kuliah <span class="text-rose-500">*</span></label>
                            <input type="date" name="start_date" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Selesai <span class="text-rose-500">*</span></label>
                            <input type="date" name="end_date" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                        <button type="button" @click="openCreateModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs shadow-sm transition-colors">Simpan Semester</button>
                    </div>
                </form>

                {{-- ================================================================== --}}
                {{-- 3. FORM CREATE: KELAS KULIAH                                      --}}
                {{-- ================================================================== --}}
                <form method="POST" action="{{ route('admin.course-classes.store') }}" x-show="currentTab === 'classes'" style="display: none;" class="p-5 space-y-4">
                    @csrf

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mata Kuliah <span class="text-rose-500">*</span></label>
                            <select name="course_id" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none bg-white focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                                <option value="" disabled selected>-- Pilih MK --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kode Rombel Kelas <span class="text-rose-500">*</span></label>
                            <input type="text" name="class_code" required placeholder="TRPL 3A" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Periode Semester Berlaku <span class="text-rose-500">*</span></label>
                        <select name="semester_id" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none bg-white focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                            <option value="" disabled selected>-- Pilih Semester Aktif --</option>
                            @foreach($semesters as $semester)
                                <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Dosen Pengampu (Team Teaching)</label>
                            <span class="text-[10px] text-amber-600 bg-amber-50 px-2 py-0.5 rounded border border-amber-200 font-medium">Bisa pilih multi-dosen</span>
                        </div>
                        <div class="border border-slate-200 rounded-lg p-2.5 bg-slate-50/60 max-h-36 overflow-y-auto space-y-2 focus-within:border-teal-500 focus-within:ring-1 focus-within:ring-teal-500 transition-all">
                            @foreach($lecturers as $lecturer)
                                <label class="flex items-center gap-2.5 text-xs font-medium text-slate-700 cursor-pointer hover:bg-slate-200/40 p-1 rounded transition-colors select-none">
                                    <input type="checkbox" name="lecturer_ids[]" value="{{ $lecturer->id }}" class="rounded text-teal-500 focus:ring-0 cursor-pointer h-3.5 w-3.5 border-slate-300">
                                    <span>{{ $lecturer->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                        <button type="button" @click="openCreateModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs shadow-sm transition-colors">Buka Kelas</button>
                    </div>
                </form>

            </div>
        </div>

        {{-- ================================================================== --}}
        {{-- MODAL GLOBAL CONTAINER: UBAH DATA (EDIT)                           --}}
        {{-- ================================================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-in fade-in duration-200" x-show="openEditModal" style="display: none;">
            <div class="bg-white rounded-2xl border border-slate-200 w-full max-w-md overflow-hidden shadow-2xl transition-all" @click.away="openEditModal = false">

                {{-- HEADER MODAL DENGAN DETAIL KELAS KONTEKS --}}
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <div>
                        <h3 class="font-bold text-sm text-slate-900 uppercase tracking-wide">
                            Ubah Data <span x-text="currentTab === 'courses' ? 'Mata Kuliah' : (currentTab === 'semesters' ? 'Semester' : 'Kelas Kuliah')"></span>
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">Perbarui informasi pada field yang diperlukan di bawah ini.</p>
                    </div>
                    <button type="button" @click="openEditModal = false" class="text-slate-400 hover:text-slate-600 p-1.5 hover:bg-slate-200/60 rounded-lg transition-colors">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                {{-- ================================================================== --}}
                {{-- 1. FORM EDIT: MATA KULIAH                                         --}}
                {{-- ================================================================== --}}
                <form method="POST" :action="`{{ url('admin/courses') }}/${currentData.id}`" x-show="currentTab === 'courses'" class="p-5 space-y-4">
                    @csrf @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Program Studi <span class="text-rose-500">*</span></label>
                        <select name="program_id" x-model="currentData.program_id" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none bg-white focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Mata Kuliah <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="currentData.name" required placeholder="Masukkan nama mata kuliah" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kode MK <span class="text-rose-500">*</span></label>
                            <input type="text" name="code" x-model="currentData.code" required placeholder="KODE MK" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs uppercase outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Bobot SKS <span class="text-rose-500">*</span></label>
                            <input type="number" name="sks" x-model="currentData.sks" min="1" max="6" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Mata Kuliah</label>
                        <textarea name="description" x-model="currentData.description" placeholder="Deskripsi mata kuliah..." rows="3" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs resize-none outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                        <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs shadow-sm transition-colors">Simpan Perubahan</button>
                    </div>
                </form>

                {{-- ================================================================== --}}
                {{-- 2. FORM EDIT: SEMESTER                                            --}}
                {{-- ================================================================== --}}
                <form method="POST" :action="`{{ url('admin/semesters') }}/${currentData.id}`" x-show="currentTab === 'semesters'" style="display: none;" class="p-5 space-y-4"
                    x-init="$watch('currentData', value => {
                        if (value && value.start_date && value.start_date.includes(' ')) {
                            currentData.start_date = value.start_date.split(' ')[0];
                        }
                        if (value && value.end_date && value.end_date.includes(' ')) {
                            currentData.end_date = value.end_date.split(' ')[0];
                        }
                    })">
                    @csrf @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Semester <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="currentData.name" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tahun <span class="text-rose-500">*</span></label>
                            <input type="number" name="year" x-model="currentData.year" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Term <span class="text-rose-500">*</span></label>
                            <select name="term" x-model="currentData.term" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none bg-white focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Mulai <span class="text-rose-500">*</span></label>
                            <input type="date" name="start_date" x-model="currentData.start_date" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Selesai <span class="text-rose-500">*</span></label>
                            <input type="date" name="end_date" x-model="currentData.end_date" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                        <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs shadow-sm transition-colors">Simpan Perubahan</button>
                    </div>
                </form>

                {{-- ================================================================== --}}
                {{-- 3. FORM EDIT: KELAS KULIAH                                        --}}
                {{-- ================================================================== --}}
                <form method="POST" :action="`{{ url('admin/course-classes') }}/${currentData.id}`" x-show="currentTab === 'classes'" style="display: none;" class="p-5 space-y-4">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mata Kuliah <span class="text-rose-500">*</span></label>
                            <select name="course_id" x-model="currentData.course_id" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none bg-white focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kode Ruang Rombel <span class="text-rose-500">*</span></label>
                            <input type="text" name="class_code" x-model="currentData.class_code" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Periode Semester <span class="text-rose-500">*</span></label>
                        <select name="semester_id" x-model="currentData.semester_id" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none bg-white focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-shadow">
                            @foreach($semesters as $semester)
                                <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Dosen Pengampu (Team Teaching)</label>
                        </div>
                        <div class="border border-slate-200 rounded-lg p-2.5 bg-slate-50 max-h-36 overflow-y-auto space-y-2 focus-within:border-teal-500 focus-within:ring-1 focus-within:ring-teal-500 transition-all">
                            @foreach($lecturers as $lecturer)
                                <label class="flex items-center gap-2.5 text-xs font-medium text-slate-700 cursor-pointer hover:bg-slate-200/40 p-1 rounded transition-colors select-none">
                                    <input type="checkbox"
                                        name="lecturer_ids[]"
                                        value="{{ $lecturer->id }}"
                                        :checked="lecturer_ids.includes({{ $lecturer->id }}) || lecturer_ids.includes('{{ $lecturer->id }}')"
                                        @change="if($event.target.checked) { if(!lecturer_ids.includes($event.target.value)) lecturer_ids.push($event.target.value) } else { lecturer_ids = lecturer_ids.filter(id => id != $event.target.value) }"
                                        class="rounded text-teal-500 focus:ring-0 cursor-pointer h-3.5 w-3.5 border-slate-300">
                                    <span>{{ $lecturer->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                        <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg text-xs shadow-sm transition-colors">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================================================================== --}}
        {{-- MODAL GLOBAL CONTAINER: CONFIRM DELETE (SLIM - 320PX)              --}}
        {{-- ================================================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-in fade-in duration-200" x-show="openDeleteModal" style="display: none;">
            <div class="bg-white rounded-2xl border border-slate-200 max-w-[320px] overflow-hidden shadow-2xl mx-auto" @click.away="openDeleteModal = false">
                <div class="p-5 pb-4 text-center">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-sm border border-rose-100 shadow-sm mx-auto mb-3"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <h3 class="text-[14.5px] font-bold text-slate-900 tracking-tight">Hapus Data Master?</h3>
                    <p class="text-[11.5px] text-textCustom-600 mt-1">Data record <span class="font-semibold text-slate-900" x-text="currentData.name || currentData.class_code"></span> akan dihapus permanen dari sistem.</p>
                </div>
                <div class="flex items-center justify-end gap-2 p-[12px_20px] border-t border-slate-100 bg-slate-50">
                    <button type="button" @click="openDeleteModal = false" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 font-semibold rounded-lg text-[11px]">Batal</button>
                    <form method="POST" :action="`{{ url('admin') }}/${currentTab === 'courses' ? 'courses' : (currentTab === 'semesters' ? 'semesters' : 'course-classes')}/${currentData.id}`" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg text-[11px]">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
