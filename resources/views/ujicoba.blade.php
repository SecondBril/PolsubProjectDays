<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Preview — JTIK POLSUB Showcase</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          navy: {
            50:'#EEF2F7',100:'#D9E2EC',200:'#B9C8DA',300:'#90A8C2',400:'#5B7A9E',
            500:'#3C5C80',600:'#2C4A6E',700:'#203A57',800:'#172A43',900:'#101D30',
          },
        },
      },
    },
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  body{font-family:'Inter',ui-sans-serif,system-ui,sans-serif;}
  [x-cloak]{display:none!important;}
  .btn-primary{display:inline-flex;align-items:center;justify-content:center;gap:.5rem;border-radius:.5rem;background:#172A43;padding:.625rem 1.25rem;font-size:.875rem;font-weight:600;color:#fff;transition:.15s;}
  .btn-primary:hover{background:#203A57;}
  .btn-outline{display:inline-flex;align-items:center;justify-content:center;gap:.5rem;border-radius:.5rem;border:1px solid #cbd5e1;background:#fff;padding:.625rem 1.25rem;font-size:.875rem;font-weight:600;color:#334155;transition:.15s;}
  .btn-outline:hover{background:#f8fafc;}
  .badge{display:inline-flex;align-items:center;gap:.25rem;border-radius:9999px;padding:.25rem .65rem;font-size:.75rem;font-weight:600;}
  .card{border-radius:.75rem;border:1px solid #e2e8f0;background:#fff;box-shadow:0 1px 2px 0 rgb(16 29 48 / .04);}
</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

<!-- banner to explain this is a flattened preview -->
<div class="bg-amber-50 px-6 py-2 text-center text-xs font-medium text-amber-700 border-b border-amber-200">
  Preview statis (Tailwind/Alpine via CDN) — halaman Home lalu Project Detail ditumpuk pada satu file untuk pratinjau cepat.
</div>

<!-- ============================================================ -->
<!-- NAVBAR -->
<!-- ============================================================ -->
<header x-data="{ mobileOpen: false }" class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur">
  <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
    <a href="#home" class="text-lg font-extrabold tracking-tight text-navy-900">JTIK POLSUB</a>
    <nav class="hidden items-center gap-8 text-sm font-medium text-slate-600 md:flex">
      <a href="#home" class="relative pb-1 font-semibold text-navy-800">Home<span class="absolute -bottom-[1px] left-0 h-0.5 w-full rounded-full bg-navy-800"></span></a>
      <a href="#" class="hover:text-navy-800">Projects</a>
      <a href="#" class="hover:text-navy-800">Leaderboard</a>
      <a href="#" class="hover:text-navy-800">About</a>
    </nav>
    <div class="hidden items-center gap-3 md:flex">
      <button class="text-sm font-semibold text-slate-600 hover:text-navy-800">Sign In</button>
      <button class="btn-primary">Submit Project</button>
    </div>
    <button @click="mobileOpen = !mobileOpen" class="text-slate-700 md:hidden">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>
  </div>
  <div x-show="mobileOpen" x-cloak x-transition class="space-y-3 border-t border-slate-200 bg-white px-6 py-4 md:hidden">
    <a href="#home" class="block py-1 font-semibold text-navy-800">Home</a>
    <a href="#" class="block py-1 text-slate-600">Projects</a>
    <a href="#" class="block py-1 text-slate-600">Leaderboard</a>
    <a href="#" class="block py-1 text-slate-600">About</a>
  </div>
</header>

<main id="home">

<!-- ============================================================ -->
<!-- HERO -->
<!-- ============================================================ -->
<section class="overflow-hidden bg-gradient-to-b from-slate-50 to-white">
  <div class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-12 px-6 py-16 lg:grid-cols-2 lg:py-20">
    <div>
      <span class="badge bg-blue-50 text-blue-700">SHOWCASE PLATFORM</span>
      <h1 class="mt-5 text-4xl font-extrabold leading-tight text-navy-900 sm:text-5xl">Karya Terbaik Mahasiswa JTIK POLSUB</h1>
      <p class="mt-5 max-w-md text-base leading-relaxed text-slate-500">Platform apresiasi dan showcase hasil Project Based Learning (PBL) mahasiswa Jurusan Teknik Informatika dan Komputer Politeknik Negeri Subang.</p>
      <div class="mt-8 flex flex-wrap gap-3">
        <button class="btn-primary">Jelajahi Project
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
        </button>
        <button class="btn-outline">Lihat Demo</button>
      </div>
    </div>
    <div class="relative mx-auto w-full max-w-lg">
      <span class="absolute -top-3 right-6 z-10 inline-flex items-center gap-1.5 rounded-full bg-red-500 px-3 py-1 text-xs font-bold text-white shadow-lg shadow-red-500/30"><span class="h-1.5 w-1.5 rounded-full bg-white"></span> LIVE</span>
      <div class="rounded-2xl bg-white p-3 shadow-2xl ring-1 ring-slate-200">
        <img src="public/images/hero-mockup.svg" alt="Dashboard preview" class="w-full rounded-xl">
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ -->
<!-- STATS -->
<!-- ============================================================ -->
<section class="mx-auto max-w-7xl px-6 pb-4">
  <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
    <div class="card flex items-center gap-3 px-4 py-4">
      <span class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-indigo-50 text-indigo-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg></span>
      <div><p class="text-xs text-slate-500">Total Project</p><p class="text-xl font-bold text-navy-900">120+</p></div>
    </div>
    <div class="card flex items-center gap-3 px-4 py-4">
      <span class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-indigo-50 text-indigo-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14v6m-7-9.5V16a7 3 0 0014 0v-5.5"/></svg></span>
      <div><p class="text-xs text-slate-500">Prodi Aktif</p><p class="text-xl font-bold text-navy-900">3</p></div>
    </div>
    <div class="card flex items-center gap-3 px-4 py-4">
      <span class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-indigo-50 text-indigo-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.5-2.5v9L15 14M4 7h9a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V9a2 2 0 012-2z"/></svg></span>
      <div><p class="text-xs text-slate-500">Live Demo</p><p class="text-xl font-bold text-navy-900">45</p></div>
    </div>
    <div class="card flex items-center gap-3 px-4 py-4">
      <span class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-indigo-50 text-indigo-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-1a4 4 0 00-4-4h-1m-9 5H3v-1a4 4 0 014-4h1m4-3a3 3 0 100-6 3 3 0 000 6zm6 2a3 3 0 10-2-5.2"/></svg></span>
      <div><p class="text-xs text-slate-500">Total Tim</p><p class="text-xl font-bold text-navy-900">82</p></div>
    </div>
  </div>
</section>

<!-- ============================================================ -->
<!-- PROJECT UNGGULAN -->
<!-- ============================================================ -->
<section class="mx-auto max-w-7xl px-6 py-14">
  <div class="flex flex-wrap items-end justify-between gap-3">
    <div><h2 class="text-2xl font-bold text-navy-900">Project Unggulan</h2><p class="mt-1 text-sm text-slate-500">Karya paling inovatif pilihan dosen dan industri.</p></div>
    <a href="#" class="inline-flex items-center gap-1 text-sm font-semibold text-navy-700 hover:text-navy-900">Lihat Semua
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
    </a>
  </div>

  <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-3">

    <article class="card overflow-hidden hover:shadow-lg transition">
      <div class="relative">
        <img src="public/images/thumb-agrismart.svg" class="h-44 w-full object-cover" alt="AgriSmart IoT Analytics">
        <span class="badge absolute left-3 top-3 bg-blue-100 text-blue-700">SI &bull; 2024</span>
        <span class="badge absolute right-3 top-3 bg-red-500 text-white"><span class="h-1.5 w-1.5 rounded-full bg-white"></span> LIVE</span>
      </div>
      <div class="p-5">
        <h3 class="font-bold text-navy-900">AgriSmart IoT Analytics</h3>
        <p class="mt-1.5 text-sm leading-relaxed text-slate-500">Sistem monitoring lahan pertanian berbasis IoT dengan dashboard analitik real-time.</p>
        <div class="my-4 border-t border-slate-100"></div>
        <div class="flex items-center justify-between text-sm">
          <span class="text-slate-500">Team Alpha</span>
          <span class="flex items-center gap-1 font-semibold text-red-500"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 17.5s-6-3.6-8-7.2C.7 7.5 2 4.5 5 4.5c2 0 3.5 1.3 5 3.2 1.5-1.9 3-3.2 5-3.2 3 0 4.3 3 3 5.8-2 3.6-8 7.2-8 7.2z"/></svg>482</span>
        </div>
      </div>
    </article>

    <article class="card overflow-hidden hover:shadow-lg transition">
      <div class="relative">
        <img src="public/images/thumb-edudata.svg" class="h-44 w-full object-cover" alt="EduData Insight Engine">
        <span class="badge absolute left-3 top-3 bg-green-100 text-green-700">BD &bull; 2024</span>
      </div>
      <div class="p-5">
        <h3 class="font-bold text-navy-900">EduData Insight Engine</h3>
        <p class="mt-1.5 text-sm leading-relaxed text-slate-500">Mesin pengolah data besar untuk prediksi performa akademik siswa menggunakan AI.</p>
        <div class="my-4 border-t border-slate-100"></div>
        <div class="flex items-center justify-between text-sm">
          <span class="text-slate-500">Data Wizards</span>
          <span class="flex items-center gap-1 font-semibold text-red-500"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 17.5s-6-3.6-8-7.2C.7 7.5 2 4.5 5 4.5c2 0 3.5 1.3 5 3.2 1.5-1.9 3-3.2 5-3.2 3 0 4.3 3 3 5.8-2 3.6-8 7.2-8 7.2z"/></svg>324</span>
        </div>
      </div>
    </article>

    <article class="card overflow-hidden hover:shadow-lg transition">
      <div class="relative">
        <img src="public/images/thumb-subanggo.svg" class="h-44 w-full object-cover" alt="SubangGo! Mobility">
        <span class="badge absolute left-3 top-3 bg-violet-100 text-violet-700">TRPL &bull; 2024</span>
        <span class="badge absolute right-3 top-3 bg-red-500 text-white"><span class="h-1.5 w-1.5 rounded-full bg-white"></span> LIVE</span>
      </div>
      <div class="p-5">
        <h3 class="font-bold text-navy-900">SubangGo! Mobility</h3>
        <p class="mt-1.5 text-sm leading-relaxed text-slate-500">Aplikasi mobile navigasi dan info transportasi publik terintegrasi di Kabupaten Subang.</p>
        <div class="my-4 border-t border-slate-100"></div>
        <div class="flex items-center justify-between text-sm">
          <span class="text-slate-500">Code Masters</span>
          <span class="flex items-center gap-1 font-semibold text-red-500"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 17.5s-6-3.6-8-7.2C.7 7.5 2 4.5 5 4.5c2 0 3.5 1.3 5 3.2 1.5-1.9 3-3.2 5-3.2 3 0 4.3 3 3 5.8-2 3.6-8 7.2-8 7.2z"/></svg>291</span>
        </div>
      </div>
    </article>
  </div>
</section>

<!-- ============================================================ -->
<!-- GRID + SIDEBAR -->
<!-- ============================================================ -->
<section class="mx-auto max-w-7xl px-6 pb-16" x-data="{ activeTab: 'Semua' }">
  <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
    <div class="lg:col-span-2">
      <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap gap-2">
          <button @click="activeTab='Semua'" :class="activeTab==='Semua' ? 'bg-navy-800 text-white border-navy-800' : 'border-slate-300 text-slate-600 hover:bg-slate-50'" class="rounded-full border px-4 py-2 text-sm font-semibold transition">Semua</button>
          <button @click="activeTab='SI'" :class="activeTab==='SI' ? 'bg-navy-800 text-white border-navy-800' : 'border-slate-300 text-slate-600 hover:bg-slate-50'" class="rounded-full border px-4 py-2 text-sm font-semibold transition">SI</button>
          <button @click="activeTab='TRPL'" :class="activeTab==='TRPL' ? 'bg-navy-800 text-white border-navy-800' : 'border-slate-300 text-slate-600 hover:bg-slate-50'" class="rounded-full border px-4 py-2 text-sm font-semibold transition">TRPL</button>
          <button @click="activeTab='BD'" :class="activeTab==='BD' ? 'bg-navy-800 text-white border-navy-800' : 'border-slate-300 text-slate-600 hover:bg-slate-50'" class="rounded-full border px-4 py-2 text-sm font-semibold transition">BD</button>
        </div>
        <select class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-600">
          <option>Terbaru</option><option>Terpopuler</option><option>A-Z</option>
        </select>
      </div>

      <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @php placeholder cards below are static @endphp
        <article class="card overflow-hidden hover:shadow-lg transition">
          <div class="flex h-32 items-center justify-center bg-slate-100"><svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 6h16a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V7a1 1 0 011-1z"/><circle cx="9" cy="9" r="1.5"/></svg></div>
          <div class="p-4"><span class="badge bg-blue-100 text-blue-700">SI</span><h3 class="mt-2 font-bold text-navy-900">Smart City Dashboard</h3><div class="mt-1 flex items-center justify-between text-sm"><span class="text-slate-500">Visionary</span><span class="flex items-center gap-1 font-semibold text-red-500"><svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 17.5s-6-3.6-8-7.2C.7 7.5 2 4.5 5 4.5c2 0 3.5 1.3 5 3.2 1.5-1.9 3-3.2 5-3.2 3 0 4.3 3 3 5.8-2 3.6-8 7.2-8 7.2z"/></svg>154</span></div></div>
        </article>
        <article class="card overflow-hidden hover:shadow-lg transition">
          <div class="flex h-32 items-center justify-center bg-slate-100"><svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 6h16a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V7a1 1 0 011-1z"/><circle cx="9" cy="9" r="1.5"/></svg></div>
          <div class="p-4"><span class="badge bg-green-100 text-green-700">BD</span><h3 class="mt-2 font-bold text-navy-900">Stock Prediction AI</h3><div class="mt-1 flex items-center justify-between text-sm"><span class="text-slate-500">Data Lab</span><span class="flex items-center gap-1 font-semibold text-red-500"><svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 17.5s-6-3.6-8-7.2C.7 7.5 2 4.5 5 4.5c2 0 3.5 1.3 5 3.2 1.5-1.9 3-3.2 5-3.2 3 0 4.3 3 3 5.8-2 3.6-8 7.2-8 7.2z"/></svg>98</span></div></div>
        </article>
        <article class="card overflow-hidden hover:shadow-lg transition">
          <div class="flex h-32 items-center justify-center bg-slate-100"><svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 6h16a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V7a1 1 0 011-1z"/><circle cx="9" cy="9" r="1.5"/></svg></div>
          <div class="p-4"><span class="badge bg-violet-100 text-violet-700">TRPL</span><h3 class="mt-2 font-bold text-navy-900">Inventory Pro App</h3><div class="mt-1 flex items-center justify-between text-sm"><span class="text-slate-500">SysAdmin</span><span class="flex items-center gap-1 font-semibold text-red-500"><svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 17.5s-6-3.6-8-7.2C.7 7.5 2 4.5 5 4.5c2 0 3.5 1.3 5 3.2 1.5-1.9 3-3.2 5-3.2 3 0 4.3 3 3 5.8-2 3.6-8 7.2-8 7.2z"/></svg>210</span></div></div>
        </article>
        <article class="card overflow-hidden hover:shadow-lg transition">
          <div class="flex h-32 items-center justify-center bg-slate-100"><svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 6h16a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V7a1 1 0 011-1z"/><circle cx="9" cy="9" r="1.5"/></svg></div>
          <div class="p-4"><span class="badge bg-violet-100 text-violet-700">TRPL</span><h3 class="mt-2 font-bold text-navy-900">HealthTrack Mobile</h3><div class="mt-1 flex items-center justify-between text-sm"><span class="text-slate-500">MedTech</span><span class="flex items-center gap-1 font-semibold text-red-500"><svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 17.5s-6-3.6-8-7.2C.7 7.5 2 4.5 5 4.5c2 0 3.5 1.3 5 3.2 1.5-1.9 3-3.2 5-3.2 3 0 4.3 3 3 5.8-2 3.6-8 7.2-8 7.2z"/></svg>122</span></div></div>
        </article>
        <article class="card overflow-hidden hover:shadow-lg transition">
          <div class="flex h-32 items-center justify-center bg-slate-100"><svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 6h16a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V7a1 1 0 011-1z"/><circle cx="9" cy="9" r="1.5"/></svg></div>
          <div class="p-4"><span class="badge bg-blue-100 text-blue-700">SI</span><h3 class="mt-2 font-bold text-navy-900">E-Voting Blockchain</h3><div class="mt-1 flex items-center justify-between text-sm"><span class="text-slate-500">CryptoSec</span><span class="flex items-center gap-1 font-semibold text-red-500"><svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 17.5s-6-3.6-8-7.2C.7 7.5 2 4.5 5 4.5c2 0 3.5 1.3 5 3.2 1.5-1.9 3-3.2 5-3.2 3 0 4.3 3 3 5.8-2 3.6-8 7.2-8 7.2z"/></svg>432</span></div></div>
        </article>
        <article class="card overflow-hidden hover:shadow-lg transition">
          <div class="flex h-32 items-center justify-center bg-slate-100"><svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 6h16a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V7a1 1 0 011-1z"/><circle cx="9" cy="9" r="1.5"/></svg></div>
          <div class="p-4"><span class="badge bg-violet-100 text-violet-700">TRPL</span><h3 class="mt-2 font-bold text-navy-900">Automatic Sprinkler</h3><div class="mt-1 flex items-center justify-between text-sm"><span class="text-slate-500">IoT Squad</span><span class="flex items-center gap-1 font-semibold text-red-500"><svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 17.5s-6-3.6-8-7.2C.7 7.5 2 4.5 5 4.5c2 0 3.5 1.3 5 3.2 1.5-1.9 3-3.2 5-3.2 3 0 4.3 3 3 5.8-2 3.6-8 7.2-8 7.2z"/></svg>67</span></div></div>
        </article>
      </div>
    </div>

    <aside class="space-y-6">
      <div class="card p-5">
        <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8M12 17v4M7 4h10v4a5 5 0 01-10 0V4zM7 6H4a2 2 0 002 2h1M17 6h3a2 2 0 01-2 2h-1"/></svg><h3 class="font-bold text-navy-900">Leaderboard</h3></div>
        <ol class="mt-4 space-y-4">
          <li class="flex items-center gap-3"><span class="flex h-7 w-7 flex-none items-center justify-center rounded-full bg-navy-50 text-sm font-bold text-navy-700">1</span><div><p class="text-sm font-semibold text-navy-900">AgriSmart IoT</p><p class="text-xs text-slate-500">482 votes</p></div></li>
          <li class="flex items-center gap-3"><span class="flex h-7 w-7 flex-none items-center justify-center rounded-full bg-navy-50 text-sm font-bold text-navy-700">2</span><div><p class="text-sm font-semibold text-navy-900">E-Voting Blockchain</p><p class="text-xs text-slate-500">432 votes</p></div></li>
          <li class="flex items-center gap-3"><span class="flex h-7 w-7 flex-none items-center justify-center rounded-full bg-navy-50 text-sm font-bold text-navy-700">3</span><div><p class="text-sm font-semibold text-navy-900">EduData Engine</p><p class="text-xs text-slate-500">324 votes</p></div></li>
          <li class="flex items-center gap-3"><span class="flex h-7 w-7 flex-none items-center justify-center rounded-full bg-navy-50 text-sm font-bold text-navy-700">4</span><div><p class="text-sm font-semibold text-navy-900">SubangGo!</p><p class="text-xs text-slate-500">291 votes</p></div></li>
          <li class="flex items-center gap-3"><span class="flex h-7 w-7 flex-none items-center justify-center rounded-full bg-navy-50 text-sm font-bold text-navy-700">5</span><div><p class="text-sm font-semibold text-navy-900">Inventory Pro</p><p class="text-xs text-slate-500">210 votes</p></div></li>
        </ol>
      </div>
      <div class="card p-5">
        <h3 class="font-bold text-navy-900">Kategori</h3>
        <p class="mt-1 text-xs text-slate-500">Filter berdasarkan teknologi</p>
        <div class="mt-4 space-y-3">
          <label class="flex items-center gap-2 text-sm text-slate-600"><input type="checkbox" class="rounded border-slate-300 text-navy-700">Web Dev</label>
          <label class="flex items-center gap-2 text-sm text-slate-600"><input type="checkbox" class="rounded border-slate-300 text-navy-700">Mobile Apps</label>
          <label class="flex items-center gap-2 text-sm text-slate-600"><input type="checkbox" class="rounded border-slate-300 text-navy-700">IoT</label>
          <label class="flex items-center gap-2 text-sm text-slate-600"><input type="checkbox" class="rounded border-slate-300 text-navy-700">AI & Data</label>
          <label class="flex items-center gap-2 text-sm text-slate-600"><input type="checkbox" class="rounded border-slate-300 text-navy-700">UI/UX Design</label>
        </div>
      </div>
    </aside>
  </div>
</section>
</main>

<!-- ============================================================ -->
<!-- FOOTER (after homepage) -->
<!-- ============================================================ -->
<footer class="bg-navy-900">
  <div class="mx-auto flex max-w-7xl flex-col gap-6 px-6 py-10 md:flex-row md:items-center md:justify-between">
    <div><p class="text-lg font-extrabold text-white">JTIK POLSUB</p><p class="mt-1 text-sm text-slate-400">&copy; 2026 JTIK POLSUB Showcase. All rights reserved.</p></div>
    <nav class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-slate-300">
      <a href="#" class="hover:text-white">Privacy Policy</a><a href="#" class="hover:text-white">Terms of Service</a><a href="#" class="hover:text-white">Contact Faculty</a><a href="#" class="hover:text-white">Technical Support</a>
    </nav>
  </div>
</footer>

<div class="bg-slate-900 py-3 text-center text-xs font-medium text-slate-400">&darr; Halaman 2: Project Detail Page &darr;</div>

<!-- ============================================================ -->
<!-- ====================  PAGE 2: PROJECT DETAIL  =============== -->
<!-- ============================================================ -->

<header class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur">
  <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
    <a href="#home" class="text-lg font-extrabold tracking-tight text-navy-900">JTIK POLSUB</a>
    <nav class="hidden items-center gap-8 text-sm font-medium text-slate-600 md:flex">
      <a href="#home" class="hover:text-navy-800">Home</a><a href="#" class="hover:text-navy-800">Projects</a><a href="#" class="hover:text-navy-800">Leaderboard</a><a href="#" class="hover:text-navy-800">About</a>
    </nav>
    <div class="hidden items-center gap-3 md:flex"><button class="text-sm font-semibold text-slate-600">Sign In</button><button class="btn-primary">Submit Project</button></div>
  </div>
</header>

<section class="relative h-[420px] w-full overflow-hidden">
  <img src="public/images/detail-hero-bg.svg" alt="AgriSmart IoT Analytics" class="absolute inset-0 h-full w-full object-cover">
  <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-transparent"></div>
  <span class="absolute right-6 top-6 inline-flex items-center gap-1.5 rounded-full bg-emerald-500 px-3 py-1 text-xs font-bold text-white"><span class="h-1.5 w-1.5 rounded-full bg-white"></span> LIVE</span>
  <div class="absolute inset-x-0 bottom-0">
    <div class="mx-auto max-w-7xl px-6 pb-8">
      <div class="flex gap-2"><span class="badge bg-white/15 text-white ring-1 ring-white/30">SI</span><span class="badge bg-white/15 text-white ring-1 ring-white/30">IoT System</span></div>
      <h1 class="mt-3 text-3xl font-extrabold text-white sm:text-4xl">AgriSmart IoT Analytics</h1>
      <p class="mt-1 text-slate-300">Tim Alpha &mdash; Angkatan 2024</p>
      <div class="mt-5 flex flex-wrap gap-3">
        <button class="inline-flex items-center gap-2 rounded-lg bg-navy-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-navy-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 17.5s-6-3.6-8-7.2C.7 7.5 2 4.5 5 4.5c2 0 3.5 1.3 5 3.2 1.5-1.9 3-3.2 5-3.2 3 0 4.3 3 3 5.8-2 3.6-8 7.2-8 7.2z"/></svg>Vote (482)</button>
        <button class="inline-flex items-center gap-2 rounded-lg border border-white/30 bg-black/20 px-4 py-2.5 text-sm font-semibold text-white hover:bg-white/10"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.58 2 12.25c0 4.49 2.87 8.3 6.84 9.64.5.1.68-.22.68-.49 0-.24-.01-1.04-.01-1.89-2.78.62-3.37-1.2-3.37-1.2-.45-1.18-1.11-1.5-1.11-1.5-.91-.64.07-.63.07-.63 1 .07 1.53 1.05 1.53 1.05.9 1.57 2.35 1.12 2.92.86.09-.66.34-1.12.62-1.38-2.22-.26-4.56-1.13-4.56-5.03 0-1.11.38-2.02 1.03-2.73-.1-.26-.45-1.31.1-2.73 0 0 .84-.27 2.75 1.04a9.3 9.3 0 015 0c1.91-1.31 2.75-1.04 2.75-1.04.55 1.42.2 2.47.1 2.73.65.71 1.03 1.62 1.03 2.73 0 3.91-2.35 4.77-4.58 5.02.36.32.67.94.67 1.9 0 1.37-.01 2.48-.01 2.81 0 .27.18.6.69.49A10.02 10.02 0 0022 12.25C22 6.58 17.52 2 12 2z"/></svg>GitHub</button>
        <button class="inline-flex items-center gap-2 rounded-lg border border-white/30 bg-black/20 px-4 py-2.5 text-sm font-semibold text-white hover:bg-white/10"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M9 8h2M6 4h9l3 3v13a1 1 0 01-1 1H6a1 1 0 01-1-1V5a1 1 0 011-1z"/></svg>Laporan</button>
        <button class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-navy-900 hover:bg-slate-100"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6v6m0-6L10 14"/></svg>Buka Demo</button>
      </div>
    </div>
  </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-10">
  <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">
    <div class="space-y-10 lg:col-span-2">

      <div class="card p-5">
        <div class="flex flex-wrap items-center justify-between gap-3">
          <h2 class="flex items-center gap-2 font-bold text-navy-900"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="12" rx="2"/><path stroke-linecap="round" d="M8 20h8M12 16v4"/></svg>Live Demo</h2>
          <a href="#" class="btn-outline px-3 py-1.5 text-xs">Buka Demo di Tab Baru</a>
        </div>
        <img src="public/images/live-demo-screenshot.svg" class="mt-4 w-full rounded-lg" alt="Tampilan live demo dashboard">
      </div>

      <div>
        <h2 class="text-xl font-bold text-navy-900">Tentang Project</h2>
        <p class="mt-3 text-justify leading-relaxed text-slate-600">AgriSmart IoT Analytics adalah solusi terintegrasi untuk pemantauan tanaman secara real-time yang dirancang khusus untuk meningkatkan efisiensi pertanian modern. Dengan memanfaatkan sensor kelembaban tanah, suhu, dan intensitas cahaya, sistem ini memberikan data akurat yang dikirim melalui protokol MQTT ke dashboard analitik. Project ini bertujuan untuk membantu petani dalam pengambilan keputusan berbasis data guna mengoptimalkan penggunaan air dan memprediksi masa panen dengan lebih presisi.</p>
      </div>

      <div>
        <h2 class="text-xl font-bold text-navy-900">Fitur Utama</h2>
        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div class="card flex flex-col items-center gap-3 px-4 py-6 text-center"><span class="text-navy-700"><svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19V9m6 10V5m6 14v-7"/></svg></span><p class="font-semibold text-navy-900">Real-time Monitoring</p></div>
          <div class="card flex flex-col items-center gap-3 px-4 py-6 text-center"><span class="text-navy-700"><svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 17l5-5 4 4 8-8m0 0h-5m5 0v5"/></svg></span><p class="font-semibold text-navy-900">Predictive Analytics</p></div>
          <div class="card flex flex-col items-center gap-3 px-4 py-6 text-center"><span class="text-navy-700"><svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3s6 6.5 6 10.5a6 6 0 11-12 0C6 9.5 12 3 12 3z"/></svg></span><p class="font-semibold text-navy-900">Automated Irrigation</p></div>
        </div>
      </div>

      <div>
        <h2 class="text-xl font-bold text-navy-900">Tech Stack</h2>
        <div class="mt-4 flex flex-wrap gap-2">
          <span class="rounded-full bg-slate-100 px-4 py-1.5 text-sm font-medium text-slate-600">Laravel</span>
          <span class="rounded-full bg-slate-100 px-4 py-1.5 text-sm font-medium text-slate-600">React</span>
          <span class="rounded-full bg-slate-100 px-4 py-1.5 text-sm font-medium text-slate-600">ESP32</span>
          <span class="rounded-full bg-slate-100 px-4 py-1.5 text-sm font-medium text-slate-600">MQTT</span>
          <span class="rounded-full bg-slate-100 px-4 py-1.5 text-sm font-medium text-slate-600">Tailwind CSS</span>
        </div>
      </div>

      <div>
        <h2 class="text-xl font-bold text-navy-900">Anggota Tim</h2>
        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div class="card flex flex-col items-center gap-2 px-4 py-6 text-center"><img src="public/images/avatar-1.svg" class="h-16 w-16 rounded-full ring-2 ring-navy-100" alt="Rijalul Haq"><p class="font-bold text-navy-900">Rijalul Haq</p><p class="text-xs text-slate-500">240101010</p><span class="badge bg-slate-100 text-slate-600">Project Leader</span></div>
          <div class="card flex flex-col items-center gap-2 px-4 py-6 text-center"><img src="public/images/avatar-2.svg" class="h-16 w-16 rounded-full ring-2 ring-navy-100" alt="Bobon Santoso"><p class="font-bold text-navy-900">Bobon Santoso</p><p class="text-xs text-slate-500">240101011</p><span class="badge bg-slate-100 text-slate-600">Hardware Engineer</span></div>
          <div class="card flex flex-col items-center gap-2 px-4 py-6 text-center"><img src="public/images/avatar-3.svg" class="h-16 w-16 rounded-full ring-2 ring-navy-100" alt="Siti Aminah"><p class="font-bold text-navy-900">Siti Aminah</p><p class="text-xs text-slate-500">240101012</p><span class="badge bg-slate-100 text-slate-600">Web Developer</span></div>
        </div>
      </div>

      <div>
        <h2 class="text-xl font-bold text-navy-900">Galeri Screenshot</h2>
        <div class="mt-4 flex gap-4 overflow-x-auto pb-2">
          <img src="public/images/gallery-1.svg" class="h-32 w-48 flex-none rounded-lg object-cover" alt="Screenshot">
          <img src="public/images/gallery-2.svg" class="h-32 w-48 flex-none rounded-lg object-cover" alt="Screenshot">
          <img src="public/images/gallery-3.svg" class="h-32 w-48 flex-none rounded-lg object-cover" alt="Screenshot">
          <img src="public/images/gallery-4.svg" class="h-32 w-48 flex-none rounded-lg object-cover" alt="Screenshot">
        </div>
      </div>
    </div>

    <aside class="card h-fit p-6">
      <h3 class="border-b border-slate-100 pb-4 font-bold text-navy-900">Metadata Project</h3>
      <dl class="space-y-4 pt-4 text-sm">
        <div><dt class="text-slate-500">Dosen Pembimbing</dt><dd class="mt-0.5 font-semibold text-navy-900">Willy Muhammad Fauzi, S.T., M.Kom.</dd></div>
        <div><dt class="text-slate-500">Semester</dt><dd class="mt-0.5 font-semibold text-navy-900">Genap 2025/2026</dd></div>
        <div><dt class="text-slate-500">Prodi</dt><dd class="mt-0.5 font-semibold text-navy-900">Teknologi Rekayasa Perangkat Lunak</dd></div>
        <div><dt class="text-slate-500">Kategori</dt><dd class="mt-0.5 font-semibold text-navy-900">IoT System</dd></div>
        <div><dt class="text-slate-500">Status</dt><dd class="mt-0.5 font-semibold text-emerald-600">Live</dd></div>
        <div><dt class="text-slate-500">Tanggal Publish</dt><dd class="mt-0.5 font-semibold text-navy-900">1 Januari 2026</dd></div>
      </dl>
      <div class="my-5 border-t border-slate-100"></div>
      <div class="flex divide-x divide-slate-100 text-center">
        <div class="flex-1"><p class="text-xs text-slate-500">Views</p><p class="text-lg font-bold text-navy-900">1.240</p></div>
        <div class="flex-1"><p class="text-xs text-slate-500">Votes</p><p class="text-lg font-bold text-navy-900">482</p></div>
      </div>
      <div class="mt-6 space-y-3">
        <button class="btn-primary w-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5L21 3m0 0h-5.5M21 3v5.5M10 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-4"/></svg>GitHub Repository</button>
        <button class="btn-outline w-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>Download Laporan</button>
      </div>
    </aside>
  </div>
</section>

<footer class="bg-navy-900">
  <div class="mx-auto flex max-w-7xl flex-col gap-6 px-6 py-10 md:flex-row md:items-center md:justify-between">
    <div><p class="text-lg font-extrabold text-white">JTIK POLSUB</p><p class="mt-1 text-sm text-slate-400">&copy; 2026 JTIK POLSUB Showcase. All rights reserved.</p></div>
    <nav class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-slate-300">
      <a href="#" class="hover:text-white">Privacy Policy</a><a href="#" class="hover:text-white">Terms of Service</a><a href="#" class="hover:text-white">Contact Faculty</a><a href="#" class="hover:text-white">Technical Support</a>
    </nav>
  </div>
</footer>

</body>
</html>
