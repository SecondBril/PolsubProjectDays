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
                            <th class="py-3.5 px-5 text-center w-24">Status</th>
                            <th class="py-3.5 px-5 text-right w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-textCustom-900 font-medium">
                        @forelse($semesters as $sem)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-5 font-semibold text-sm text-slate-900">{{ $sem->name }}</td>
                                <td class="py-4 px-5 font-mono text-slate-700">{{ $sem->year }}/{{ $sem->year + 1 }}</td>
                                <td class="py-4 px-5"><span class="px-2 py-0.5 rounded text-[10px] font-bold border {{ $sem->term === 'Ganjil' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-purple-50 text-purple-600 border-purple-200' }}">{{ $sem->term }}</span></td>
                                <td class="py-4 px-5 text-center">
                                    @if($sem->is_active)
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-teal-500/10 text-teal-600 border border-teal-500/20">Aktif</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-400 border border-slate-200">Arsip</span>
                                    @endif
                                </td>
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
            <div class="bg-white rounded-2xl border border-slate-200 max-w-md overflow-hidden shadow-2xl" @click.away="openCreateModal = false">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-bold text-base text-slate-900 uppercase tracking-tight text-xs text-slate-500">
                        Form <span x-text="currentTab"></span> Baru
                    </h3>
                    <button type="button" @click="openCreateModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
                </div>

                {{-- SUB-FORM INDEPENDEN MATA KULIAH --}}
                <form method="POST" action="{{ route('admin.courses.store') }}" x-show="currentTab === 'courses'" class="p-5 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Program Studi</label>
                        <select name="program_id" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500">
                            @foreach($programs as $program) <option value="{{ $program->id }}">{{ $program->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <input type="text" name="code" required placeholder="KODE MK" class="col-span-1 border border-slate-200 rounded-lg px-3 py-2 text-xs uppercase">
                        <input type="text" name="name" required placeholder="Nama Mata Kuliah" class="col-span-2 border border-slate-200 rounded-lg px-3 py-2 text-xs">
                    </div>
                    <input type="number" name="sks" min="1" max="6" value="2" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs">
                    <textarea name="description" placeholder="Deskripsi mata kuliah..." rows="2" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs resize-none"></textarea>
                    <div class="flex justify-end gap-2 pt-2"><button type="submit" class="px-4 py-2 bg-teal-500 text-white font-semibold rounded-lg text-xs">Simpan MK</button></div>
                </form>

                {{-- SUB-FORM INDEPENDEN SEMESTER --}}
                <form method="POST" action="{{ route('admin.semesters.store') }}" x-show="currentTab === 'semesters'" style="display: none;" class="p-5 space-y-4">
                    @csrf
                    <input type="text" name="name" required placeholder="Nama Kalender (Contoh: Ganjil 2026/2027)" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs">
                    <div class="grid grid-cols-2 gap-3">
                        <input type="number" name="year" value="{{ date('Y') }}" required class="border border-slate-200 rounded-lg px-3 py-2 text-xs">
                        <select name="term" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs">
                            <option value="Ganjil">Ganjil</option><option value="Genap">Genap</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <input type="date" name="start_date" required class="border border-slate-200 rounded-lg px-3 py-2 text-xs">
                        <input type="date" name="end_date" required class="border border-slate-200 rounded-lg px-3 py-2 text-xs">
                    </div>
                    <div class="flex justify-end gap-2 pt-2"><button type="submit" class="px-4 py-2 bg-teal-500 text-white font-semibold rounded-lg text-xs">Simpan Semester</button></div>
                </form>

                {{-- SUB-FORM INDEPENDEN KELAS KULIAH --}}
                <form method="POST" action="{{ route('admin.course-classes.store') }}" x-show="currentTab === 'classes'" style="display: none;" class="p-5 space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <select name="course_id" required class="border border-slate-200 rounded-lg px-3 py-2 text-xs">
                            @foreach($courses as $course) <option value="{{ $course->id }}">{{ $course->name }}</option> @endforeach
                        </select>
                        <input type="text" name="class_code" required placeholder="Kode Rombel (TRPL 3A)" class="border border-slate-200 rounded-lg px-3 py-2 text-xs">
                    </div>
                    <select name="semester_id" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs">
                        @foreach($semesters as $semester) <option value="{{ $semester->id }}">{{ $semester->name }}</option> @endforeach
                    </select>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Dosen Pengampu (Team Teaching)</label>
                        <div class="border border-slate-200 rounded-lg p-2.5 bg-slate-50 max-h-32 overflow-y-auto space-y-1.5">
                            @foreach($lecturers as $lecturer)
                                <label class="flex items-center gap-2 text-xs font-medium text-slate-700 cursor-pointer"><input type="checkbox" name="lecturer_ids[]" value="{{ $lecturer->id }}" class="rounded text-teal-500 focus:ring-0"><span>{{ $lecturer->name }}</span></label>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2"><button type="submit" class="px-4 py-2 bg-teal-500 text-white font-semibold rounded-lg text-xs">Buka Kelas</button></div>
                </form>
            </div>
        </div>

        {{-- ================================================================== --}}
        {{-- MODAL GLOBAL CONTAINER: UBAH DATA (EDIT)                           --}}
        {{-- ================================================================== --}}
        <div class="fixed inset-0 bg-navy-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-in fade-in duration-200" x-show="openEditModal" style="display: none;">
            <div class="bg-white rounded-2xl border border-slate-200 max-w-md overflow-hidden shadow-2xl" @click.away="openEditModal = false">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-bold text-base text-slate-900 text-xs text-slate-500 uppercase">Ubah Data <span x-text="currentTab"></span></h3>
                    <button type="button" @click="openEditModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
                </div>

                {{-- FORM EDIT MATA KULIAH --}}
                <form method="POST" :action="`{{ url('admin/courses') }}/${currentData.id}`" x-show="currentTab === 'courses'" class="p-5 space-y-4">
                    @csrf @method('PUT')
                    <input type="text" name="name" :value="currentData.name" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs">
                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" name="code" :value="currentData.code" required class="border border-slate-200 rounded-lg px-3 py-2 text-xs uppercase">
                        <input type="number" name="sks" :value="currentData.sks" required class="border border-slate-200 rounded-lg px-3 py-2 text-xs">
                    </div>
                    <textarea name="description" :value="currentData.description" rows="2" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs resize-none"></textarea>
                    <button type="submit" class="w-full py-2 bg-teal-500 text-white font-bold rounded-lg text-xs">Simpan Perubahan</button>
                </form>

                {{-- FORM EDIT SEMESTER --}}
                <form method="POST" :action="`{{ url('admin/semesters') }}/${currentData.id}`" x-show="currentTab === 'semesters'" style="display: none;" class="p-5 space-y-4">
                    @csrf @method('PUT')
                    <input type="text" name="name" :value="currentData.name" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs">
                    <div class="grid grid-cols-2 gap-3">
                        <input type="number" name="year" :value="currentData.year" required class="border border-slate-200 rounded-lg px-3 py-2 text-xs">
                        <select name="term" x-model="currentData.term" class="border border-slate-200 rounded-lg px-3 py-2 text-xs"><option value="Ganjil">Ganjil</option><option value="Genap">Genap</option></select>
                    </div>
                    <button type="submit" class="w-full py-2 bg-teal-500 text-white font-bold rounded-lg text-xs">Simpan Perubahan</button>
                </form>

                {{-- FORM EDIT KELAS KULIAH --}}
                <form method="POST" :action="`{{ url('admin/course-classes') }}/${currentData.id}`" x-show="currentTab === 'classes'" style="display: none;" class="p-5 space-y-4">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Mata Kuliah</label>
                            <select name="course_id" :value="currentData.course_id" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500">
                                @foreach($courses as $course) <option value="{{ $course->id }}">{{ $course->name }}</option> @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Kode Ruang Rombel</label>
                            {{-- Menggunakan currentData.class_code agar sinkron dengan container utama --}}
                            <input type="text" name="class_code" :value="currentData.class_code" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Periode Semester</label>
                        <select name="semester_id" :value="currentData.semester_id" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-teal-500">
                            @foreach($semesters as $semester) <option value="{{ $semester->id }}">{{ $semester->name }}</option> @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Dosen Pengampu (Team Teaching)</label>
                        <div class="border border-slate-200 rounded-lg p-2.5 bg-slate-50 max-h-32 overflow-y-auto space-y-1.5">
                            @foreach($lecturers as $lecturer)
                                <label class="flex items-center gap-2 text-xs font-medium text-slate-700 cursor-pointer select-none">
                                    <input type="checkbox" name="lecturer_ids[]" value="{{ $lecturer->id }}" :checked="lecturer_ids.includes({{ $lecturer->id }})" class="rounded text-teal-500 focus:ring-0">
                                    <span>{{ $lecturer->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="w-full py-2 bg-teal-500 text-white font-bold rounded-lg text-xs shadow-sm hover:bg-teal-600 transition-colors">Simpan Perubahan</button>
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
