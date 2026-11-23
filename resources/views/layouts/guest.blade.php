<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Masuk Portal' }} - BPBD Kota Pekanbaru</title>

    <!-- Anti-FOUC Theme Initializer -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100 dark:bg-slate-950 min-h-screen text-slate-800 dark:text-slate-100 flex flex-col justify-between selection:bg-orange-500 selection:text-white transition-colors duration-200"
      x-data="{ 
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
          }
      }">
    <!-- Background Decor -->
    <div class="fixed inset-0 z-0 opacity-15 dark:opacity-20 pointer-events-none bg-[radial-gradient(#ea580c_1px,transparent_1px)] [background-size:16px_16px]"></div>

    <!-- Top Right Theme Toggle -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 pt-4 flex justify-end">
        <button type="button" 
                @click="toggleTheme()" 
                class="relative inline-flex items-center p-1 rounded-full bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border border-slate-200 dark:border-slate-800 shadow-sm cursor-pointer transition-all duration-300 hover:border-orange-400/50 hover:shadow-xs group focus:outline-hidden"
                :title="darkMode ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap'"
                aria-label="Ganti Tema Tampilan">
            <!-- Sun Pill -->
            <span class="flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold transition-all duration-300 select-none"
                  :class="!darkMode ? 'bg-white text-amber-600 shadow-sm ring-1 ring-amber-400/30 font-extrabold' : 'text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'">
                <svg class="w-3.5 h-3.5 transition-transform duration-500" :class="!darkMode ? 'rotate-90 text-amber-500 scale-110' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span>Terang</span>
            </span>
            <!-- Moon Pill -->
            <span class="flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold transition-all duration-300 select-none"
                  :class="darkMode ? 'bg-gradient-to-r from-slate-900 to-indigo-950 text-indigo-300 shadow-sm ring-1 ring-indigo-500/50 font-extrabold' : 'text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'">
                <svg class="w-3.5 h-3.5 transition-transform duration-500" :class="darkMode ? '-rotate-12 text-indigo-400 scale-110' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <span>Gelap</span>
            </span>
        </button>
    </div>

    <div class="relative z-10 flex-1 flex flex-col justify-center items-center px-4 py-6 sm:px-6 lg:px-8">
        {{ $slot }}
    </div>

    <!-- Official Login Footer -->
    <div class="relative z-10 py-4 text-center text-xs text-slate-400 dark:text-slate-500 border-t border-slate-200/60 dark:border-slate-800/80">
        &copy; {{ date('Y') }} Pusdalops-PB BPBD Kota Pekanbaru &bull; Standar Data Bencana Indonesia (DIBI BNPB)
    </div>
</body>
</html>
