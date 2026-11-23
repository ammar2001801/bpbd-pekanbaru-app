<x-app-layout>
    <x-slot name="header">
        Laporan Berhasil Disimpan
    </x-slot>

    <div class="max-w-2xl mx-auto py-8">
        <!-- Success State Card -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200/80 dark:border-slate-800 shadow-xl text-center">
            
            <div class="w-16 h-16 bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-500/20 border border-emerald-200 dark:border-emerald-800">
                <svg class="w-8 h-8 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>

            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 px-3 py-1 rounded-full uppercase tracking-wider">
                Berhasil Tersimpan di Database Pusdalops
            </span>

            <h2 class="text-2xl font-black text-slate-900 dark:text-white mt-3 mb-1">
                Laporan Kejadian Bencana Selesai Dibuat
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">
                Data telah terindeks secara otomatis dan siap direkapitulasi ke pimpinan serta BNPB.
            </p>

            <!-- Incident Summary Card -->
            <div class="bg-slate-50 dark:bg-slate-950 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 text-left mb-6 space-y-2.5">
                <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold">Nomor Registrasi Laporan:</span>
                    <span class="font-mono font-black text-sm text-blue-900 dark:text-blue-400 bg-white dark:bg-slate-900 px-2 py-0.5 rounded border border-blue-200 dark:border-blue-800">
                        {{ $kejadian->nomor_laporan }}
                    </span>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-500 dark:text-slate-400 font-semibold">Waktu Kejadian:</span>
                    <span class="font-bold text-slate-800 dark:text-slate-200">
                        {{ $kejadian->tanggal_kejadian->locale('id')->isoFormat('D MMMM Y') }} - {{ substr($kejadian->jam_kejadian, 0, 5) }} WIB
                    </span>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-500 dark:text-slate-400 font-semibold">Jenis Kejadian:</span>
                    <span class="font-bold px-2 py-0.5 rounded text-white text-[11px]" style="background-color: {{ $kejadian->jenisKejadian->warna }};">
                        {{ $kejadian->jenisKejadian->nama }}
                    </span>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-500 dark:text-slate-400 font-semibold">Lokasi Wilayah:</span>
                    <span class="font-bold text-slate-800 dark:text-slate-200">
                        {{ $kejadian->kelurahan ? 'Kel. ' . $kejadian->kelurahan->nama_kelurahan . ', ' : '' }}Kec. {{ $kejadian->kecamatan->nama_kecamatan }}
                    </span>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-500 dark:text-slate-400 font-semibold">Status Penanganan:</span>
                    <span class="font-bold {{ $kejadian->status === 'Selesai' ? 'text-emerald-700 dark:text-emerald-400' : 'text-amber-700 dark:text-amber-400' }}">
                        {{ $kejadian->status }}
                    </span>
                </div>

                <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-200 dark:border-slate-800">
                    <span class="text-slate-500 dark:text-slate-400 font-semibold">Dokumentasi Foto:</span>
                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $kejadian->foto->count() }} foto tersimpan</span>
                </div>
            </div>

            <!-- ACTION BUTTONS (Aturan: Tampilkan Tambah Laporan Lagi & Cetak Laporan) -->
            <div class="space-y-3">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Tambah Laporan Lagi -->
                    <a href="{{ route('kejadian.create') }}" 
                       class="py-3 px-4 rounded-xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:via-amber-600 hover:to-orange-700 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40 hover:-translate-y-0.5 active:translate-y-0 border border-orange-400/40 flex items-center justify-center gap-2 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Laporan Lagi</span>
                    </a>

                    <!-- Cetak Laporan (PDF) -->
                    <a href="{{ route('laporan.pdf-single', $kejadian->id) }}" target="_blank"
                       class="py-3 px-4 rounded-xl bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 hover:from-blue-800 hover:via-indigo-800 hover:to-slate-800 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-blue-900/25 hover:shadow-blue-900/40 hover:-translate-y-0.5 active:translate-y-0 border border-blue-700/40 flex items-center justify-center gap-2 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Cetak Laporan (PDF)</span>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-3 pt-2">
                    <a href="{{ route('kejadian.index') }}" 
                       class="py-2.5 px-3 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 font-bold text-xs text-center hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                        Ke Daftar Kejadian
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="py-2.5 px-3 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 font-bold text-xs text-center hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                        Ke Dashboard
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
