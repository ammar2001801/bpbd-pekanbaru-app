<x-app-layout>
    <x-slot name="header">
        Geoportal & Portal Data Bencana Kota Pekanbaru
    </x-slot>

    <!-- ================= 1. HEADER GEOPORTAL ALA BNPB ================= -->
    <div class="mb-6 bg-gradient-to-r from-slate-950 via-blue-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-slate-800">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <img src="{{ asset('images/logo-bpbd.png') }}" alt="Watermark" class="absolute right-6 top-6 w-36 h-36 rounded-full object-contain opacity-10 pointer-events-none select-none">

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <!-- Status Bar Tag -->
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 text-[11px] font-bold uppercase tracking-wider">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        PUSDALOPS-PB ONLINE
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-500/15 text-orange-300 border border-orange-500/30 text-[11px] font-bold uppercase tracking-wider">
                        STANDAR DIBI BNPB
                    </span>
                    <span class="text-xs text-slate-400 hidden sm:inline">
                        &bull; {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </span>
                </div>

                <div class="flex items-start gap-4">
                    <img src="{{ asset('images/logo-bpbd.png') }}" alt="Logo BPBD" class="w-14 h-14 rounded-full object-contain drop-shadow-xl hidden sm:block flex-shrink-0 mt-0.5">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight leading-tight">
                            PORTAL SATU DATA BENCANA & GEOPORTAL DAERAH
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-300 mt-1.5 leading-relaxed">
                            Sistem pemantauan geospasial dan rekapitulasi data informasi bencana terintegrasi Badan Penanggulangan Bencana Daerah (BPBD) Kota Pekanbaru.
                        </p>
                    </div>
                </div>

                <div class="mt-5 flex flex-wrap items-center gap-2.5">
                    @if(Auth::user()->role !== 'pimpinan')
                    <a href="{{ route('kejadian.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:via-amber-600 hover:to-orange-700 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-orange-500/30 hover:shadow-xl hover:shadow-orange-500/40 hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all duration-200 border border-orange-400/40">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Input Kejadian Bencana</span>
                    </a>
                    @endif
                    <a href="{{ route('rekap.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-800/80 hover:bg-slate-700/80 text-white font-bold text-xs uppercase tracking-wider border border-white/15 hover:border-white/30 backdrop-blur-md shadow-sm hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all duration-200">
                        <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>Rekapitulasi Data</span>
                    </a>
                    <a href="{{ route('laporan.pdf-menu') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-800/80 hover:bg-slate-700/80 text-white font-bold text-xs uppercase tracking-wider border border-white/15 hover:border-white/30 backdrop-blur-md shadow-sm hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all duration-200">
                        <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Dokumen Resmi PDF</span>
                    </a>
                </div>
            </div>

            <!-- Panel Filter Cepat (Tahun & Bulan) -->
            <div class="bg-slate-900/80 backdrop-blur-md border border-white/10 rounded-2xl p-4 min-w-[280px]">
                <div class="text-[11px] font-bold text-orange-400 uppercase tracking-wider mb-2.5 flex items-center justify-between">
                    <span>Filter Periode Analisis</span>
                    <span>Tahun {{ $selectedTahun }}</span>
                </div>
                <form method="GET" action="{{ route('dashboard') }}" class="space-y-2.5">
                    <div>
                        <label class="block text-[10px] text-slate-400 mb-1 uppercase font-semibold">Bulan Kejadian</label>
                        <select name="bulan" onchange="this.form.submit()" class="w-full text-xs rounded-xl bg-slate-950 border-slate-700 text-white py-2 focus:border-orange-500 focus:ring-orange-500">
                            <option value="semua" {{ $selectedBulan === 'semua' ? 'selected' : '' }}>Semua Bulan (Jan - Des)</option>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $selectedBulan == $m ? 'selected' : '' }}>
                                    Bulan {{ \Carbon\Carbon::create(2026, $m, 1)->locale('id')->isoFormat('MMMM') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] text-slate-400 mb-1 uppercase font-semibold">Tahun Anggaran</label>
                        <select name="tahun" onchange="this.form.submit()" class="w-full text-xs rounded-xl bg-slate-950 border-slate-700 text-white py-2 focus:border-orange-500 focus:ring-orange-500">
                            @foreach($tahunTersedia as $thn)
                                <option value="{{ $thn }}" {{ $selectedTahun == $thn ? 'selected' : '' }}>Tahun {{ $thn }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if($selectedBulan !== 'semua' || $selectedTahun != now()->year)
                        <a href="{{ route('dashboard') }}" class="block text-center text-[10px] text-rose-400 hover:underline pt-1 font-semibold">
                            Reset ke Tahun Berjalan
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- ================= 2. KARTU METRIK DAMPAK BENCANA ALA BNPB ================= -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5 mb-6">
        
        <!-- Total Kejadian -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-800 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-2.5">
                <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Kejadian</span>
                <div class="w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-slate-900 dark:text-white">{{ $totalTahunIni }}</div>
            <div class="mt-1 text-[10px] text-slate-400 dark:text-slate-500">
                Hari ini: <strong class="text-slate-700 dark:text-slate-300">{{ $totalHariIni }}</strong> &bull; Bln: <strong class="text-slate-700 dark:text-slate-300">{{ $totalBulanIni }}</strong>
            </div>
        </div>

        <!-- Korban Meninggal -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-800 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-2.5">
                <span class="text-[10px] font-bold text-red-600 dark:text-red-400 uppercase tracking-wider">Meninggal / Hilang</span>
                <div class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-950/50 text-red-600 dark:text-red-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-red-600 dark:text-red-400">{{ $totalMeninggal }} <span class="text-xs font-medium text-slate-400 dark:text-slate-500">Jiwa</span></div>
            <div class="mt-1 text-[10px] text-slate-500 dark:text-slate-400">
                Korban jiwa tercatat
            </div>
        </div>

        <!-- Korban Luka -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-800 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-2.5">
                <span class="text-[10px] font-bold text-amber-700 dark:text-amber-400 uppercase tracking-wider">Korban Luka-Luka</span>
                <div class="w-7 h-7 rounded-lg bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ $totalLuka }} <span class="text-xs font-medium text-slate-400 dark:text-slate-500">Jiwa</span></div>
            <div class="mt-1 text-[10px] text-slate-500 dark:text-slate-400">
                Penanganan medis TRC
            </div>
        </div>

        <!-- Terdampak KK/Jiwa -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-800 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-2.5">
                <span class="text-[10px] font-bold text-blue-700 dark:text-blue-400 uppercase tracking-wider">Warga Terdampak</span>
                <div class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-blue-700 dark:text-blue-400">{{ $totalJiwa }} <span class="text-xs font-medium text-slate-400 dark:text-slate-500">Jiwa</span></div>
            <div class="mt-1 text-[10px] text-slate-500 dark:text-slate-400">
                {{ $totalKK }} Kepala Keluarga (KK)
            </div>
        </div>

        <!-- Luas Karhutla -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-800 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-2.5">
                <span class="text-[10px] font-bold text-orange-700 dark:text-orange-400 uppercase tracking-wider">Luas Karhutla</span>
                <div class="w-7 h-7 rounded-lg bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-orange-700 dark:text-orange-400">{{ number_format($totalLuasKarhutla, 1) }} <span class="text-xs font-medium text-slate-400 dark:text-slate-500">Ha</span></div>
            <div class="mt-1 text-[10px] text-slate-500 dark:text-slate-400">
                Area lahan terbakar
            </div>
        </div>

        <!-- Dalam Penanganan -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 border border-rose-200 dark:border-rose-900/60 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-1 h-full bg-rose-500"></div>
            <div class="flex items-center justify-between mb-2.5">
                <span class="text-[10px] font-bold text-rose-700 dark:text-rose-400 uppercase tracking-wider">Operasi Aktif</span>
                <div class="w-7 h-7 rounded-lg bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-rose-600 dark:text-rose-400">{{ $totalDalamPenanganan }} <span class="text-xs font-medium text-slate-400 dark:text-slate-500">TKP</span></div>
            <div class="mt-1 text-[10px] text-rose-600 dark:text-rose-400 font-bold flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping"></span>
                <span>Dalam Penanganan</span>
            </div>
        </div>

    </div>

    <!-- ================= 3. HERO GEOPORTAL WEBGIS BNPB STYLE (CENTERPIECE) ================= -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden mb-6">
        
        <!-- Top Toolbar Peta Geoportal -->
        <div class="p-4 sm:p-5 border-b border-slate-800 bg-slate-900 text-white flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-orange-600/20 border border-orange-500/30 text-orange-400 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <div>
                    <h2 class="text-sm sm:text-base font-black text-white uppercase tracking-wider">
                        GEOPORTAL SEBARAN SPASIAL BENCANA KOTA PEKANBARU
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Pemetaan interaktif titik koordinat kejadian bencana & kedaruratan (Total: <strong class="text-white">{{ $mapPoints->count() }} titik</strong> terpetakan).
                    </p>
                </div>
            </div>

            <!-- Kontrol Cepat Basemap (Peta Satelit / Peta Jalan) -->
            <div class="flex flex-wrap items-center gap-2">
                <div class="inline-flex rounded-2xl bg-slate-950/80 p-1 border border-slate-700/80 backdrop-blur-sm text-xs shadow-inner">
                    <button type="button" onclick="switchBasemap('osm')" id="btnBasemapOsm" class="px-3.5 py-1.5 rounded-xl font-bold bg-gradient-to-r from-orange-500 to-amber-500 text-white transition-all shadow-xs hover:scale-105 active:scale-95">
                        Peta Jalan
                    </button>
                    <button type="button" onclick="switchBasemap('satellite')" id="btnBasemapSat" class="px-3.5 py-1.5 rounded-xl font-semibold text-slate-400 hover:text-white hover:bg-slate-800/60 transition-all hover:scale-105 active:scale-95">
                        Citra Satelit
                    </button>
                    <button type="button" onclick="switchBasemap('dark')" id="btnBasemapDark" class="px-3.5 py-1.5 rounded-xl font-semibold text-slate-400 hover:text-white hover:bg-slate-800/60 transition-all hover:scale-105 active:scale-95">
                        Dark GIS
                    </button>
                </div>

                <button type="button" onclick="resetPekanbaruView()" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-slate-800/90 hover:bg-slate-700 text-white text-xs font-bold border border-slate-700/80 shadow-xs hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all" title="Pusatkan Peta">
                    <svg class="w-3.5 h-3.5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Pusatkan</span>
                </button>
            </div>
        </div>

        <!-- Filter Layer Kategori Bencana (Pill Button Toolbar) -->
        <div class="bg-slate-50 dark:bg-slate-950 px-4 py-2.5 border-b border-slate-200 dark:border-slate-800 overflow-x-auto flex items-center gap-1.5">
            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mr-1 whitespace-nowrap">
                Layer Bencana:
            </span>
            <button type="button" onclick="filterMapCategory('all')" id="filterBtnAll" class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-slate-900 to-slate-800 dark:from-orange-600 dark:to-amber-600 text-white shadow-md shadow-orange-500/20 whitespace-nowrap transition-all duration-200 hover:scale-105 active:scale-95">
                Semua Bencana ({{ $mapPoints->count() }})
            </button>
            @foreach($semuaJenisKejadian as $jenis)
                @php
                    $countJ = $mapPoints->where('jenis_id', $jenis->id)->count();
                @endphp
                <button type="button" onclick="filterMapCategory({{ $jenis->id }})" id="filterBtn{{ $jenis->id }}" 
                        class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-white dark:bg-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 whitespace-nowrap transition-all duration-200 hover:scale-105 active:scale-95 hover:border-orange-400/50 flex items-center gap-2 shadow-2xs">
                    <span class="w-2.5 h-2.5 rounded-full inline-block shadow-2xs" style="background-color: {{ $jenis->warna }};"></span>
                    <span class="font-medium">{{ $jenis->nama }}</span>
                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono font-bold bg-slate-100 dark:bg-slate-800 px-1.5 py-0.2 rounded-full">({{ $countJ }})</span>
                </button>
            @endforeach
        </div>

        <!-- Container Peta Leaflet Utama -->
        <div class="relative">
            <div id="dashboardMap" class="w-full h-[460px] sm:h-[520px] z-10"></div>

            <!-- Floating Map Legend Box (Pojok Kanan Bawah) -->
            <div class="absolute bottom-4 right-4 z-[400] bg-white/95 dark:bg-slate-900/95 backdrop-blur-md rounded-2xl p-3.5 shadow-xl border border-slate-200/80 dark:border-slate-800 max-w-[220px] text-xs">
                <div class="font-bold text-slate-800 dark:text-white text-[11px] uppercase tracking-wider mb-2 border-b border-slate-100 dark:border-slate-800 pb-1.5 flex items-center justify-between">
                    <span>Legenda Spasial</span>
                    <span class="text-[10px] text-slate-400">WebGIS</span>
                </div>
                <div class="space-y-1.5 text-[11px] max-h-36 overflow-y-auto pr-1">
                    @foreach($semuaJenisKejadian as $j)
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: {{ $j->warna }};"></span>
                            <span class="text-slate-700 dark:text-slate-300 truncate font-medium">{{ $j->nama }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <!-- ================= 4. ANALITIK GRAFIK BNPB (DUA KOLOM) ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        
        <!-- Kolom Kiri: Tren Bulanan Kejadian (2 Kolom) -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-2xs">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Kurva Tren Kejadian Bencana Per Bulan</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Fluktuasi frekuensi kejadian sepanjang Tahun {{ $selectedTahun }}</p>
                </div>
                <span class="text-[11px] font-bold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 px-2.5 py-1 rounded-lg">
                    Tren Bulanan
                </span>
            </div>
            <div class="h-64 sm:h-72">
                <canvas id="chartTrenBulanan"></canvas>
            </div>
        </div>

        <!-- Kolom Kanan: Komposisi Jenis Bahaya Bencana (1 Kolom) -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Komposisi Bahaya Bencana</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Distribusi proporsi jenis kejadian</p>
                </div>
                <span class="text-[11px] font-bold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 px-2.5 py-1 rounded-lg">
                    Proporsi
                </span>
            </div>
            <div class="h-64 sm:h-72 flex items-center justify-center">
                <canvas id="chartKomposisiJenis"></canvas>
            </div>
        </div>

    </div>

    <!-- ================= 5. PERINGKAT KECAMATAN RAWAN BENCANA (BAR CHART) ================= -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-2xs mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Peringkat Kerentanan Wilayah (15 Kecamatan)</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Diurutkan berdasarkan akumulasi kejadian terbanyak (indeks kawasan paling sering terdampak)</p>
            </div>
            <span class="text-[11px] font-bold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 px-2.5 py-1 rounded-lg self-start sm:self-auto">
                Peringkat Wilayah
            </span>
        </div>
        <div class="h-72 sm:h-80">
            <canvas id="chartKecamatan"></canvas>
        </div>
    </div>

    <!-- ================= 6. FEED LAPORAN TERAKHIR (REAL-TIME STREAM) ================= -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-2xs overflow-hidden mb-8">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Laporan Kedaruratan & Kejadian Terkini</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Laporan terbaru yang terinput ke Pusdalops-PB Kota Pekanbaru</p>
            </div>
            <a href="{{ route('kejadian.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-orange-50 dark:bg-orange-950/40 hover:bg-orange-100 dark:hover:bg-orange-900/50 text-xs font-bold text-orange-600 dark:text-orange-400 border border-orange-200/60 dark:border-orange-800/60 transition-all self-start sm:self-auto">
                <span>Lihat Semua Data ({{ $totalTahunIni }})</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($kejadianTerbaru as $item)
                <div class="p-5 rounded-2xl bg-slate-50/70 dark:bg-slate-950/60 border border-slate-200/70 dark:border-slate-800/80 hover:bg-white dark:hover:bg-slate-900 hover:border-orange-400/50 dark:hover:border-orange-500/40 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="font-mono text-xs font-bold text-blue-950 dark:text-blue-300 bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 px-2.5 py-1 rounded-lg shadow-2xs">{{ $item->nomor_laporan }}</span>
                            @if($item->status === 'Selesai')
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                    Selesai
                                </span>
                            @else
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-rose-50 dark:bg-rose-950/50 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping"></span>
                                    <span>Dalam Penanganan</span>
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2.5 h-2.5 rounded-full shrink-0 shadow-2xs" style="background-color: {{ $item->jenisKejadian->warna }};"></span>
                            <span class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">{{ $item->jenisKejadian->nama }}</span>
                        </div>

                        <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-2 mb-4 leading-relaxed">
                            {{ $item->lokasi_detail }}, <strong class="text-slate-700 dark:text-slate-300">Kec. {{ $item->kecamatan->nama_kecamatan }}</strong>
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-200/60 dark:border-slate-800/80 flex items-center justify-between text-xs">
                        <span class="text-[11px] text-slate-400 dark:text-slate-500 font-mono">
                            {{ $item->tanggal_kejadian->format('d/m/Y') }} &bull; {{ substr($item->jam_kejadian, 0, 5) }} WIB
                        </span>
                        <a href="{{ route('kejadian.show', $item->id) }}" class="px-2.5 py-1 rounded-lg bg-white dark:bg-slate-800 hover:bg-orange-500 hover:text-white dark:hover:bg-orange-500 dark:hover:text-white text-xs font-bold text-orange-600 dark:text-orange-400 border border-slate-200 dark:border-slate-700 inline-flex items-center gap-1 transition-all shadow-2xs">
                            <span>Detail</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-10 text-slate-400 italic">
                    Belum ada data laporan kejadian bencana.
                </div>
            @endforelse
        </div>
    </div>

    <!-- ================= JAVASCRIPT: LEAFLET & CHART.JS ENGINE ================= -->
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // -----------------------------------------------------------------
            // 1. INISIALISASI PETA GEOPORTAL LEAFLET
            // -----------------------------------------------------------------
            const mapContainer = document.getElementById('dashboardMap');
            if (mapContainer) {
                const pekanbaruCoords = [0.5071, 101.4478];
                const map = L.map('dashboardMap').setView(pekanbaruCoords, 12);
                window.dashboardMapInstance = map;

                // Definisi Basemap Layers
                const basemapOsm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                const basemapSatellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19,
                    attribution: '&copy; Esri &bull; Earthstar Geographics'
                });

                const basemapDark = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                    maxZoom: 19,
                    attribution: '&copy; CARTO'
                });

                window.currentBasemap = basemapOsm;
                window.basemapList = {
                    osm: basemapOsm,
                    satellite: basemapSatellite,
                    dark: basemapDark
                };

                // Data Titik Spasial dari Controller
                const rawPoints = @json($mapPoints);
                window.mapMarkers = [];

                function createPulsedIcon(color) {
                    return L.divIcon({
                        className: 'custom-bnpb-pin',
                        html: `
                            <div style="position: relative; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center;">
                                <div style="position: absolute; width: 24px; height: 24px; border-radius: 50%; background-color: ${color}; opacity: 0.35; animation: ping 1.8s cubic-bezier(0, 0, 0.2, 1) infinite;"></div>
                                <div style="position: relative; width: 14px; height: 14px; border-radius: 50%; background-color: ${color}; border: 2px solid #ffffff; box-shadow: 0 2px 6px rgba(0,0,0,0.4);"></div>
                            </div>
                        `,
                        iconSize: [26, 26],
                        iconAnchor: [13, 13],
                        popupAnchor: [0, -14]
                    });
                }

                rawPoints.forEach(p => {
                    const icon = createPulsedIcon(p.warna);
                    const marker = L.marker([p.lat, p.lng], { icon: icon });

                    let impactDetails = '';
                    if (p.korban_meninggal > 0 || p.korban_luka > 0) {
                        impactDetails += `<div style="color: #dc2626; font-weight: bold; font-size: 11px;">Korban MD: ${p.korban_meninggal} | Luka: ${p.korban_luka}</div>`;
                    }
                    if (p.luas_terbakar_ha > 0) {
                        impactDetails += `<div style="color: #ea580c; font-weight: bold; font-size: 11px;">Luas Area: ${p.luas_terbakar_ha} Ha</div>`;
                    }

                    let photoImg = '';
                    if (p.foto_url) {
                        photoImg = `<img src="${p.foto_url}" style="width: 100%; height: 90px; object-fit: cover; border-radius: 8px; margin-bottom: 8px;" />`;
                    }

                    const popupHtml = `
                        <div style="min-width: 220px; font-family: sans-serif; font-size: 12px; line-height: 1.4;">
                            ${photoImg}
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 4px; margin-bottom: 4px;">
                                <span style="font-family: monospace; font-weight: bold; color: #1E3A8A; font-size: 11px;">${p.nomor}</span>
                                <span style="background: ${p.warna}20; color: ${p.warna}; padding: 1px 6px; border-radius: 4px; font-weight: bold; font-size: 10px;">${p.jenis}</span>
                            </div>
                            <div style="font-weight: bold; color: #0F172A; margin-bottom: 2px;">Kec. ${p.kecamatan}</div>
                            <div style="color: #475569; font-size: 11px; margin-bottom: 4px;">${p.lokasi}</div>
                            ${impactDetails}
                            <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #e2e8f0; padding-top: 6px; margin-top: 6px;">
                                <span style="color: #64748b; font-size: 10px;">${p.tanggal} ${p.jam}</span>
                                <a href="${p.url}" target="_blank" style="color: #ea580c; font-weight: bold; font-size: 11px; text-decoration: none;">Lihat Detail &rarr;</a>
                            </div>
                        </div>
                    `;

                    marker.bindPopup(popupHtml);
                    marker.addTo(map);

                    window.mapMarkers.push({
                        marker: marker,
                        jenis_id: p.jenis_id
                    });
                });
            }

            // -----------------------------------------------------------------
            // 2. CHART.JS: TREN BULANAN
            // -----------------------------------------------------------------
            const isDarkNow = document.documentElement.classList.contains('dark');
            const initialGridColor = isDarkNow ? 'rgba(255, 255, 255, 0.08)' : '#f1f5f9';
            const initialTickColor = isDarkNow ? '#94a3b8' : '#64748b';
            const initialDonutBorder = isDarkNow ? '#0f172a' : '#ffffff';

            const ctxTren = document.getElementById('chartTrenBulanan');
            if (ctxTren) {
                window.chartTrenInstance = new Chart(ctxTren, {
                    type: 'line',
                    data: {
                        labels: @json($namaBulanSingkat),
                        datasets: [{
                            label: 'Jumlah Bencana',
                            data: @json($lineTrenPerBulan),
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.35,
                            pointBackgroundColor: '#EA580C',
                            pointBorderColor: initialDonutBorder,
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                padding: 10,
                                cornerRadius: 8
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1, color: initialTickColor },
                                grid: { color: initialGridColor }
                            },
                            x: {
                                ticks: { color: initialTickColor },
                                grid: { display: false }
                            }
                        }
                    }
                });
            }

            // -----------------------------------------------------------------
            // 3. CHART.JS: KOMPOSISI JENIS BENCANA (DOUGHNUT)
            // -----------------------------------------------------------------
            const ctxJenis = document.getElementById('chartKomposisiJenis');
            if (ctxJenis) {
                window.chartJenisInstance = new Chart(ctxJenis, {
                    type: 'doughnut',
                    data: {
                        labels: @json($donutJenisLabels),
                        datasets: [{
                            data: @json($donutJenisCounts),
                            backgroundColor: @json($donutJenisColors),
                            borderWidth: 2,
                            borderColor: initialDonutBorder,
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 10,
                                    font: { size: 10 },
                                    color: initialTickColor
                                }
                            }
                        },
                        cutout: '65%'
                    }
                });
            }

            // -----------------------------------------------------------------
            // 4. CHART.JS: PERINGKAT KECAMATAN (BAR)
            // -----------------------------------------------------------------
            const ctxKec = document.getElementById('chartKecamatan');
            if (ctxKec) {
                window.chartKecInstance = new Chart(ctxKec, {
                    type: 'bar',
                    data: {
                        labels: @json($barKecamatanLabels),
                        datasets: [{
                            label: 'Jumlah Kejadian Bencana',
                            data: @json($barKecamatanCounts),
                            backgroundColor: '#EA580C',
                            borderRadius: 6,
                            borderSkipped: false
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1, color: initialTickColor },
                                grid: { color: initialGridColor }
                            },
                            x: {
                                ticks: {
                                    color: initialTickColor,
                                    font: { size: 10 },
                                    autoSkip: false,
                                    maxRotation: 45,
                                    minRotation: 30
                                },
                                grid: { display: false }
                            }
                        }
                    }
                });
            }

            // Theme Changed Listener to update charts instantly
            window.addEventListener('theme-changed', function(e) {
                const dark = e.detail.dark;
                const gridColor = dark ? 'rgba(255, 255, 255, 0.08)' : '#f1f5f9';
                const tickColor = dark ? '#94a3b8' : '#64748b';
                const donutBorder = dark ? '#0f172a' : '#ffffff';

                if (window.chartTrenInstance) {
                    window.chartTrenInstance.options.scales.y.grid.color = gridColor;
                    window.chartTrenInstance.options.scales.y.ticks.color = tickColor;
                    window.chartTrenInstance.options.scales.x.ticks.color = tickColor;
                    window.chartTrenInstance.data.datasets[0].pointBorderColor = donutBorder;
                    window.chartTrenInstance.update();
                }
                if (window.chartJenisInstance) {
                    window.chartJenisInstance.data.datasets[0].borderColor = donutBorder;
                    if (window.chartJenisInstance.options.plugins.legend) {
                        window.chartJenisInstance.options.plugins.legend.labels.color = tickColor;
                    }
                    window.chartJenisInstance.update();
                }
                if (window.chartKecInstance) {
                    window.chartKecInstance.options.scales.y.grid.color = gridColor;
                    window.chartKecInstance.options.scales.y.ticks.color = tickColor;
                    window.chartKecInstance.options.scales.x.ticks.color = tickColor;
                    window.chartKecInstance.update();
                }
            });

        });

        function switchBasemap(type) {
            const map = window.dashboardMapInstance;
            if (!map) return;

            map.removeLayer(window.currentBasemap);
            const nextLayer = window.basemapList[type] || window.basemapList.osm;
            nextLayer.addTo(map);
            window.currentBasemap = nextLayer;

            const inactiveBasemap = 'px-3.5 py-1.5 rounded-xl font-semibold text-slate-400 hover:text-white hover:bg-slate-800/60 transition-all hover:scale-105 active:scale-95';
            const activeBasemap = 'px-3.5 py-1.5 rounded-xl font-bold bg-gradient-to-r from-orange-500 to-amber-500 text-white transition-all shadow-xs hover:scale-105 active:scale-95';

            document.getElementById('btnBasemapOsm').className = inactiveBasemap;
            document.getElementById('btnBasemapSat').className = inactiveBasemap;
            document.getElementById('btnBasemapDark').className = inactiveBasemap;

            if (type === 'osm') {
                document.getElementById('btnBasemapOsm').className = activeBasemap;
            } else if (type === 'satellite') {
                document.getElementById('btnBasemapSat').className = activeBasemap;
            } else if (type === 'dark') {
                document.getElementById('btnBasemapDark').className = activeBasemap;
            }
        }

        function filterMapCategory(catId) {
            const map = window.dashboardMapInstance;
            if (!map || !window.mapMarkers) return;

            window.mapMarkers.forEach(item => {
                if (catId === 'all' || item.jenis_id == catId) {
                    if (!map.hasLayer(item.marker)) {
                        item.marker.addTo(map);
                    }
                } else {
                    if (map.hasLayer(item.marker)) {
                        map.removeLayer(item.marker);
                    }
                }
            });

            const inactiveChip = 'px-3 py-1.5 rounded-xl text-xs font-semibold bg-white dark:bg-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 whitespace-nowrap transition-all duration-200 hover:scale-105 active:scale-95 hover:border-orange-400/50 flex items-center gap-2 shadow-2xs';
            const activeChip = 'px-3.5 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-slate-900 to-slate-800 dark:from-orange-600 dark:to-amber-600 text-white shadow-md shadow-orange-500/20 whitespace-nowrap transition-all duration-200 flex items-center gap-2';

            document.querySelectorAll('[id^="filterBtn"]').forEach(btn => {
                btn.className = inactiveChip;
            });
            const activeBtn = document.getElementById(catId === 'all' ? 'filterBtnAll' : 'filterBtn' + catId);
            if (activeBtn) {
                activeBtn.className = activeChip;
            }
        }

        function resetPekanbaruView() {
            if (window.dashboardMapInstance) {
                window.dashboardMapInstance.setView([0.5071, 101.4478], 12);
            }
        }
    </script>
    @endpush

</x-app-layout>
