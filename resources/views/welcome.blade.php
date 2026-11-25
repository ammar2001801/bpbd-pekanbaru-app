<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Resmi BPBD Kota Pekanbaru - Pusat Pengendalian Operasi Penanggulangan Bencana (PUSDALOPS-PB)</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-bpbd.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* 1. Infinite Running Marquee Ticker */
        @keyframes bpbd-marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-bpbd-marquee {
            display: inline-flex;
            white-space: nowrap;
            animation: bpbd-marquee 32s linear infinite;
        }
        .animate-bpbd-marquee:hover {
            animation-play-state: paused;
        }

        /* 2. Radar Pulsing Marker on Map */
        @keyframes bpbd-radar-ping {
            0% {
                transform: scale(0.9);
                box-shadow: 0 0 0 0 rgba(234, 88, 12, 0.75);
            }
            70% {
                transform: scale(1.15);
                box-shadow: 0 0 0 16px rgba(234, 88, 12, 0);
            }
            100% {
                transform: scale(0.9);
                box-shadow: 0 0 0 0 rgba(234, 88, 12, 0);
            }
        }
        .radar-pulse-dot {
            position: relative;
            border-radius: 9999px;
            animation: bpbd-radar-ping 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* 3. Floating SOS Button Glow */
        @keyframes sos-glow-pulse {
            0%, 100% {
                box-shadow: 0 0 20px -3px rgba(234, 88, 12, 0.6), 0 0 35px -5px rgba(239, 68, 68, 0.4);
            }
            50% {
                box-shadow: 0 0 32px 5px rgba(234, 88, 12, 0.9), 0 0 55px 3px rgba(239, 68, 68, 0.6);
            }
        }
        .animate-sos-glow {
            animation: sos-glow-pulse 2.2s infinite ease-in-out;
        }

        /* 4. Smooth Slider Progress Bar */
        @keyframes slider-progress {
            0% { width: 0%; }
            100% { width: 100%; }
        }
        .slider-progress-bar {
            animation: slider-progress 6s linear infinite;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased w-full max-w-full overflow-x-hidden selection:bg-orange-500 selection:text-white" x-data="{
    mobileMenu: false,
    sosModal: false,
    currentSlide: 0,
    totalSlides: 3,
    timer: null,
    activeCategory: 'all',
    init() {
        this.startAutoplay();
    },
    startAutoplay() {
        if (this.timer) clearInterval(this.timer);
        this.timer = setInterval(() => {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        }, 6000);
    },
    setSlide(index) {
        this.currentSlide = index;
        this.startAutoplay();
    },
    nextSlide() {
        this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        this.startAutoplay();
    },
    prevSlide() {
        this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        this.startAutoplay();
    }
}">

    <!-- ================= 1. RUNNING TEXT MARQUEE (BREAKING NEWS / PERINGATAN DINI) ================= -->
    <div class="bg-slate-950 text-white border-b border-slate-800 overflow-hidden relative z-40">
        <div class="flex items-center">
            <!-- Badge Kiri Statis -->
            <div class="bg-gradient-to-r from-orange-600 to-amber-600 text-white font-extrabold text-[10px] sm:text-[11px] uppercase tracking-wider px-2.5 sm:px-4 py-2 flex items-center gap-1.5 sm:gap-2 flex-shrink-0 z-10 shadow-md">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                </span>
                <span>INFO SIAGA<span class="hidden sm:inline"> &amp; PERINGATAN DINI</span></span>
            </div>

            <!-- Ticker Berjalan -->
            <div class="overflow-hidden flex-1 py-1.5 cursor-default">
                <div class="animate-bpbd-marquee flex items-center text-xs text-slate-300 font-medium">
                    <span class="mx-6 flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded bg-orange-500/20 text-orange-400 font-bold border border-orange-500/30 text-[10px]">BMKG RIAU</span>
                        Waspada potensi hujan sedang hingga lebat disertai kilat/petir dan angin kencang di wilayah Kota Pekanbaru dan sekitarnya.
                    </span>
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <span class="mx-6 flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded bg-rose-500/20 text-rose-400 font-bold border border-rose-500/30 text-[10px]">SIAGA KARHUTLA</span>
                        Posko Satgas Terpadu Karhutla Riau & Pekanbaru melakukan patroli darat harian dan ground-check hotspot berkala.
                    </span>
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <span class="mx-6 flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 font-bold border border-emerald-500/30 text-[10px]">CALL CENTER 112</span>
                        Layanan kedaruratan bebas pulsa 24 jam Pemerintah Kota Pekanbaru siap melayani laporan bencana & evakuasi.
                    </span>
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <span class="mx-6 flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded bg-blue-500/20 text-blue-400 font-bold border border-blue-500/30 text-[10px]">PUSDALOPS-PB</span>
                        Sistem pelaporan Satu Data Bencana Pekanbaru terintegrasi standar DIBI BNPB Republik Indonesia.
                    </span>
                    <!-- Duplikasi Teks untuk Infinite Seamless Loop -->
                    <span class="mx-6 flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded bg-orange-500/20 text-orange-400 font-bold border border-orange-500/30 text-[10px]">BMKG RIAU</span>
                        Waspada potensi hujan sedang hingga lebat disertai kilat/petir dan angin kencang di wilayah Kota Pekanbaru dan sekitarnya.
                    </span>
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <span class="mx-6 flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded bg-rose-500/20 text-rose-400 font-bold border border-rose-500/30 text-[10px]">SIAGA KARHUTLA</span>
                        Posko Satgas Terpadu Karhutla Riau & Pekanbaru melakukan patroli darat harian dan ground-check hotspot berkala.
                    </span>
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <span class="mx-6 flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 font-bold border border-emerald-500/30 text-[10px]">CALL CENTER 112</span>
                        Layanan kedaruratan bebas pulsa 24 jam Pemerintah Kota Pekanbaru siap melayani laporan bencana & evakuasi.
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= 2. NAVBAR RESMI PEMERINTAH (PRESTIGIOUS DEEP NAVY BPBD RIAU STYLE) ================= -->
    <header class="sticky top-0 z-30 bg-slate-950/95 backdrop-blur-md border-b border-slate-800 shadow-md text-white">
        <div class="max-w-7xl mx-auto px-3.5 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20 gap-2">
                
                <!-- Logo & Identitas Resmi BPBD -->
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 sm:gap-3.5 group min-w-0">
                    <img src="{{ asset('images/logo-bpbd.png') }}" alt="Logo BPBD" class="w-10 h-10 sm:w-12 sm:h-12 object-contain rounded-full ring-2 ring-orange-500/30 group-hover:ring-orange-500/70 group-hover:scale-105 transition-all duration-200 shrink-0">
                    <div class="min-w-0">
                        <div class="text-[9px] sm:text-[10px] font-extrabold uppercase tracking-wider text-orange-400 leading-none truncate">
                            PEMERINTAH KOTA PEKANBARU
                        </div>
                        <h1 class="text-sm sm:text-xl font-black text-white tracking-tight leading-tight group-hover:text-orange-400 transition-colors truncate">
                            BPBD KOTA PEKANBARU
                        </h1>
                        <p class="text-[10px] sm:text-[11px] font-medium text-slate-400 leading-none mt-0.5 truncate">
                            <span class="sm:hidden">PUSDALOPS-PB Kota Pekanbaru</span>
                            <span class="hidden sm:inline">Pusat Pengendalian Operasi Penanggulangan Bencana (PUSDALOPS-PB)</span>
                        </p>
                    </div>
                </a>

                <!-- Navigasi Desktop -->
                <nav class="hidden lg:flex items-center gap-5">
                    <a href="#beranda" class="text-xs font-bold text-slate-300 hover:text-orange-400 transition-colors uppercase tracking-wider">
                        Beranda
                    </a>
                    <a href="#statistik" class="text-xs font-bold text-slate-300 hover:text-orange-400 transition-colors uppercase tracking-wider">
                        Data &amp; Statistik
                    </a>
                    <a href="#geoportal" class="text-xs font-bold text-slate-300 hover:text-orange-400 transition-colors uppercase tracking-wider flex items-center gap-1.5">
                        <span>Peta Geoportal</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-ping"></span>
                    </a>
                    <a href="#laporan-terkini" class="text-xs font-bold text-slate-300 hover:text-orange-400 transition-colors uppercase tracking-wider">
                        Laporan Terkini
                    </a>
                    <a href="#layanan" class="text-xs font-bold text-slate-300 hover:text-orange-400 transition-colors uppercase tracking-wider">
                        Layanan 112
                    </a>
                </nav>

                <!-- Tombol Masuk Petugas / Dashboard -->
                <div class="hidden sm:flex items-center gap-3 shrink-0">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-bold text-xs uppercase tracking-wider shadow-md shadow-orange-500/20 hover:shadow-lg transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard Petugas</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-bold text-xs uppercase tracking-wider shadow-md shadow-orange-500/20 hover:shadow-lg hover:shadow-orange-500/30 hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            <span>Masuk Petugas TRC</span>
                        </a>
                    @endauth
                </div>

                <!-- Hamburger Button Mobile -->
                <button type="button" @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 focus:outline-none shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        <!-- Menu Dropdown Mobile -->
        <div x-show="mobileMenu" x-cloak class="lg:hidden border-t border-slate-800 bg-slate-950 px-4 pt-3 pb-5 space-y-1.5 shadow-2xl text-white">
            <a href="#beranda" @click="mobileMenu = false" class="block px-3 py-2.5 rounded-xl text-xs font-bold text-slate-200 hover:bg-slate-800 hover:text-orange-400">Beranda Utama</a>
            <a href="#statistik" @click="mobileMenu = false" class="block px-3 py-2.5 rounded-xl text-xs font-bold text-slate-200 hover:bg-slate-800 hover:text-orange-400">Data &amp; Statistik Bencana</a>
            <a href="#geoportal" @click="mobileMenu = false" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold text-slate-200 hover:bg-slate-800 hover:text-orange-400">
                <span>Peta Geoportal Spasial</span>
                <span class="w-2 h-2 rounded-full bg-orange-500 animate-ping"></span>
            </a>
            <a href="#laporan-terkini" @click="mobileMenu = false" class="block px-3 py-2.5 rounded-xl text-xs font-bold text-slate-200 hover:bg-slate-800 hover:text-orange-400">Laporan Kejadian Terkini</a>
            <a href="#layanan" @click="mobileMenu = false" class="block px-3 py-2.5 rounded-xl text-xs font-bold text-slate-200 hover:bg-slate-800 hover:text-orange-400">Layanan Darurat Call 112</a>
            <div class="pt-3 mt-2 border-t border-slate-800">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full text-center py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold text-xs uppercase tracking-wider block shadow-md">Buka Dashboard Petugas</a>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold text-xs uppercase tracking-wider block shadow-md">Masuk Petugas TRC</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- ================= 3. DYNAMIC HERO CAROUSEL / SLIDER (GERAK-GERAK BANNER UTAMA) ================= -->
    <section id="beranda" class="relative overflow-hidden bg-slate-950 text-white min-h-[540px] sm:min-h-[600px] lg:min-h-[650px] flex items-center">
        
        <!-- Ambient Grid Background -->
        <div class="absolute inset-0 pointer-events-none opacity-20" style="background-image: radial-gradient(rgba(234, 88, 12, 0.4) 1px, transparent 1px); background-size: 28px 28px;"></div>
        <div class="absolute -top-32 -right-32 w-[500px] h-[500px] bg-orange-600/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -left-32 w-[500px] h-[500px] bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>

        <!-- SLIDE 1: Kesiapsiagaan TRC & Pusdalops -->
        <div class="absolute inset-0 w-full h-full flex items-center transition-all duration-700 ease-in-out"
             :class="currentSlide === 0 ? 'opacity-100 translate-x-0 z-10 pointer-events-auto' : 'opacity-0 translate-x-12 z-0 pointer-events-none'">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-8 pb-16 sm:py-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    <div class="lg:col-span-8">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-orange-500/15 text-orange-400 border border-orange-500/30 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-3 sm:mb-4">
                            <span class="w-2 h-2 rounded-full bg-orange-400 animate-ping"></span>
                            <span>SIAGA PENUH 24/7 PUSDALOPS-PB</span>
                        </div>
                        <h2 class="text-2xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
                            TANGGAP, TANGKAS, &amp; TANGGUH MENGHADAPI BENCANA
                        </h2>
                        <p class="mt-3 sm:mt-4 text-xs sm:text-base text-slate-300 max-w-2xl leading-relaxed">
                            Badan Penanggulangan Bencana Daerah (BPBD) Kota Pekanbaru bersiaga penuh melindungi masyarakat melalui posko komando terpadu, pemantauan spasial, dan respon cepat Tim Reaksi Cepat (TRC).
                        </p>
                        <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center gap-3">
                            <a href="#geoportal" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-extrabold text-xs uppercase tracking-wider shadow-lg shadow-orange-500/30 hover:scale-105 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                <span>Jelajahi Peta Geoportal</span>
                            </a>
                            <button type="button" @click="sosModal = true" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-slate-900/80 hover:bg-slate-800 text-white font-extrabold text-xs uppercase tracking-wider border border-white/20 hover:border-white/40 shadow-sm transition-all duration-200 cursor-pointer">
                                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span>Hubungi Call Center 112</span>
                            </button>
                        </div>
                    </div>
                    <div class="lg:col-span-4 hidden lg:flex justify-center">
                        <div class="bg-gradient-to-br from-slate-900/95 to-slate-950/95 backdrop-blur-md p-6 rounded-3xl border border-orange-500/30 shadow-2xl max-w-sm w-full">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[11px] font-bold text-orange-400 uppercase tracking-wider">Status Operasi TRC</span>
                                <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-[10px] font-black border border-emerald-500/40">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                    SIAGA 1 AKTIF
                                </span>
                            </div>
                            <div class="text-3xl font-black text-white">{{ $totalPersonelTRC > 0 ? $totalPersonelTRC : 45 }} <span class="text-sm font-normal text-slate-400">Personel</span></div>
                            <p class="text-xs text-slate-300 mt-1">Siaga di Posko Induk TRC BPBD Kota Pekanbaru (3 Shift Operasional).</p>
                            <div class="mt-4 pt-4 border-t border-slate-800 space-y-2 text-xs">
                                <div class="flex justify-between text-slate-300">
                                    <span>Pusat Data:</span>
                                    <span class="font-bold text-white">PUSDALOPS-PB</span>
                                </div>
                                <div class="flex justify-between text-slate-300">
                                    <span>Waktu Respon:</span>
                                    <span class="font-bold text-orange-400">&le; 15 Menit TRC</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SLIDE 2: Patroli Terpadu Karhutla Riau -->
        <div class="absolute inset-0 w-full h-full flex items-center transition-all duration-700 ease-in-out"
             :class="currentSlide === 1 ? 'opacity-100 translate-x-0 z-10 pointer-events-auto' : 'opacity-0 translate-x-12 z-0 pointer-events-none'">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-8 pb-16 sm:py-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    <div class="lg:col-span-8">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-rose-500/15 text-rose-400 border border-rose-500/30 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-3 sm:mb-4">
                            <span class="w-2 h-2 rounded-full bg-rose-400 animate-ping"></span>
                            <span>SATGAS TERPADU KARHUTLA RIAU</span>
                        </div>
                        <h2 class="text-2xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
                            PATROLI GEOSPASIAL &amp; PENCEGAHAN KARHUTLA
                        </h2>
                        <p class="mt-3 sm:mt-4 text-xs sm:text-base text-slate-300 max-w-2xl leading-relaxed">
                            Pencegahan dan pengendalian kebakaran hutan dan lahan secara terpadu melalui verifikasi titik panas (hotspot), pembasahan embung, dan respon pemadaman darat di 15 kecamatan Kota Pekanbaru.
                        </p>
                        <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center gap-3">
                            <a href="#geoportal" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-rose-500 to-orange-500 hover:from-rose-600 hover:to-orange-600 text-white font-extrabold text-xs uppercase tracking-wider shadow-lg shadow-rose-500/30 hover:scale-105 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Pantau Titik Kejadian</span>
                            </a>
                            <a href="#statistik" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-slate-900/80 hover:bg-slate-800 text-white font-extrabold text-xs uppercase tracking-wider border border-white/20 hover:border-white/40 shadow-sm transition-all duration-200">
                                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                <span>Rekapitulasi Luas Pemadaman</span>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-4 hidden lg:flex justify-center">
                        <div class="bg-gradient-to-br from-slate-900/95 to-slate-950/95 backdrop-blur-md p-6 rounded-3xl border border-rose-500/30 shadow-2xl max-w-sm w-full">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[11px] font-bold text-rose-400 uppercase tracking-wider">Satgas Karhutla Kota</span>
                                <span class="px-2 py-0.5 rounded bg-rose-500/20 text-rose-300 text-[10px] font-bold border border-rose-500/40">Gambut Riau</span>
                            </div>
                            <div class="text-3xl font-black text-white">{{ number_format($totalLuasKarhutla, 1, ',', '.') }} <span class="text-sm font-normal text-slate-400">Hektar</span></div>
                            <p class="text-xs text-slate-300 mt-1">Total area terbakar tertangani dan berhasil dipadamkan Tim Reaksi Cepat.</p>
                            <div class="mt-4 pt-4 border-t border-slate-800 space-y-2 text-xs">
                                <div class="flex justify-between text-slate-300">
                                    <span>Lokasi Terkendali:</span>
                                    <span class="font-bold text-emerald-400">{{ $totalKarhutla }} Titik</span>
                                </div>
                                <div class="flex justify-between text-slate-300">
                                    <span>Patroli Darat:</span>
                                    <span class="font-bold text-rose-400">Rutin Tiap Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SLIDE 3: Satu Data Bencana & Standar DIBI BNPB -->
        <div class="absolute inset-0 w-full h-full flex items-center transition-all duration-700 ease-in-out"
             :class="currentSlide === 2 ? 'opacity-100 translate-x-0 z-10 pointer-events-auto' : 'opacity-0 translate-x-12 z-0 pointer-events-none'">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-8 pb-16 sm:py-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    <div class="lg:col-span-8">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-500/15 text-blue-400 border border-blue-500/30 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-3 sm:mb-4">
                            <span class="w-2 h-2 rounded-full bg-blue-400 animate-ping"></span>
                            <span>STANDARISASI DATA DIBI BNPB</span>
                        </div>
                        <h2 class="text-2xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
                            PORTAL SATU DATA BENCANA &amp; DOKUMEN RESMI
                        </h2>
                        <p class="mt-3 sm:mt-4 text-xs sm:text-base text-slate-300 max-w-2xl leading-relaxed">
                            Integrasi pencatatan kejadian bencana, dampak kerusakan infrastruktur, pengungsian korban jiwa, serta penerbitan format berita acara resmi penanggulangan bencana daerah.
                        </p>
                        <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center gap-3">
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider shadow-lg shadow-blue-500/30 hover:scale-105 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    <span>Buka Dashboard Petugas</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider shadow-lg shadow-blue-500/30 hover:scale-105 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                    <span>Masuk ke Sistem Pusdalops</span>
                                </a>
                            @endauth
                            <a href="#geoportal" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-slate-900/80 hover:bg-slate-800 text-white font-extrabold text-xs uppercase tracking-wider border border-white/20 hover:border-white/40 shadow-sm transition-all duration-200">
                                <span>Lihat Peta Sebaran Spasial</span>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-4 hidden lg:flex justify-center">
                        <div class="bg-gradient-to-br from-slate-900/95 to-slate-950/95 backdrop-blur-md p-6 rounded-3xl border border-blue-500/30 shadow-2xl max-w-sm w-full">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[11px] font-bold text-blue-400 uppercase tracking-wider">Total Terdata</span>
                                <span class="px-2 py-0.5 rounded bg-blue-500/20 text-blue-300 text-[10px] font-bold border border-blue-500/40">15 Kecamatan</span>
                            </div>
                            <div class="text-3xl font-black text-white">{{ $totalKejadian }} <span class="text-sm font-normal text-slate-400">Laporan</span></div>
                            <p class="text-xs text-slate-300 mt-1">Tersebar di 15 Kecamatan dan terdokumentasi lengkap dalam basis data geospasial.</p>
                            <div class="mt-4 pt-4 border-t border-slate-800 space-y-2 text-xs">
                                <div class="flex justify-between text-slate-300">
                                    <span>Status Selesai:</span>
                                    <span class="font-bold text-emerald-400">{{ $totalSelesai }} Kejadian</span>
                                </div>
                                <div class="flex justify-between text-slate-300">
                                    <span>Format Cetak:</span>
                                    <span class="font-bold text-blue-400">Standar DIBI BNPB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigasi Panah Slider (Kiri & Kanan - Desktop Only agar tidak menutupi teks di HP) -->
        <button type="button" @click="prevSlide()" class="hidden md:flex absolute left-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-slate-900/70 hover:bg-slate-900 text-white border border-white/20 items-center justify-center transition-all duration-200 hover:scale-110 cursor-pointer shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button type="button" @click="nextSlide()" class="hidden md:flex absolute right-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-slate-900/70 hover:bg-slate-900 text-white border border-white/20 items-center justify-center transition-all duration-200 hover:scale-110 cursor-pointer shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </button>

        <!-- Indikator Dots & Tombol Geser Mobile di Bawah Slider -->
        <div class="absolute bottom-5 left-0 right-0 z-20 flex items-center justify-center gap-4">
            <button type="button" @click="prevSlide()" class="md:hidden w-8 h-8 rounded-full bg-slate-900/80 text-white border border-white/20 flex items-center justify-center active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <div class="flex items-center gap-2.5">
                <button type="button" @click="setSlide(0)" class="h-2 rounded-full transition-all duration-300 cursor-pointer" :class="currentSlide === 0 ? 'w-8 bg-orange-500' : 'w-2.5 bg-slate-600 hover:bg-slate-400'"></button>
                <button type="button" @click="setSlide(1)" class="h-2 rounded-full transition-all duration-300 cursor-pointer" :class="currentSlide === 1 ? 'w-8 bg-rose-500' : 'w-2.5 bg-slate-600 hover:bg-slate-400'"></button>
                <button type="button" @click="setSlide(2)" class="h-2 rounded-full transition-all duration-300 cursor-pointer" :class="currentSlide === 2 ? 'w-8 bg-blue-500' : 'w-2.5 bg-slate-600 hover:bg-slate-400'"></button>
            </div>
            <button type="button" @click="nextSlide()" class="md:hidden w-8 h-8 rounded-full bg-slate-900/80 text-white border border-white/20 flex items-center justify-center active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>

        <!-- Garis Countdown Timer di Ujung Bawah Slider -->
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-slate-900 z-20">
            <div class="h-full bg-gradient-to-r from-orange-500 via-amber-400 to-rose-500 slider-progress-bar" :key="currentSlide"></div>
        </div>
    </section>

    <!-- ================= 4. METRIK & STATISTIK DENGAN COUNT-UP ANIMATION ("GERAK ANGKA BERPUTAR") ================= -->
    <section id="statistik" class="py-12 bg-white border-b border-slate-200 relative -mt-6 rounded-t-3xl shadow-lg z-20" x-data="{
        counted: false,
        k1: 0, k2: 0, k3: 0, k4: 0, k5: 0, k6: 0,
        t1: {{ $totalKejadian }},
        t2: {{ $totalKarhutla }},
        t3: {{ $totalBanjir }},
        t4: {{ (int) $totalLuasKarhutla }},
        t5: {{ (int) $totalJiwaTerdampak }},
        t6: {{ $totalPersonelTRC > 0 ? $totalPersonelTRC : 45 }},
        animateCounters() {
            if (this.counted) return;
            this.counted = true;
            let duration = 1600;
            let steps = 40;
            let stepTime = duration / steps;
            let i = 0;
            let timer = setInterval(() => {
                i++;
                let factor = i / steps;
                this.k1 = Math.round(this.t1 * factor);
                this.k2 = Math.round(this.t2 * factor);
                this.k3 = Math.round(this.t3 * factor);
                this.k4 = Math.round(this.t4 * factor);
                this.k5 = Math.round(this.t5 * factor);
                this.k6 = Math.round(this.t6 * factor);
                if (i >= steps) {
                    this.k1 = this.t1;
                    this.k2 = this.t2;
                    this.k3 = this.t3;
                    this.k4 = this.t4;
                    this.k5 = this.t5;
                    this.k6 = this.t6;
                    clearInterval(timer);
                }
            }, stepTime);
        }
    }" x-init="setTimeout(() => { animateCounters() }, 200)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-100 text-orange-700 font-extrabold text-[11px] uppercase tracking-wider mb-2">
                    REKAPITULASI RESMI PUSDALOPS-PB
                </span>
                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Statistik Kesiapsiagaan &amp; Penanganan Bencana
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 mt-2">
                    Akumulasi data kejadian bencana, penanganan lapangan, dan dampak masyarakat di wilayah Kota Pekanbaru.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3.5 sm:gap-4">
                
                <!-- 1. Total Kejadian -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-orange-500 to-amber-500"></div>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-orange-500/10 text-orange-600 flex items-center justify-center mb-3 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight" x-text="k1">{{ $totalKejadian }}</div>
                    <div class="text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mt-1">Total Kejadian</div>
                    <div class="text-[10px] sm:text-[11px] text-slate-400 mt-0.5">Semua Jenis Bencana</div>
                </div>

                <!-- 2. Karhutla -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-rose-600 to-red-600"></div>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-rose-500/10 text-rose-600 flex items-center justify-center mb-3 group-hover:bg-rose-500 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
                    </div>
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight" x-text="k2">{{ $totalKarhutla }}</div>
                    <div class="text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mt-1">Kebakaran Lahan</div>
                    <div class="text-[10px] sm:text-[11px] text-emerald-600 font-semibold mt-0.5">Padam &amp; Terkendali</div>
                </div>

                <!-- 3. Banjir -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-600 to-indigo-600"></div>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-blue-500/10 text-blue-600 flex items-center justify-center mb-3 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    </div>
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight" x-text="k3">{{ $totalBanjir }}</div>
                    <div class="text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mt-1">Banjir &amp; Genangan</div>
                    <div class="text-[10px] sm:text-[11px] text-slate-400 mt-0.5">Titik Genangan</div>
                </div>

                <!-- 4. Luas Pemadaman -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-amber-500 to-orange-500"></div>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center mb-3 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    </div>
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight"><span x-text="k4">{{ (int) $totalLuasKarhutla }}</span> <span class="text-xs font-normal text-slate-500">Ha</span></div>
                    <div class="text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mt-1">Luas Pemadaman</div>
                    <div class="text-[10px] sm:text-[11px] text-slate-400 mt-0.5">Lahan Karhutla</div>
                </div>

                <!-- 5. Jiwa Terdampak -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-purple-600 to-indigo-600"></div>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-purple-500/10 text-purple-600 flex items-center justify-center mb-3 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight" x-text="k5">{{ $totalJiwaTerdampak }}</div>
                    <div class="text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mt-1">Jiwa Terdampak</div>
                    <div class="text-[10px] sm:text-[11px] text-emerald-600 font-semibold mt-0.5">Tertolong &amp; Aman</div>
                </div>

                <!-- 6. Personel TRC Siaga -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-500 to-teal-600"></div>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center mb-3 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight" x-text="k6">{{ $totalPersonelTRC > 0 ? $totalPersonelTRC : 45 }}</div>
                    <div class="text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mt-1">Personel TRC</div>
                    <div class="text-[10px] sm:text-[11px] text-emerald-600 font-semibold mt-0.5">Siaga Posko 24 Jam</div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================= 5. INTERACTIVE GEOPORTAL MAP (PETA SPASIAL DENGAN RADAR PULSE MARKER) ================= -->
    <section id="geoportal" class="py-16 bg-slate-900 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-500/15 text-orange-400 border border-orange-500/30 text-xs font-bold uppercase tracking-wider mb-2">
                        <span class="w-2 h-2 rounded-full bg-orange-400 animate-ping"></span>
                        <span>GEOPORTAL SPASIAL KEBENCANAAN</span>
                    </div>
                    <h3 class="text-2xl sm:text-4xl font-black tracking-tight text-white">
                        Peta Sebaran Titik Kejadian Bencana
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-400 mt-1 max-w-2xl">
                        Visualisasi pemetaan titik koordinat kejadian bencana di 15 Kecamatan Kota Pekanbaru. Marker berkedip menandakan penanganan aktif di lapangan.
                    </p>
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-xs text-slate-300">
                        <span class="w-2.5 h-2.5 rounded-full bg-orange-500 radar-pulse-dot"></span>
                        <span>Dalam Penanganan</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-xs text-slate-300">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span>Selesai / Terkendali</span>
                    </span>
                </div>
            </div>

            <!-- Filter Kategori Layer Peta Interaktif & Basemap Switcher -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                <div class="flex items-center gap-2 overflow-x-auto pb-1">
                    <button type="button" 
                            onclick="filterPublicCategory('all')" 
                            id="filterPublic_all"
                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-orange-600 text-white shadow-md transition-all cursor-pointer whitespace-nowrap">
                        Semua Bencana
                    </button>
                    @foreach($semuaJenisKejadian as $jk)
                        <button type="button" 
                                onclick="filterPublicCategory({{ $jk->id }})" 
                                id="filterPublic_{{ $jk->id }}"
                                class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 transition-all cursor-pointer whitespace-nowrap">
                            {{ $jk->nama }}
                        </button>
                    @endforeach
                </div>

                <!-- Basemap Switcher (Jalan / Satelit) -->
                <div class="inline-flex rounded-xl bg-slate-800 p-1 border border-slate-700 text-xs shrink-0 self-start sm:self-auto">
                    <button type="button" onclick="switchPublicBasemap('osm')" id="btnPubBasemapOsm" class="px-3 py-1 rounded-lg font-bold bg-gradient-to-r from-orange-500 to-amber-500 text-white transition-all shadow-xs">
                        Peta Jalan
                    </button>
                    <button type="button" onclick="switchPublicBasemap('satellite')" id="btnPubBasemapSat" class="px-3 py-1 rounded-lg font-semibold text-slate-400 hover:text-white hover:bg-slate-700/60 transition-all">
                        Citra Satelit
                    </button>
                    <button type="button" onclick="switchPublicBasemap('topo')" id="btnPubBasemapTopo" class="px-3 py-1 rounded-lg font-semibold text-slate-400 hover:text-white hover:bg-slate-700/60 transition-all">
                        Topografi
                    </button>
                </div>
            </div>

            <!-- Wadah Peta Leaflet -->
            <div class="bg-slate-950 rounded-3xl p-2 sm:p-3 border border-slate-800 shadow-2xl relative">
                <div id="map-public" class="w-full h-[340px] sm:h-[460px] lg:h-[520px] rounded-2xl z-10"></div>
                <div class="absolute bottom-6 right-6 z-20 hidden sm:block bg-slate-900/90 backdrop-blur-md px-4 py-2.5 rounded-xl border border-white/10 text-xs text-slate-300 shadow-lg">
                    Sistem Koordinat WGS84 &bull; PUSDALOPS-PB Kota Pekanbaru
                </div>
            </div>

        </div>
    </section>

    <!-- ================= 6. LAPORAN KEJADIAN TERKINI (LIVE FEED CARDS) ================= -->
    <section id="laporan-terkini" class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-100 text-orange-700 font-extrabold text-[11px] uppercase tracking-wider mb-2">
                        LAPORAN PUSDALOPS
                    </span>
                    <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Kejadian &amp; Penanganan Terkini
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1">
                        Informasi pencatatan kejadian terbaru yang dilaporkan dan ditangani oleh TRC BPBD Kota Pekanbaru.
                    </p>
                </div>
                <div>
                    @auth
                        <a href="{{ route('kejadian.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-orange-600 hover:text-orange-700 uppercase tracking-wider">
                            <span>Lihat Seluruh Laporan</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs font-bold text-orange-600 hover:text-orange-700 uppercase tracking-wider">
                            <span>Masuk untuk Seluruh Data</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Grid Kartu Kejadian Terbaru -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($kejadianTerbaru as $item)
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border"
                                      style="background-color: {{ ($item->jenisKejadian->warna ?? '#EA580C') }}15; color: {{ ($item->jenisKejadian->warna ?? '#EA580C') }}; border-color: {{ ($item->jenisKejadian->warna ?? '#EA580C') }}35;">
                                    {{ $item->jenisKejadian ? $item->jenisKejadian->nama : 'Bencana' }}
                                </span>
                                @if($item->status === 'Dalam Penanganan')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-bold uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span>
                                        <span>Proses TRC</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold uppercase tracking-wider">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span>Selesai</span>
                                    </span>
                                @endif
                            </div>

                            <h4 class="text-base font-bold text-slate-900 group-hover:text-orange-600 transition-colors line-clamp-1">
                                {{ $item->lokasi_detail }}
                            </h4>
                            <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>{{ $item->kelurahan ? $item->kelurahan->nama_kelurahan : '-' }}, Kec. {{ $item->kecamatan ? $item->kecamatan->nama_kecamatan : '-' }}</span>
                            </p>

                            <p class="text-xs text-slate-600 mt-3 line-clamp-2 leading-relaxed bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                {{ $item->kronologi ?? 'Operasi tanggap darurat dan penanganan langsung di lokasi kejadian oleh personel Tim Reaksi Cepat.' }}
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500 font-medium">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>{{ \Carbon\Carbon::parse($item->tanggal_kejadian)->locale('id')->isoFormat('D MMMM Y') }}</span>
                            </span>
                            <span class="font-mono text-slate-400">
                                {{ $item->jam_kejadian ? substr($item->jam_kejadian, 0, 5) . ' WIB' : '' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 bg-white rounded-3xl border border-slate-200">
                        <p class="text-sm text-slate-500 font-semibold">Belum ada catatan kejadian terbaru yang tersimpan.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <!-- ================= 7. LAYANAN KEDARURATAN 112 & MITIGASI ================= -->
    <section id="layanan" class="py-16 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 rounded-3xl p-8 sm:p-12 text-white shadow-2xl relative overflow-hidden border border-slate-800">
                <div class="absolute -right-12 -bottom-12 w-80 h-80 bg-orange-500/15 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-8">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-500/20 text-orange-400 border border-orange-500/40 text-xs font-bold uppercase tracking-wider mb-4">
                            <span>BEBAS PULSA &bull; 24 JAM STANDBY</span>
                        </div>
                        <h3 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                            Layanan Kedaruratan Terpadu Call Center 112
                        </h3>
                        <p class="mt-3 text-sm sm:text-base text-slate-300 leading-relaxed max-w-2xl">
                            Masyarakat Kota Pekanbaru dapat langsung menghubungi Call Center 112 tanpa dipungut biaya pulsa untuk melaporkan kebakaran, bencana banjir, pohon tumbang, serta evakuasi darurat.
                        </p>

                        <div class="mt-6 flex flex-wrap items-center gap-4">
                            <a href="tel:112" class="inline-flex items-center gap-3 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-black text-base uppercase tracking-wider shadow-lg shadow-orange-500/30 hover:scale-105 transition-all duration-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span>PANGGIL 112 SEKARANG</span>
                            </a>
                            <a href="https://wa.me/628117604800" target="_blank" class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider shadow-md hover:shadow-lg transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                <span>WhatsApp Pusdalops (0811-7604-800)</span>
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-4 bg-slate-900/80 backdrop-blur-md rounded-2xl p-6 border border-white/10">
                        <div class="text-xs font-bold text-orange-400 uppercase tracking-wider mb-3">
                            Posko Utama BPBD
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            {{ $pengaturan->alamat ?? 'Jl. Mustafa Sari No. 1, Tangkerang Selatan, Kec. Bukit Raya, Kota Pekanbaru, Riau' }}
                        </p>
                        <div class="mt-4 pt-4 border-t border-slate-800 space-y-2 text-xs text-slate-400">
                            <div><span class="text-white font-semibold">Email Dinas:</span> {{ $pengaturan->email ?? 'bpbd@pekanbaru.go.id' }}</div>
                            <div><span class="text-white font-semibold">Waktu Operasional:</span> 24 Jam Non-Stop (3 Shift TRC)</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ================= 8. FOOTER RESMI ================= -->
    <footer class="bg-slate-950 text-white border-t border-slate-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-8">
                
                <div class="md:col-span-6">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo-bpbd.png') }}" alt="Logo BPBD" class="w-12 h-12 rounded-full object-contain">
                        <div>
                            <div class="text-xs font-black tracking-wide text-white uppercase">
                                BADAN PENANGGULANGAN BENCANA DAERAH
                            </div>
                            <div class="text-[11px] text-orange-400 font-semibold uppercase">
                                PEMERINTAH KOTA PEKANBARU &bull; PROVINSI RIAU
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-lg">
                        Sistem informasi dan pemantauan penanggulangan bencana terintegrasi untuk percepatan respon evakuasi, rekapitulasi data akurat, dan pelayanan tanggap darurat bagi masyarakat Kota Pekanbaru.
                    </p>
                </div>

                <div class="md:col-span-3">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-orange-400 mb-3">Tautan Terkait</h5>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="https://bpbd.riau.go.id" target="_blank" class="hover:text-white transition-colors">BPBD Provinsi Riau</a></li>
                        <li><a href="https://bnpb.go.id" target="_blank" class="hover:text-white transition-colors">BNPB Republik Indonesia</a></li>
                        <li><a href="https://bmkg.go.id" target="_blank" class="hover:text-white transition-colors">BMKG Stasiun Pekanbaru</a></li>
                        <li><a href="https://pekanbaru.go.id" target="_blank" class="hover:text-white transition-colors">Portal Pemko Pekanbaru</a></li>
                    </ul>
                </div>

                <div class="md:col-span-3">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-orange-400 mb-3">Akses Petugas</h5>
                    <p class="text-xs text-slate-400 mb-3">Portal otorisasi bagi Petugas TRC, Admin IT, dan Pimpinan Instansi.</p>
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs uppercase tracking-wider border border-white/15">
                            <span>Buka Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs uppercase tracking-wider shadow-sm">
                            <span>Masuk ke Sistem</span>
                        </a>
                    @endauth
                </div>

            </div>

            <div class="pt-8 border-t border-slate-900 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <div>
                    &copy; {{ date('Y') }} BPBD Kota Pekanbaru. Seluruh Hak Cipta Dilindungi Undang-Undang.
                </div>
                <div class="flex items-center gap-4">
                    <span>Versi Portal Satu Data 2.0</span>
                    <span>&bull;</span>
                    <span>Standar DIBI BNPB</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- ================= 9. FLOATING SOS PULSE WIDGET ("GERAK RADAR TOMBOL MENGAPUNG") ================= -->
    <div class="fixed bottom-6 right-6 z-50">
        <button type="button" 
                @click="sosModal = true" 
                class="relative group flex items-center gap-2.5 px-4 py-3 rounded-full bg-gradient-to-r from-orange-600 via-rose-600 to-red-600 text-white shadow-2xl animate-sos-glow hover:scale-105 active:scale-95 transition-all duration-300 cursor-pointer border border-white/20">
            
            <!-- Concentric Pulsing Wave Rings -->
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-80"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
            </span>
            
            <!-- Phone Icon -->
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            
            <span class="text-xs font-black uppercase tracking-wider pr-1">CALL 112</span>
        </button>
    </div>

    <!-- ================= 10. MODAL EMERGENCY SOS ================= -->
    <div x-show="sosModal" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative overflow-hidden" 
             @click.away="sosModal = false">
            <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-orange-500 via-rose-500 to-amber-500"></div>

            <div class="text-center mb-6">
                <div class="w-16 h-16 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-3 border border-rose-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <h4 class="text-xl font-black text-slate-900 tracking-tight">KONTAK DARURAT BPBD</h4>
                <p class="text-xs text-slate-500 mt-1">Pilih jalur komunikasi cepat untuk respon darurat Tim Reaksi Cepat.</p>
            </div>

            <div class="space-y-3">
                <a href="tel:112" class="w-full flex items-center justify-between p-4 rounded-2xl bg-gradient-to-r from-orange-500 to-rose-600 text-white font-black text-sm uppercase tracking-wider shadow-lg hover:shadow-xl transition-all">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>Call Center 112 (Bebas Pulsa)</span>
                    </div>
                    <span class="text-xs bg-white/20 px-2.5 py-1 rounded-lg">24 Jam</span>
                </a>

                <a href="https://wa.me/628117604800" target="_blank" class="w-full flex items-center justify-between p-4 rounded-2xl bg-emerald-600 text-white font-black text-sm uppercase tracking-wider hover:bg-emerald-700 transition-all">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <span>WhatsApp Pusdalops (0811-7604-800)</span>
                    </div>
                    <span class="text-xs bg-white/20 px-2.5 py-1 rounded-lg">Pusat Data</span>
                </a>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                <button type="button" @click="sosModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>

    </div>

    <!-- Script Inisialisasi Peta Leaflet Geoportal Publik -->
    <script>
        window.publicMapMarkers = [];
        let currentPublicBasemap = null;
        let basemapLayers = {};

        document.addEventListener('DOMContentLoaded', function () {
            const rawPoints = @json($mapPoints);
            
            // Inisialisasi Leaflet di Kota Pekanbaru [0.5071, 101.4478]
            const map = L.map('map-public', {
                scrollWheelZoom: false,
                attributionControl: false
            }).setView([0.5104, 101.4480], 12);
            window.publicLeafletMap = map;

            // Definisi Basemap resmi & stabil tanpa batasan API Key
            basemapLayers.osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            });

            basemapLayers.satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: '&copy; Esri &bull; Earthstar Geographics'
            });

            basemapLayers.topo = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: '&copy; Esri &bull; USGS'
            });

            // Aktifkan OpenStreetMap sebagai basemap bawaan
            currentPublicBasemap = basemapLayers.osm;
            currentPublicBasemap.addTo(map);

            if (rawPoints && rawPoints.length > 0) {
                const markerGroup = L.featureGroup();

                rawPoints.forEach(p => {
                    const isHandling = p.status === 'Dalam Penanganan';
                    
                    // Custom HTML Marker dengan Animasi Radar Pulse
                    const markerHtml = `
                        <div class="relative flex items-center justify-center">
                            ${isHandling ? '<span class="absolute w-8 h-8 rounded-full bg-orange-500 opacity-60 animate-ping"></span>' : ''}
                            <span class="relative w-5 h-5 rounded-full border-2 border-white shadow-md flex items-center justify-center" style="background-color: ${p.warna || '#EA580C'};">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            </span>
                        </div>
                    `;

                    const customIcon = L.divIcon({
                        className: 'custom-leaflet-marker',
                        html: markerHtml,
                        iconSize: [24, 24],
                        iconAnchor: [12, 12]
                    });

                    const marker = L.marker([p.lat, p.lng], { icon: customIcon }).addTo(map);
                    
                    const popupContent = `
                        <div class="p-1 min-w-[220px]">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded text-white" style="background-color: ${p.warna || '#EA580C'};">
                                    ${p.jenis}
                                </span>
                                <span class="text-[10px] font-bold ${isHandling ? 'text-orange-600' : 'text-emerald-600'}">
                                    ${p.status}
                                </span>
                            </div>
                            <h5 class="text-xs font-black text-slate-900 leading-tight">${p.nomor}</h5>
                            <p class="text-[11px] text-slate-600 mt-1">${p.lokasi}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">Kel. ${p.kelurahan}, Kec. ${p.kecamatan}</p>
                            <div class="mt-2 pt-2 border-t border-slate-200 text-[10px] text-slate-500 flex justify-between">
                                <span>${p.tanggal}</span>
                                <span>${p.jam}</span>
                            </div>
                        </div>
                    `;

                    marker.bindPopup(popupContent);
                    markerGroup.addLayer(marker);

                    window.publicMapMarkers.push({
                        marker: marker,
                        jenis_id: p.jenis_id
                    });
                });

                map.fitBounds(markerGroup.getBounds(), { padding: [40, 40], maxZoom: 14 });
            }
        });

        function switchPublicBasemap(type) {
            const map = window.publicLeafletMap;
            if (!map || !basemapLayers[type]) return;

            if (currentPublicBasemap) {
                map.removeLayer(currentPublicBasemap);
            }
            currentPublicBasemap = basemapLayers[type];
            currentPublicBasemap.addTo(map);

            // Update tombol styling
            const btns = {
                osm: document.getElementById('btnPubBasemapOsm'),
                satellite: document.getElementById('btnPubBasemapSat'),
                topo: document.getElementById('btnPubBasemapTopo')
            };

            Object.keys(btns).forEach(key => {
                if (!btns[key]) return;
                if (key === type) {
                    btns[key].className = 'px-3 py-1 rounded-lg font-bold bg-gradient-to-r from-orange-500 to-amber-500 text-white transition-all shadow-xs';
                } else {
                    btns[key].className = 'px-3 py-1 rounded-lg font-semibold text-slate-400 hover:text-white hover:bg-slate-700/60 transition-all';
                }
            });
        }

        function filterPublicCategory(catId) {
            const map = window.publicLeafletMap;
            if (!map || !window.publicMapMarkers) return;

            window.publicMapMarkers.forEach(item => {
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

            // Update tab styles
            document.querySelectorAll('[id^="filterPublic_"]').forEach(btn => {
                btn.className = 'px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 transition-all cursor-pointer whitespace-nowrap';
            });
            const activeBtn = document.getElementById('filterPublic_' + catId);
            if (activeBtn) {
                activeBtn.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold bg-orange-600 text-white shadow-md transition-all cursor-pointer whitespace-nowrap';
            }
        }
    </script>
</body>
</html>
