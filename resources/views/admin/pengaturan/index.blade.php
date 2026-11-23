<x-app-layout>
    <x-slot name="header">
        Pengaturan Instansi & Kop Surat Resmi
    </x-slot>

    <!-- PAGE HEADER TITLE -->
    <div class="mb-6">
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">Pengaturan Instansi & Kop Dokumen Resmi</h2>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Konfigurasi identitas lembaga, pejabat penandatangan laporan, dan format kop surat BPBD Kota Pekanbaru.</p>
    </div>

    <!-- BANNER PEMBERITAHUAN EFEK GLOBAL -->
    <div class="mb-6 bg-gradient-to-r from-slate-950 via-blue-950 to-slate-900 text-white rounded-2xl p-5 shadow-md border border-slate-800 flex items-start gap-3.5 relative overflow-hidden">
        <div class="absolute -right-8 -bottom-8 w-36 h-36 bg-orange-500/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="w-10 h-10 rounded-xl bg-orange-500/20 border border-orange-500/30 flex items-center justify-center text-orange-400 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="relative z-10">
            <h3 class="font-bold text-sm text-white">Sinkronisasi Otomatis Dokumen Dinas</h3>
            <p class="text-xs text-slate-300 mt-0.5 leading-relaxed">
                Informasi instansi, alamat kop, dan nama pejabat penandatangan yang disimpan di halaman ini akan <strong class="text-orange-300">secara otomatis terpasang</strong> pada seluruh lembar cetak laporan PDF (Lembar Kejadian Tunggal & Rekapitulasi Berkala), serta file ekspor Excel Pusdalops-PB.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <!-- KOLOM KIRI (2 Kolom): FORM PENGATURAN -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                
                <form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- 1. IDENTITAS PEMDA & INSTANSI -->
                    <div>
                        <div class="flex items-center gap-2 pb-2.5 border-b border-slate-100 dark:border-slate-800 mb-4">
                            <span class="w-7 h-7 rounded-lg bg-orange-100 dark:bg-orange-950/70 text-orange-700 dark:text-orange-400 flex items-center justify-center font-bold text-xs">1</span>
                            <h4 class="font-bold text-sm text-slate-800 dark:text-white">Identitas Pemerintah Daerah & Badan</h4>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nama Pemerintah Daerah *</label>
                                <input type="text" name="nama_pemda" value="{{ old('nama_pemda', $pengaturan->nama_pemda) }}" required
                                       class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white focus:border-orange-500 focus:ring-orange-500 py-2.5">
                                <span class="text-[11px] text-slate-400 dark:text-slate-500">Contoh: PEMERINTAH KOTA PEKANBARU (Tampil di baris pertama kop surat)</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nama Instansi Lengkap *</label>
                                    <input type="text" name="nama_instansi" value="{{ old('nama_instansi', $pengaturan->nama_instansi) }}" required
                                           class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white focus:border-orange-500 focus:ring-orange-500 py-2.5">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Singkatan</label>
                                    <input type="text" name="singkatan" value="{{ old('singkatan', $pengaturan->singkatan) }}"
                                           class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white focus:border-orange-500 focus:ring-orange-500 py-2.5">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. PEJABAT PENANDATANGAN LAPORAN -->
                    <div>
                        <div class="flex items-center gap-2 pb-2.5 border-b border-slate-100 dark:border-slate-800 mb-4">
                            <span class="w-7 h-7 rounded-lg bg-orange-100 dark:bg-orange-950/70 text-orange-700 dark:text-orange-400 flex items-center justify-center font-bold text-xs">2</span>
                            <h4 class="font-bold text-sm text-slate-800 dark:text-white">Pejabat Penandatangan Laporan (Mengetahui)</h4>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nama Lengkap & Gelar Pimpinan *</label>
                                <input type="text" name="nama_pimpinan" value="{{ old('nama_pimpinan', $pengaturan->nama_pimpinan) }}" required
                                       class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white focus:border-orange-500 focus:ring-orange-500 py-2.5">
                                <span class="text-[11px] text-slate-400 dark:text-slate-500">Contoh: Zarman Candra, S.STP, M.Si</span>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">NIP Pimpinan *</label>
                                <input type="text" name="nip_pimpinan" value="{{ old('nip_pimpinan', $pengaturan->nip_pimpinan) }}" required
                                       class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white focus:border-orange-500 focus:ring-orange-500 py-2.5 font-mono">
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Jabatan Resmi Penandatangan *</label>
                            <input type="text" name="jabatan_pimpinan" value="{{ old('jabatan_pimpinan', $pengaturan->jabatan_pimpinan) }}" required
                                   class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white focus:border-orange-500 focus:ring-orange-500 py-2.5">
                            <span class="text-[11px] text-slate-400 dark:text-slate-500">Contoh: Kepala Pelaksana BPBD Kota Pekanbaru</span>
                        </div>
                    </div>

                    <!-- 3. ALAMAT & KONTAK KOP SURAT -->
                    <div>
                        <div class="flex items-center gap-2 pb-2.5 border-b border-slate-100 dark:border-slate-800 mb-4">
                            <span class="w-7 h-7 rounded-lg bg-orange-100 dark:bg-orange-950/70 text-orange-700 dark:text-orange-400 flex items-center justify-center font-bold text-xs">3</span>
                            <h4 class="font-bold text-sm text-slate-800 dark:text-white">Alamat Kop Surat & Saluran Komunikasi</h4>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Alamat Kantor Dinas / Pusdalops *</label>
                                <textarea name="alamat" rows="2" required class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white focus:border-orange-500 focus:ring-orange-500 py-2">{{ old('alamat', $pengaturan->alamat) }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">No. Kontak / Call Center</label>
                                    <input type="text" name="kontak" value="{{ old('kontak', $pengaturan->kontak) }}"
                                           class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white focus:border-orange-500 focus:ring-orange-500 py-2.5">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Email Resmi Dinas</label>
                                    <input type="email" name="email" value="{{ old('email', $pengaturan->email) }}"
                                           class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white focus:border-orange-500 focus:ring-orange-500 py-2.5">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Website Resmi</label>
                                    <input type="text" name="website" value="{{ old('website', $pengaturan->website) }}"
                                           class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white focus:border-orange-500 focus:ring-orange-500 py-2.5">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. LOGO KOP SURAT -->
                    <div>
                        <div class="flex items-center gap-2 pb-2.5 border-b border-slate-100 dark:border-slate-800 mb-4">
                            <span class="w-7 h-7 rounded-lg bg-orange-100 dark:bg-orange-950/70 text-orange-700 dark:text-orange-400 flex items-center justify-center font-bold text-xs">4</span>
                            <h4 class="font-bold text-sm text-slate-800 dark:text-white">Logo Instansi (Opsional)</h4>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden flex-shrink-0">
                                <img src="{{ asset('images/logo-bpbd.png') }}" class="w-full h-full rounded-full object-contain p-1">
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Ganti File Logo</label>
                                <input type="file" name="logo" accept="image/png,image/jpeg,image/webp,image/svg+xml"
                                       class="w-full text-xs text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-orange-50 dark:file:bg-orange-950/50 file:text-orange-700 dark:file:text-orange-400 hover:file:bg-orange-100">
                                <span class="text-[11px] text-slate-400 dark:text-slate-500">Format: PNG, JPG, SVG maks 2MB (Gunakan logo bulat transparan untuk hasil terbaik)</span>
                            </div>
                        </div>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:via-amber-600 hover:to-orange-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40 hover:-translate-y-0.5 active:translate-y-0 border border-orange-400/40 transition-all duration-200 flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Simpan Pengaturan Instansi</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>

        <!-- KOLOM KANAN (1 Kolom): LIVE PREVIEW KOP & TTD -->
        <div class="space-y-6">
            
            <!-- PREVIEW KOP SURAT -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3 flex items-center justify-between">
                    <span>Preview Kop Dokumen Resmi</span>
                    <span class="text-emerald-600 dark:text-emerald-400 font-semibold text-[10px]">Aktif</span>
                </div>

                <div class="border border-slate-200 dark:border-slate-800 rounded-xl p-4 bg-slate-50/50 dark:bg-slate-950/80 text-center text-slate-800 dark:text-slate-200">
                    <img src="{{ asset('images/logo-bpbd.png') }}" alt="Logo BPBD" class="w-12 h-12 rounded-full object-contain mx-auto mb-1">
                    <div class="font-bold text-xs tracking-wider uppercase text-slate-900 dark:text-white">{{ $pengaturan->nama_pemda }}</div>
                    <div class="font-black text-sm tracking-wide uppercase text-blue-950 dark:text-blue-300 mt-0.5">{{ $pengaturan->nama_instansi }}</div>
                    <div class="text-[10px] font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider mt-0.5">Pusdalops-PB Kota Pekanbaru</div>
                    <div class="text-[9px] text-slate-500 dark:text-slate-400 mt-1 leading-tight">{{ $pengaturan->alamat }}</div>
                    <div class="text-[9px] text-slate-500 dark:text-slate-400 leading-tight">Kontak: {{ $pengaturan->kontak }} | Email: {{ $pengaturan->email }}</div>
                    <div class="border-b-2 border-slate-900 dark:border-slate-400 mt-2 mb-0.5"></div>
                    <div class="border-b border-slate-900 dark:border-slate-400 mb-2"></div>
                </div>

                <div class="mt-3 text-[11px] text-slate-400 italic text-center">
                    Tampilan persis kop surat di dokumen PDF & Excel
                </div>
            </div>

            <!-- PREVIEW BLOK TANDA TANGAN -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3">
                    Preview Blok Tanda Tangan
                </div>

                <div class="border border-slate-200 dark:border-slate-800 rounded-xl p-4 bg-slate-50/50 dark:bg-slate-950/80 text-center text-xs">
                    <div class="text-slate-500 dark:text-slate-400 text-[11px]">Pekanbaru, {{ now()->locale('id')->isoFormat('D MMMM Y') }}</div>
                    <div class="text-slate-500 dark:text-slate-400 text-[11px]">Mengetahui,</div>
                    <div class="font-bold text-slate-800 dark:text-slate-200 text-[11px] mt-0.5">{{ $pengaturan->jabatan_pimpinan }}</div>

                    <div class="h-16 flex items-center justify-center text-slate-400 dark:text-slate-600 text-[11px] italic">
                        (Tanda Tangan & Cap Stempel Dinas)
                    </div>

                    <div class="font-black text-slate-900 dark:text-white text-xs underline">{{ $pengaturan->nama_pimpinan }}</div>
                    <div class="text-slate-500 dark:text-slate-400 text-[10px] font-mono mt-0.5">NIP. {{ $pengaturan->nip_pimpinan }}</div>
                </div>
            </div>

            <!-- TAUTAN PENGUJIAN -->
            <div class="bg-slate-50 dark:bg-slate-900 rounded-2xl p-4 border border-slate-200 dark:border-slate-800 text-xs text-slate-600 dark:text-slate-300 space-y-2">
                <div class="font-bold text-slate-800 dark:text-white">Uji Hasil Pengaturan:</div>
                <div class="flex flex-col gap-1.5">
                    <a href="{{ route('laporan.pdf-menu') }}" class="text-orange-600 dark:text-orange-400 hover:underline font-semibold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        Cek di Pusat Dokumen PDF
                    </a>
                    <a href="{{ route('rekap.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        Cek di Rekapitulasi & Ekspor Excel
                    </a>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
