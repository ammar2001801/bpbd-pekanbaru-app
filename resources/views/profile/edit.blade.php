<x-app-layout>
    <x-slot name="header">
        Profil Personel & Keamanan Akun
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6">

        <!-- ================= 1. HERO PROFILE CARD & STATISTIK ================= -->
        <div class="bg-gradient-to-r from-slate-950 via-blue-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-slate-800">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                
                <!-- Avatar & Identitas -->
                <div class="flex items-center gap-4 sm:gap-5">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gradient-to-tr from-orange-500 via-amber-500 to-orange-600 text-white flex items-center justify-center font-black text-2xl sm:text-3xl shadow-xl ring-4 ring-orange-500/30 shrink-0">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">{{ $user->name }}</h2>
                            @if($user->role === 'admin')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30 uppercase tracking-wider">
                                    Admin IT
                                </span>
                            @elseif($user->role === 'petugas')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-orange-500/20 text-orange-300 border border-orange-500/30 uppercase tracking-wider">
                                    Petugas TRC
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30 uppercase tracking-wider">
                                    Pimpinan BPBD
                                </span>
                            @endif
                        </div>
                        <div class="text-xs text-slate-300 flex flex-wrap items-center gap-y-1 gap-x-3">
                            <span class="flex items-center gap-1 font-mono text-slate-300">
                                <svg class="w-3.5 h-3.5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                {{ $user->email }}
                            </span>
                            @if($user->jabatan)
                                <span class="text-slate-500">&bull;</span>
                                <span class="text-slate-300">{{ $user->jabatan }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- KPI Mini Cards -->
                <div class="grid grid-cols-2 gap-3 shrink-0">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3.5 border border-white/10 text-center min-w-[110px]">
                        <span class="block text-[10px] font-bold text-orange-300 uppercase tracking-wider">Laporan Diinput</span>
                        <span class="text-xl sm:text-2xl font-black text-white font-mono">{{ $totalLaporan }}</span>
                        <span class="block text-[9px] text-slate-400 mt-0.5">Kejadian</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3.5 border border-white/10 text-center min-w-[110px]">
                        <span class="block text-[10px] font-bold text-emerald-300 uppercase tracking-wider">Status Akun</span>
                        <span class="inline-flex items-center gap-1 text-sm sm:text-base font-black text-emerald-400 mt-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Aktif
                        </span>
                        <span class="block text-[9px] text-slate-400 mt-0.5">Hak Akses Penuh</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- ================= 2. GRID KONTEN PENGATURAN PROFIL ================= -->
        <div class="space-y-6">

            <!-- Formulir Informasi Biodata & Akun -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm rounded-3xl p-6 sm:p-8">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Formulir Perbarui Kata Sandi -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm rounded-3xl p-6 sm:p-8">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Formulir Hapus Akun / Proteksi -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm rounded-3xl p-6 sm:p-8">
                @include('profile.partials.delete-user-form')
            </div>

        </div>

    </div>
</x-app-layout>