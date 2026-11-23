<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Satu Data Bencana Kota Pekanbaru' }} - BPBD Kota Pekanbaru</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Anti-FOUC Theme Initializer -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 min-h-screen flex flex-col selection:bg-orange-500 selection:text-white transition-colors duration-200" 
      x-data="{ 
          mobileMenuOpen: false, 
          adminDropdownOpen: false, 
          userDropdownOpen: false,
          sosModal: false,
          darkMode: document.documentElement.classList.contains('dark'),
          toggleTheme() {
              this.darkMode = !this.darkMode;
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
                  localStorage.theme = 'dark';
              } else {
                  document.documentElement.classList.remove('dark');
                  localStorage.theme = 'light';
              }
              window.dispatchEvent(new CustomEvent('theme-changed', { detail: { dark: this.darkMode } }));
          }
      }">

    <!-- ================= 1. MICRO TOPBAR (GOVERNMENT BANNER) ================= -->
    <div class="bg-slate-950 text-slate-300 text-[11px] py-1.5 px-4 sm:px-6 lg:px-8 border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-3">
            <div class="flex items-center gap-2 min-w-0">
                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-gradient-to-r from-orange-500/20 to-amber-500/20 text-orange-400 border border-orange-500/30 font-bold uppercase tracking-wider text-[9px] shrink-0">
                    PEMERINTAH KOTA PEKANBARU
                </span>
                <span class="text-slate-600 hidden sm:inline">&bull;</span>
                <span class="text-slate-300 font-medium truncate text-[11px] flex items-center gap-1.5">
                    <span class="relative flex h-2 w-2 shrink-0">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                    </span>
                    <span>PUSDALOPS-PB ONLINE 24/7 &bull; STANDAR DIBI BNPB</span>
                </span>
            </div>
            <div class="flex items-center gap-3 text-slate-400 shrink-0">
                <span class="flex items-center gap-1.5 text-orange-400 font-semibold text-[11px]">
                    <svg class="w-3.5 h-3.5 text-orange-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span>Call Center 112 / 0811-7604-800</span>
                </span>
                <span class="hidden md:inline text-slate-700">|</span>
                <span class="hidden md:inline font-mono text-slate-400 text-[11px]">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
        </div>
    </div>

    <!-- ================= 2. MAIN MODERN NAVBAR (ALA DATA.BNPB.GO.ID) ================= -->
    <header class="sticky top-0 z-40 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800/80 shadow-xs transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-20 flex items-center justify-between gap-3 lg:gap-4">
                
                <!-- BRAND & LOGO (SHRINK-0 & NO-WRAP PREVENTS ANY UNINTENDED OVERFLOW) -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo-bpbd.png') }}" alt="Logo BPBD Kota Pekanbaru" class="w-11 h-11 rounded-full object-contain shrink-0 ring-2 ring-orange-500/20 group-hover:ring-orange-500/50 group-hover:scale-105 transition-all shadow-xs">
                        <div class="shrink-0">
                            <div class="flex items-center gap-1.5 whitespace-nowrap">
                                <span class="font-black text-base sm:text-lg tracking-tight text-slate-900 dark:text-white group-hover:text-orange-500 dark:group-hover:text-orange-400 transition-colors">
                                    SATU DATA BENCANA
                                </span>
                                <span class="text-[9px] font-black bg-gradient-to-r from-orange-500 to-amber-500 text-white px-1.5 py-0.5 rounded-md uppercase tracking-wider shadow-xs">PKU</span>
                            </div>
                            <div class="text-[10px] text-slate-500 dark:text-slate-400 font-medium whitespace-nowrap leading-tight mt-0.5">
                                Pusdalops-PB BPBD Kota Pekanbaru
                            </div>
                        </div>
                    </a>
                </div>

                <!-- NAVIGATION LINKS (DESKTOP) -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-1.5 text-xs font-semibold shrink-0">
                    <!-- Portal Publik Beranda -->
                    <a href="{{ route('welcome') }}" 
                       class="px-3 py-2 rounded-xl transition-all duration-200 flex items-center gap-1.5 whitespace-nowrap text-slate-600 dark:text-slate-300 hover:text-orange-600 dark:hover:text-orange-400 hover:bg-slate-100 dark:hover:bg-slate-800/80" title="Buka Portal Depan BPBD Riau Style">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        <span>Portal Publik</span>
                    </a>

                    <!-- Geoportal Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       class="px-3 py-2 rounded-xl transition-all duration-200 flex items-center gap-1.5 whitespace-nowrap {{ request()->routeIs('dashboard') ? 'bg-slate-900 dark:bg-gradient-to-r dark:from-orange-500/20 dark:to-amber-500/15 text-white dark:text-orange-300 font-bold shadow-xs ring-1 ring-slate-700 dark:ring-orange-500/40' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/80' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-orange-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        <span>Geoportal</span>
                    </a>

                    <!-- Data Kejadian -->
                    <a href="{{ route('kejadian.index') }}" 
                       class="px-3 py-2 rounded-xl transition-all duration-200 flex items-center gap-1.5 whitespace-nowrap {{ request()->routeIs('kejadian.index') || request()->routeIs('kejadian.show') || request()->routeIs('kejadian.edit') ? 'bg-slate-900 dark:bg-gradient-to-r dark:from-orange-500/20 dark:to-amber-500/15 text-white dark:text-orange-300 font-bold shadow-xs ring-1 ring-slate-700 dark:ring-orange-500/40' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/80' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('kejadian.index') || request()->routeIs('kejadian.show') || request()->routeIs('kejadian.edit') ? 'text-orange-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Data Kejadian</span>
                    </a>

                    <!-- Rekapitulasi -->
                    <a href="{{ route('rekap.index') }}" 
                       class="px-3 py-2 rounded-xl transition-all duration-200 flex items-center gap-1.5 whitespace-nowrap {{ request()->routeIs('rekap.*') ? 'bg-slate-900 dark:bg-gradient-to-r dark:from-orange-500/20 dark:to-amber-500/15 text-white dark:text-orange-300 font-bold shadow-xs ring-1 ring-slate-700 dark:ring-orange-500/40' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/80' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('rekap.*') ? 'text-orange-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>Rekapitulasi</span>
                    </a>

                    <!-- Cetak PDF Resmi -->
                    <a href="{{ route('laporan.pdf-menu') }}" 
                       class="px-3 py-2 rounded-xl transition-all duration-200 flex items-center gap-1.5 whitespace-nowrap {{ request()->routeIs('laporan.*') ? 'bg-slate-900 dark:bg-gradient-to-r dark:from-orange-500/20 dark:to-amber-500/15 text-white dark:text-orange-300 font-bold shadow-xs ring-1 ring-slate-700 dark:ring-orange-500/40' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/80' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('laporan.*') ? 'text-orange-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Cetak PDF</span>
                    </a>

                    <!-- Menu Khusus Admin (Dropdown) -->
                    @if(Auth::user()->isAdmin())
                    <div class="relative" @click.away="adminDropdownOpen = false">
                        <button @click="adminDropdownOpen = !adminDropdownOpen" 
                                class="px-3 py-2 rounded-xl transition-all duration-200 flex items-center gap-1 whitespace-nowrap cursor-pointer {{ request()->routeIs('admin.*') ? 'bg-slate-900 dark:bg-gradient-to-r dark:from-orange-500/20 dark:to-amber-500/15 text-white dark:text-orange-300 font-bold shadow-xs ring-1 ring-slate-700 dark:ring-orange-500/40' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/80' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.*') ? 'text-orange-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Administrasi</span>
                            <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="adminDropdownOpen" x-cloak 
                             class="absolute left-0 mt-2 w-56 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200/90 dark:border-slate-800 py-2 z-50">
                            <div class="px-4 py-1.5 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                                Kelola Master & Sistem
                            </div>
                            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-orange-600 dark:hover:text-orange-400 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                <span>Manajemen Pengguna</span>
                            </a>
                            <a href="{{ route('admin.master.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-orange-600 dark:hover:text-orange-400 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                                <span>Master Data & Wilayah</span>
                            </a>
                            <a href="{{ route('admin.pengaturan.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-orange-600 dark:hover:text-orange-400 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <span>Pengaturan Kop & Pimpinan</span>
                            </a>
                        </div>
                    </div>
                    @endif
                </nav>

                <!-- RIGHT CONTROLS: ACTION BUTTON, DUAL THEME SWITCH & USER PROFILE -->
                <div class="flex items-center gap-2 sm:gap-2.5 shrink-0">
                    
                    @if(Auth::user()->role !== 'pimpinan')
                    <!-- Tombol Cepat: Input Kejadian Baru (Modern Gradient with Glow) -->
                    <a href="{{ route('kejadian.create') }}" 
                       class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:via-amber-600 hover:to-orange-700 text-white font-bold text-xs uppercase tracking-wider shadow-md shadow-orange-500/25 hover:shadow-lg hover:shadow-orange-500/35 hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all duration-200 border border-orange-400/40 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Input Kejadian</span>
                    </a>
                    @endif

                    <!-- ULTRA-MODERN DUAL CAPSULE THEME TOGGLE -->
                    <button type="button" 
                            @click="toggleTheme()" 
                            class="relative inline-flex items-center p-1 rounded-full bg-slate-100 dark:bg-slate-800/90 border border-slate-200 dark:border-slate-700/80 shadow-inner cursor-pointer transition-all duration-300 hover:border-orange-400/50 hover:shadow-xs group focus:outline-hidden"
                            :title="darkMode ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap'"
                            aria-label="Ganti Tema Tampilan">
                        <!-- Sun Pill -->
                        <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold transition-all duration-300 select-none"
                              :class="!darkMode ? 'bg-white text-amber-600 shadow-sm ring-1 ring-amber-400/30 font-extrabold' : 'text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'">
                            <svg class="w-3.5 h-3.5 transition-transform duration-500" :class="!darkMode ? 'rotate-90 text-amber-500 scale-110' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span class="hidden md:inline">Terang</span>
                        </span>
                        <!-- Moon Pill -->
                        <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold transition-all duration-300 select-none"
                              :class="darkMode ? 'bg-gradient-to-r from-slate-900 to-indigo-950 text-indigo-300 shadow-sm ring-1 ring-indigo-500/50 font-extrabold' : 'text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'">
                            <svg class="w-3.5 h-3.5 transition-transform duration-500" :class="darkMode ? '-rotate-12 text-indigo-400 scale-110' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <span class="hidden md:inline">Gelap</span>
                        </span>
                    </button>

                    <!-- User Profile Capsule Dropdown -->
                    <div class="relative" @click.away="userDropdownOpen = false">
                        <button @click="userDropdownOpen = !userDropdownOpen" 
                                class="flex items-center gap-2 p-1 sm:pl-1.5 sm:pr-2.5 py-1 rounded-full bg-slate-100/90 dark:bg-slate-800/90 hover:bg-slate-200/80 dark:hover:bg-slate-700/80 border border-slate-200/90 dark:border-slate-700/80 transition-all duration-200 hover:scale-[1.02] active:scale-95 shadow-2xs">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-slate-900 to-blue-900 dark:from-orange-600 dark:to-amber-600 text-white flex items-center justify-center font-bold text-xs shadow-xs shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div class="text-left hidden sm:block">
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-100 leading-tight truncate max-w-[100px]">{{ Auth::user()->name }}</div>
                                <div class="text-[9px] text-orange-600 dark:text-orange-400 font-extrabold uppercase tracking-wider">{{ Auth::user()->role }}</div>
                            </div>
                            <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500 hidden sm:inline ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="userDropdownOpen" x-cloak 
                             class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800 py-2 z-50">
                            <div class="px-4 py-2.5 border-b border-slate-100 dark:border-slate-800">
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-100">{{ Auth::user()->name }}</div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400 font-mono truncate">{{ Auth::user()->email }}</div>
                                <div class="mt-1.5">
                                    @if(Auth::user()->role === 'admin')
                                        <span class="text-[10px] bg-rose-50 dark:bg-rose-950/50 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800 px-2 py-0.5 rounded-md font-bold uppercase">Admin IT</span>
                                    @elseif(Auth::user()->role === 'petugas')
                                        <span class="text-[10px] bg-orange-50 dark:bg-orange-950/50 text-orange-700 dark:text-orange-300 border border-orange-200 dark:border-orange-800 px-2 py-0.5 rounded-md font-bold uppercase">Petugas TRC</span>
                                    @else
                                        <span class="text-[10px] bg-blue-50 dark:bg-blue-950/50 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800 px-2 py-0.5 rounded-md font-bold uppercase">Pimpinan BPBD</span>
                                    @endif
                                </div>
                            </div>

                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span>Pengaturan Profil</span>
                            </a>

                            <div class="border-t border-slate-100 dark:border-slate-800 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-xs font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 flex items-center gap-2.5 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    <span>Keluar (Logout)</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Mobile Menu Hamburger Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- ================= MOBILE NAVIGATION DRAWER ================= -->
        <div x-show="mobileMenuOpen" x-cloak class="lg:hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3 space-y-1.5">
            <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Ganti Tema Tampilan</span>
                <button type="button" @click="toggleTheme()" class="inline-flex items-center p-1 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-inner">
                    <span class="flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold"
                          :class="!darkMode ? 'bg-white text-amber-600 shadow-xs' : 'text-slate-400'">
                        <svg class="w-3 h-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Terang</span>
                    </span>
                    <span class="flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold"
                          :class="darkMode ? 'bg-slate-900 text-indigo-300 shadow-xs' : 'text-slate-400'">
                        <svg class="w-3 h-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <span>Gelap</span>
                    </span>
                </button>
            </div>
            <a href="{{ route('welcome') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-orange-600 dark:text-orange-400 hover:bg-orange-50 dark:hover:bg-slate-800 transition-colors">
                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                <span>Portal Publik Utama</span>
            </a>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('dashboard') ? 'bg-slate-900 dark:bg-slate-800 text-white' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                <span>Geoportal Dashboard</span>
            </a>
            <a href="{{ route('kejadian.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('kejadian.index') ? 'bg-slate-900 dark:bg-slate-800 text-white' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Data Kejadian</span>
            </a>
            <a href="{{ route('rekap.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('rekap.*') ? 'bg-slate-900 dark:bg-slate-800 text-white' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>Rekapitulasi Data</span>
            </a>
            <a href="{{ route('laporan.pdf-menu') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('laporan.*') ? 'bg-slate-900 dark:bg-slate-800 text-white' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak PDF Resmi</span>
            </a>
            @if(Auth::user()->isAdmin())
                <div class="pt-2 border-t border-slate-100 dark:border-slate-800 text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3">
                    Menu Administrasi
                </div>
                <a href="{{ route('admin.users.index') }}" class="block px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">
                    Manajemen Pengguna
                </a>
                <a href="{{ route('admin.master.index') }}" class="block px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">
                    Master Data & Wilayah
                </a>
                <a href="{{ route('admin.pengaturan.index') }}" class="block px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">
                    Pengaturan Instansi
                </a>
            @endif
            @if(Auth::user()->role !== 'pimpinan')
            <div class="pt-2">
                <a href="{{ route('kejadian.create') }}" class="block text-center py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold text-xs uppercase tracking-wider shadow-md shadow-orange-500/20">
                    + Input Kejadian Baru
                </a>
            </div>
            @endif
        </div>
    </header>

    <!-- ================= 3. FLASH MESSAGES NOTIFICATION ================= -->
    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-4">
        @if(session('success'))
            <div class="p-4 mb-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 flex items-center gap-3 shadow-2xs" role="alert">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-xs sm:text-sm font-semibold flex-1">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 flex items-center gap-3 shadow-2xs" role="alert">
                <svg class="w-5 h-5 text-rose-600 dark:text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-xs sm:text-sm font-semibold flex-1">{{ session('error') }}</div>
            </div>
        @endif

        @if(session('warning'))
            <div class="p-4 mb-4 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 text-amber-800 dark:text-amber-300 flex items-center gap-3 shadow-2xs" role="alert">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div class="text-xs sm:text-sm font-semibold flex-1">{{ session('warning') }}</div>
            </div>
        @endif
    </div>

    <!-- ================= 4. MAIN PAGE CONTENT SLOT ================= -->
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6">
        {{ $slot }}
    </main>

    <!-- ================= 5. OFFICIAL PORTAL FOOTER (ALA BNPB DATA) ================= -->
    <footer class="bg-slate-950 text-white border-t border-slate-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                
                <!-- Kolom 1: Profil Instansi -->
                <div class="md:col-span-2 space-y-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-bpbd.png') }}" alt="Logo BPBD Kota Pekanbaru" class="w-11 h-11 rounded-full object-contain">
                        <div>
                            <div class="font-black text-base text-white tracking-wide">BPBD KOTA PEKANBARU</div>
                            <div class="text-xs text-orange-400 font-semibold">Pusat Pengendalian Operasi Penanggulangan Bencana</div>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-md">
                        Sistem informasi terpadu pelaporan harian dan rekapitulasi data kejadian bencana Kota Pekanbaru. Menghubungkan informasi kesiapsiagaan dari Tim Reaksi Cepat (TRC) di lapangan langsung ke pengambil kebijakan dan masyarakat.
                    </p>
                </div>

                <!-- Kolom 2: Kontak Kedaruratan -->
                <div class="space-y-2.5 text-xs text-slate-300">
                    <div class="text-xs font-bold text-orange-400 uppercase tracking-wider mb-2">Kontak Kedaruratan</div>
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-slate-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Jl. Mustafa Sari No. 1, Kec. Bukit Raya, Pekanbaru, Riau 28126</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>Call Center: <strong class="text-white">112</strong> / 0811-7604-800</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>bpbd@pekanbaru.go.id</span>
                    </div>
                </div>

                <!-- Kolom 3: Navigasi Cepat -->
                <div class="space-y-2 text-xs text-slate-400">
                    <div class="text-xs font-bold text-orange-400 uppercase tracking-wider mb-2">Layanan Terpadu</div>
                    <div><a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Geoportal Pemetaan Bencana</a></div>
                    <div><a href="{{ route('kejadian.index') }}" class="hover:text-white transition-colors">Katalog Laporan Kejadian</a></div>
                    <div><a href="{{ route('rekap.index') }}" class="hover:text-white transition-colors">Rekapitulasi & Ekspor Excel</a></div>
                    <div><a href="{{ route('laporan.pdf-menu') }}" class="hover:text-white transition-colors">Pusat Cetak Dokumen PDF Resmi</a></div>
                </div>

            </div>

            <!-- Bottom Copyright Bar -->
            <div class="pt-8 mt-8 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <div>
                    &copy; {{ date('Y') }} <strong>Badan Penanggulangan Bencana Daerah Kota Pekanbaru</strong>. Hak Cipta Dilindungi.
                </div>
                <div class="text-[11px] text-slate-500">
                    Sistem Informasi Rekapitulasi Bencana Berbasis Web &bull; Standardisasi DIBI BNPB
                </div>
            </div>
        </div>
    </footer>

    <!-- ================= FLOATING SOS CALL 112 BUTTON (BPBD RIAU RADAR PULSE) ================= -->
    <div class="fixed bottom-6 right-6 z-40">
        <button type="button" 
                @click="sosModal = true" 
                class="group relative flex items-center gap-2.5 px-4 py-3 rounded-full bg-gradient-to-r from-red-600 via-rose-600 to-red-700 text-white font-black text-xs uppercase tracking-wider shadow-2xl shadow-red-600/50 hover:shadow-red-600/80 hover:scale-105 active:scale-95 transition-all duration-300 border-2 border-white/30 cursor-pointer">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-90"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
            </span>
            <span class="tracking-wide">SOS CALL 112</span>
        </button>
    </div>

    <!-- MODAL DARURAT 112 & PUSDALOPS PUSAT -->
    <div x-cloak x-show="sosModal" 
         @keydown.escape.window="sosModal = false"
         class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity" @click="sosModal = false"></div>
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg p-6 sm:p-8" @click.stop>
                <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-red-100 dark:bg-red-950/80 text-red-600 dark:text-red-400 flex items-center justify-center font-black">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-white uppercase tracking-wider">LAYANAN KEDARURATAN 24 JAM</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Pusdalops-PB BPBD Kota Pekanbaru</p>
                        </div>
                    </div>
                    <button type="button" @click="sosModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="mt-6 space-y-4">
                    <a href="tel:112" class="flex items-center justify-between p-4 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-900/60 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors group">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-xl bg-red-600 text-white flex items-center justify-center font-black text-lg shadow-md group-hover:scale-105 transition-transform">
                                112
                            </div>
                            <div>
                                <div class="text-xs font-bold uppercase tracking-wider text-red-600 dark:text-red-400">Call Center Bebas Pulsa</div>
                                <div class="text-base font-black text-slate-900 dark:text-white">Panggilan Darurat 112</div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400">Gratis dari seluruh operator telepon</div>
                            </div>
                        </div>
                        <span class="px-3 py-1.5 rounded-xl bg-red-600 text-white font-bold text-xs uppercase group-hover:bg-red-700">Hubungi</span>
                    </a>

                    <a href="https://wa.me/628117604800?text=Halo%20PUSDALOPS%20BPBD%20Kota%20Pekanbaru,%20saya%20ingin%20melaporkan%20kejadian%20darurat:" target="_blank" class="flex items-center justify-between p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-900/60 hover:bg-emerald-100 dark:hover:bg-emerald-900/40 transition-colors group">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black shadow-md group-hover:scale-105 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">WhatsApp Pusdalops</div>
                                <div class="text-base font-black text-slate-900 dark:text-white font-mono">0811-7604-800</div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400">Kirim foto kejadian & live location</div>
                            </div>
                        </div>
                        <span class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-bold text-xs uppercase group-hover:bg-emerald-700">Kirim Pesan</span>
                    </a>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-200 dark:border-slate-800 text-center">
                    <p class="text-xs text-slate-400">Posko Komando: Jl. Mustafa Sari No. 1, Bukit Raya, Pekanbaru</p>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
