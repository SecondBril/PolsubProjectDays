<x-app-layout>
    <x-slot:title>Tentang Kami — POLS-HUB JTIK Showcase</x-slot:title>

    {{-- HERO SECTION --}}
    <section class="relative overflow-hidden bg-panel border-b border-borderSoft" style="padding-top: 7rem; padding-bottom: 6rem;">
        {{-- Background Grid Efek --}}
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#eef2f7_1px,transparent_1px),linear-gradient(to_bottom,#eef2f7_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-70 print:hidden"></div>

        <div class="relative mx-auto max-w-7xl text-center" style="padding-left: 1.5rem; padding-right: 1.5rem;">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-50 text-xs font-semibold tracking-wide text-navy-700 ring-1 ring-inset ring-navy-200 print:border print:border-slate-200" style="padding: 0.375rem 0.875rem;">
                <i class="fa-solid fa-rocket text-[10px]"></i> PANGGUNG KARYA DIGITAL
            </span>
            <h1 class="text-4xl font-extrabold tracking-tight text-textCustom-900 sm:text-5xl " style="margin-top: 2rem;">
                Etalase Inovasi & Kreativitas <br/>
                <span class="bg-gradient-to-r from-navy-700 via-navy-900 to-teal-600 bg-clip-text text-transparent print:text-navy-900">Mahasiswa POLS-HUB JTIK</span>
            </h1>
            <p class="mx-auto max-w-2xl text-lg leading-relaxed text-textCustom-600 print:text-sm" style="margin-top: 1.5rem;">
                JTIK Showcase menjembatani ide-ide brilian hasil
                <span class="font-bold">Project Based Learning (PBL)</span> mahasiswa agar dapat diakses, diuji, dan diapresiasi oleh industri maupun masyarakat luas.
            </p>
        </div>
    </section>

    {{-- LATAR BELAKANG & VISI --}}
    <section class="mx-auto max-w-7xl" style="padding: 6rem 1.5rem;">
        <div class="grid grid-cols-1 gap-16 lg:grid-cols-12 lg:items-center">
            <div class="lg:col-span-5">
                <span class="text-xs font-bold uppercase tracking-widest text-teal-600 block" style="margin-bottom: 1.5rem;">Eksplorasi Masalah</span>
                <h2 class="text-3xl font-bold tracking-tight text-textCustom-900 sm:text-4xl print:text-2xl" style="margin-bottom: 1.5rem;">Mengapa Platform Ini Dibangun?</h2>
                <div class="h-1 w-20 rounded bg-teal-500 print:bg-slate-400" style="margin-bottom: 1.5rem;"></div>
                <div class="text-base leading-relaxed text-textCustom-600 print:text-sm">
                    <p style="margin-bottom: 1rem;">
                        Banyak karya luar biasa dari luaran mata kuliah PBL mahasiswa berakhir tersimpan di penyimpanan lokal komputer tanpa pernah dilihat oleh publik luar.
                    </p>
                    <p class="font-medium text-textCustom-900">
                        Kami mengubah hal itu. JTIK Showcase memberikan ruang validasi nyata bagi portofolio digital mahasiswa.
                    </p>
                </div>
            </div>

            <div class="lg:col-span-7 grid grid-cols-1 gap-6 sm:grid-cols-2 print:gap-4" style="padding: 2rem 0rem;">
                <div class="card transition duration-300 hover:border-navy-200 print:shadow-none print:border-slate-300" style="padding: 1.5rem;">
                    <div class="flex h-12 w-12 items-center justify-center rounded-admin-md bg-navy-50 text-navy-600">
                        <i class="fa-solid fa-folder-tree text-lg"></i>
                    </div>
                    <h3 class="font-bold text-textCustom-900" style="margin-top: 1rem;">Repositori Terpusat</h3>
                    <p class="text-sm leading-relaxed text-textCustom-600" style="margin-top: 0.5rem;">Seluruh dokumentasi proyek terdokumentasi rapi dalam satu basis data resmi departemen.</p>
                </div>

                <div class="card transition duration-300 hover:border-teal-200 print:shadow-none print:border-slate-300" style="padding: 1.5rem;">
                    <div class="flex h-12 w-12 items-center justify-center rounded-admin-md bg-teal-50 text-teal-600">
                        <i class="fa-solid fa-share-nodes text-lg"></i>
                    </div>
                    <h3 class="font-bold text-textCustom-900" style="margin-top: 1rem;">Akses Terpublikasi</h3>
                    <p class="text-sm leading-relaxed text-textCustom-600" style="margin-top: 0.5rem;">Menghilangkan batasan ruang; karya dapat diakses rekruter kapan saja dan di mana saja.</p>
                </div>

                <div class="card transition duration-300 hover:border-navy-200 print:shadow-none print:border-slate-300" style="padding: 1.5rem;">
                    <div class="flex h-12 w-12 items-center justify-center rounded-admin-md bg-navy-50 text-navy-600">
                        <i class="fa-solid fa-id-card text-lg"></i>
                    </div>
                    <h3 class="font-bold text-textCustom-900" style="margin-top: 1rem;">Portofolio Digital</h3>
                    <p class="text-sm leading-relaxed text-textCustom-600" style="margin-top: 0.5rem;">Membantu mahasiswa membangun rekam jejak profesional sebelum kelulusan.</p>
                </div>

                <div class="card transition duration-300 hover:border-teal-200 print:shadow-none print:border-slate-300" style="padding: 1.5rem;">
                    <div class="flex h-12 w-12 items-center justify-center rounded-admin-md bg-teal-50 text-teal-600">
                        <i class="fa-solid fa-briefcase text-lg"></i>
                    </div>
                    <h3 class="font-bold text-textCustom-900" style="margin-top: 1rem;">Koneksi Industri</h3>
                    <p class="text-sm leading-relaxed text-textCustom-600" style="margin-top: 0.5rem;">Mempercepat proses *link and match* antara talenta kampus dengan kebutuhan industri.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- PROGRAM STUDI --}}
    <section class="bg-surface border-y border-borderSoft print:bg-white page-break-before" style="padding-top: 6rem; padding-bottom: 6rem;">
        <div class="mx-auto max-w-7xl" style="padding-left: 1.5rem; padding-right: 1.5rem;">
            <div class="text-center max-w-3xl mx-auto">
                <span class="text-xs font-bold uppercase tracking-widest text-teal-600 block">Pilar Akademik</span>
                <h2 class="text-3xl font-bold tracking-tight text-textCustom-900 sm:text-4xl print:text-2xl" style="margin-top: 0.75rem;">3 Program Studi di POLS-HUB JTIK</h2>
                <p class="text-base text-textCustom-600 print:text-sm" style="margin-top: 1rem;">Kolaborasi lintas disiplin ilmu komputer dan bisnis melahirkan produk digital yang solutif.</p>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-3 print:gap-4" style="margin-top: 4rem;">
                {{-- SI --}}
                <div class="flex flex-col justify-between rounded-admin-lg border border-borderSoft bg-panel shadow-card print:shadow-none print:border-slate-300" style="padding: 2rem;">
                    <div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-admin-md bg-navy-50 text-navy-600">
                            <i class="fa-solid fa-diagram-project text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-textCustom-900" style="margin-top: 1.5rem;">Sistem Informasi (SI)</h3>
                        <p class="text-sm leading-relaxed text-textCustom-600" style="margin-top: 1rem;">
                            Menjembatani kebutuhan bisnis dengan teknologi melalui analisis data, perancangan arsitektur sistem, dan manajemen UI/UX yang optimal.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-1.5 border-t border-borderSoft" style="margin-top: 2rem; padding-top: 1rem;">
                        <span class="inline-flex items-center rounded bg-surface text-xs font-medium text-textCustom-600 ring-1 ring-inset ring-textCustom-400/10" style="padding: 0.125rem 0.5rem;">Enterprise</span>
                        <span class="inline-flex items-center rounded bg-surface text-xs font-medium text-textCustom-600 ring-1 ring-inset ring-textCustom-400/10" style="padding: 0.125rem 0.5rem;">UI/UX</span>
                    </div>
                </div>

                {{-- TRPL --}}
                <div class="flex flex-col justify-between rounded-admin-lg border border-borderSoft bg-panel shadow-card print:shadow-none print:border-slate-300" style="padding: 2rem;">
                    <div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-admin-md bg-teal-50 text-teal-600">
                            <i class="fa-solid fa-code text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-textCustom-900" style="margin-top: 1.5rem;">Teknologi Rekayasa Perangkat Lunak (TRPL)</h3>
                        <p class="text-sm leading-relaxed text-textCustom-600" style="margin-top: 1rem;">
                            Fokus penuh pada konstruksi kode program, arsitektur backend/frontend tangguh, pengembangan aplikasi mobile, hingga integrasi hardware IoT.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-1.5 border-t border-borderSoft" style="margin-top: 2rem; padding-top: 1rem;">
                        <span class="inline-flex items-center rounded bg-surface text-xs font-medium text-textCustom-600 ring-1 ring-inset ring-textCustom-400/10" style="padding: 0.125rem 0.5rem;">Fullstack</span>
                        <span class="inline-flex items-center rounded bg-surface text-xs font-medium text-textCustom-600 ring-1 ring-inset ring-textCustom-400/10" style="padding: 0.125rem 0.5rem;">IoT</span>
                    </div>
                </div>

                {{-- BD --}}
                <div class="flex flex-col justify-between rounded-admin-lg border border-borderSoft bg-panel shadow-card print:shadow-none print:border-slate-300" style="padding: 2rem;">
                    <div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-admin-md bg-navy-50 text-navy-600">
                            <i class="fa-solid fa-chart-line text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-textCustom-900" style="margin-top: 1.5rem;">Bisnis Digital (BD)</h3>
                        <p class="text-sm leading-relaxed text-textCustom-600" style="margin-top: 1rem;">
                            Pusat inovasi strategi monetisasi digital, optimalisasi marketing modern, manajemen e-commerce, hingga validasi skalabilitas model bisnis.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-1.5 border-t border-borderSoft" style="margin-top: 2rem; padding-top: 1rem;">
                        <span class="inline-flex items-center rounded bg-surface text-xs font-medium text-textCustom-600 ring-1 ring-inset ring-textCustom-400/10" style="padding: 0.125rem 0.5rem;">Marketing</span>
                        <span class="inline-flex items-center rounded bg-surface text-xs font-medium text-textCustom-600 ring-1 ring-inset ring-textCustom-400/10" style="padding: 0.125rem 0.5rem;">Startup</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FITUR UNGGULAN --}}
    <section class="mx-auto max-w-7xl" style="padding: 6rem 1.5rem;">
        <div class="max-w-3xl">
            <span class="text-xs font-bold uppercase tracking-widest text-teal-600 block">Kecanggihan Sistem</span>
            <h2 class="text-3xl font-bold tracking-tight text-textCustom-900 sm:text-4xl print:text-2xl" style="margin-top: 0.75rem;">Teknologi yang Mendukung Eksplorasi Anda</h2>
        </div>

        <div class="grid grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:grid-cols-3 print:gap-8" style="margin-top: 4rem;">
            <div class="flex gap-4 mb-4 items-start">
                <div class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-navy-50 text-navy-600">
                    <i class="fa-solid fa-window-restore"></i>
                </div>
                <div>
                    <h3 class="font-bold text-textCustom-900">Live Demo Terintegrasi</h3>
                    <p class="text-sm leading-relaxed text-textCustom-600" style="margin-top: 0.5rem;">Uji fungsionalitas aplikasi web mahasiswa langsung melalui sandboxed iframe tanpa instalasi rumit.</p>
                </div>
            </div>

            <div class="flex gap-4 mb-4 items-start">
                <div class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-teal-50 text-teal-600">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div>
                    <h3 class="font-bold text-textCustom-900">Filter Multi-Dimensi</h3>
                    <p class="text-sm leading-relaxed text-textCustom-600" style="margin-top: 0.5rem;">Pencarian instan berdasar kategori teknologi, angkatan mahasiswa, dosen pembimbing, maupun rumpun prodi.</p>
                </div>
            </div>

            <div class="flex gap-4 mb-4 items-start">
                <div class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-navy-50 text-navy-600">
                    <i class="fa-solid fa-users-rectangle"></i>
                </div>
                <div>
                    <h3 class="font-bold text-textCustom-900">Profil Tim Komprehensif</h3>
                    <p class="text-sm leading-relaxed text-textCustom-600" style="margin-top: 0.5rem;">Transparansi kepemilikan proyek, memuat kontribusi masing-masing anggota tim pengembang secara detail.</p>
                </div>
            </div>

            <div class="flex gap-4 items-start">
                <div class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-teal-50 text-teal-600">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <h3 class="font-bold text-textCustom-900">Analitik Pengunjung</h3>
                    <p class="text-sm leading-relaxed text-textCustom-600" style="margin-top: 0.5rem;">Menyediakan metrik kunjungan dan interaksi nyata untuk mengukur tingkat popularitas suatu ide proyek.</p>
                </div>
            </div>

            <div class="flex gap-4 items-start">
                <div class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-navy-50 text-navy-600">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h3 class="font-bold text-textCustom-900">Kurasi Keamanan Ketat</h3>
                    <p class="text-sm leading-relaxed text-textCustom-600" style="margin-top: 0.5rem;">Setiap aset digital melewati lapisan pengecekan administratif demi menjaga integritas platform dari berkas berbahaya.</p>
                </div>
            </div>

            <div class="flex gap-4 items-start">
                <div class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-teal-50 text-teal-600">
                    <i class="fa-solid fa-bolt"></i>
                </div>
                <div>
                    <h3 class="font-bold text-textCustom-900">Performa Kecepatan Tinggi</h3>
                    <p class="text-sm leading-relaxed text-textCustom-600" style="margin-top: 0.5rem;">Dioptimalkan secara penuh dengan penanganan caching pintar guna performa rendering antarmuka secepat kilat.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- TARGET PENGGUNA --}}
    <section class="bg-navy-900 text-white print:bg-white print:text-textCustom-900 page-break-before" style="padding-top: 6rem; padding-bottom: 6rem;">
        <div class="mx-auto max-w-7xl" style="padding-left: 1.5rem; padding-right: 1.5rem;">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-flex items-center rounded-full bg-white/10 text-xs font-semibold uppercase tracking-wider text-teal-300 print:bg-slate-100 print:text-slate-700" style="padding: 0.25rem 0.75rem;">
                    Target Pengguna
                </span>
                <h2 class="text-3xl font-bold tracking-tight sm:text-4xl print:text-2xl" style="margin-top: 1rem;">Platform Kolaboratif Lintas Peran</h2>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 print:gap-4" style="margin-top: 4rem;">
                <div class="rounded-admin-lg bg-white/[0.03] ring-1 ring-white/10 print:ring-1 print:ring-slate-200 print:bg-slate-50" style="padding: 1.5rem;">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy-500/20 text-navy-300 print:bg-blue-100 print:text-blue-600">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <h3 class="font-semibold text-white print:text-textCustom-900" style="margin-top: 1rem;">Mahasiswa</h3>
                    <p class="text-sm leading-relaxed text-navy-200 print:text-slate-600" style="margin-top: 0.5rem;">Ruang unjuk gigi hasil validasi PBL guna memikat para rekruter di industri.</p>
                </div>

                <div class="rounded-admin-lg bg-white/[0.03] ring-1 ring-white/10 print:ring-1 print:ring-slate-200 print:bg-slate-50" style="padding: 1.5rem;">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-teal-500/20 text-teal-300 print:bg-green-100 print:text-green-600">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                    <h3 class="font-semibold text-white print:text-textCustom-900" style="margin-top: 1rem;">Dosen & Jurusan</h3>
                    <p class="text-sm leading-relaxed text-navy-200 print:text-slate-600" style="margin-top: 0.5rem;">Alat pantau terpadu dalam memonitor perkembangan kualitas standar pembelajaran produk.</p>
                </div>

                <div class="rounded-admin-lg bg-white/[0.03] ring-1 ring-white/10 print:ring-1 print:ring-slate-200 print:bg-slate-50" style="padding: 1.5rem;">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy-500/20 text-navy-300 print:bg-purple-100 print:text-purple-600">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <h3 class="font-semibold text-white print:text-textCustom-900" style="margin-top: 1rem;">Mitra Industri</h3>
                    <p class="text-sm leading-relaxed text-navy-200 print:text-slate-600" style="margin-top: 0.5rem;">Pintu gerbang efisien dalam melacak dan merekrut talenta teknologi potensial kampus.</p>
                </div>

                <div class="rounded-admin-lg bg-white/[0.03] ring-1 ring-white/10 print:ring-1 print:ring-slate-200 print:bg-slate-50" style="padding: 1.5rem;">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-teal-500/20 text-teal-300 print:bg-yellow-100 print:text-yellow-600">
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <h3 class="font-semibold text-white print:text-textCustom-900" style="margin-top: 1rem;">Masyarakat Umum</h3>
                    <p class="text-sm leading-relaxed text-navy-200 print:text-slate-600" style="margin-top: 0.5rem;">Melihat sejauh mana pemanfaatan praktis teknologi dikembangkan demi kemaslahatan publik.</p>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
