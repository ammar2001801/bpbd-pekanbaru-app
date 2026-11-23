<x-app-layout>
    <x-slot name="header">
        Cetak Dokumen Laporan Resmi (PDF)
    </x-slot>

    <!-- BANNER PEMBERITAHUAN STANDAR LAPORAN PEMKO & BNPB -->
    <div class="mb-6 bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 text-white rounded-2xl p-6 shadow-md relative overflow-hidden">
        <div class="absolute -right-8 -bottom-8 w-44 h-44 bg-orange-500/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-500/20 text-orange-300 text-xs font-semibold uppercase tracking-wider mb-2 border border-orange-400/30">
                    <span>Dokumen Resmi Pusdalops-PB</span>
                </div>
                <h2 class="text-xl md:text-2xl font-black text-white">Pusat Cetak Laporan PDF Siap Tanda Tangan</h2>
                <p class="text-xs md:text-sm text-slate-300 mt-1 max-w-2xl">
                    Dokumen dicetak menggunakan format standar Kop Surat Pemerintah Kota Pekanbaru & BPBD, dilengkapi ringkasan dampak bencana, dokumentasi foto lapangan ber-caption, serta blok tanda tangan basah / stempel dinas Kepala Pelaksana BPBD.
                </p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm border border-white/15 rounded-xl p-3 text-xs text-slate-200 min-w-[260px]">
                <div class="font-bold text-orange-400 uppercase text-[10px] tracking-wider mb-1">Pejabat Penandatangan Aktif:</div>
                <div class="font-semibold text-white text-sm">{{ $pengaturan->nama_pimpinan ?? 'Zarman Candra, S.STP, M.Si' }}</div>
                <div class="text-slate-300">{{ $pengaturan->jabatan_pimpinan ?? 'Kepala Pelaksana BPBD Kota Pekanbaru' }}</div>
                <div class="text-[11px] text-slate-400 font-mono mt-0.5">NIP. {{ $pengaturan->nip_pimpinan ?? '19750510 199402 1 001' }}</div>
            </div>
        </div>
    </div>

    <!-- 2 PILIHAN DOKUMEN UTAMA -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        
        <!-- CARD 1: CETAK LEMBAR KEJADIAN TUNGGAL -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-50 dark:bg-orange-950/40 flex items-center justify-center text-orange-600 dark:text-orange-400 border border-orange-100 dark:border-orange-900/50 shadow-2xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-orange-100 dark:bg-orange-950/60 text-orange-800 dark:text-orange-300 uppercase tracking-wider">A4 Portrait</span>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Lembar Laporan Kejadian Tunggal</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Cetak 1 berkas kejadian lengkap dengan kronologi, tindakan regu TRC, dan foto dokumentasi.</p>
                    </div>
                </div>

                <div class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl p-4 mb-5 text-xs text-slate-600 dark:text-slate-400 space-y-2">
                    <div class="flex items-center gap-2 text-slate-700 dark:text-slate-300 font-semibold">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Kop Surat Resmi Pemko Pekanbaru & BPBD</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-700 dark:text-slate-300 font-semibold">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Rincian Kronologi & Operasi Penanganan Personel TRC</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-700 dark:text-slate-300 font-semibold">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Lampiran Foto Dokumentasi Penanganan di Lokasi</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-700 dark:text-slate-300 font-semibold">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Blok Tanda Tangan Petugas & Kalaksa BPBD</span>
                    </div>
                </div>

                <!-- FORM PILIH KEJADIAN -->
                <form id="formSinglePdf" target="_blank" onsubmit="event.preventDefault(); openSinglePdf();" class="space-y-4">
                    <div>
                        <label for="selectKejadianId" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">
                            Pilih Laporan Kejadian:
                        </label>
                        <select id="selectKejadianId" required class="w-full text-xs md:text-sm rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 focus:border-orange-500 focus:ring-orange-500 py-2.5">
                            <option value="">-- Pilih Nomor Laporan / Kejadian Bencana --</option>
                            @foreach($semuaKejadian as $k)
                                <option value="{{ $k->id }}">
                                    [{{ $k->nomor_laporan }}] {{ $k->jenisKejadian->nama ?? 'Bencana' }} - Kec. {{ $k->kecamatan->nama_kecamatan ?? '-' }} ({{ $k->tanggal_kejadian->format('d/m/Y') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:via-amber-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40 hover:-translate-y-0.5 active:translate-y-0 border border-orange-400/40 transition-all duration-200 flex items-center justify-center gap-2 text-sm cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Buka & Cetak PDF Kejadian</span>
                    </button>
                </form>

                <!-- 4 LAPORAN TERAKHIR CEPAT -->
                <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800">
                    <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Laporan Kejadian Terkini:</div>
                    <div class="space-y-2">
                        @foreach($semuaKejadian->take(4) as $item)
                            <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50 dark:bg-slate-950 hover:bg-slate-100 dark:hover:bg-slate-850 border border-slate-100 dark:border-slate-800 transition-colors text-xs">
                                <div class="truncate pr-2">
                                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $item->nomor_laporan }}</span>
                                    <span class="text-slate-500 dark:text-slate-400 ml-1">({{ $item->jenisKejadian->nama }})</span>
                                </div>
                                <a href="{{ route('laporan.pdf-single', $item->id) }}" target="_blank" class="px-2.5 py-1 bg-white dark:bg-slate-900 hover:bg-orange-50 dark:hover:bg-orange-950/50 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-800 font-semibold rounded-md shadow-2xs whitespace-nowrap text-[11px]">
                                    Cetak PDF
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 2: CETAK REKAPITULASI BERKALA (MULTI-LAPORAN) -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/40 flex items-center justify-center text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-900/50 shadow-2xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-blue-100 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300 uppercase tracking-wider">A4 Landscape</span>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Laporan Rekapitulasi Berkala</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Cetak rekap seluruh kejadian dalam rentang waktu tertentu untuk pelaporan ke pimpinan/BNPB.</p>
                    </div>
                </div>

                <div class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl p-4 mb-5 text-xs text-slate-600 dark:text-slate-400 space-y-2">
                    <div class="flex items-center gap-2 text-slate-700 dark:text-slate-300 font-semibold">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Tabel Rekapitulasi Multi-Kolom Lanskap A4</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-700 dark:text-slate-300 font-semibold">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Ringkasan Dampak Korban Jiwa, KK, & Luas Karhutla (Ha)</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-700 dark:text-slate-300 font-semibold">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Total Keseluruhan (Grand Total) Otomatis</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-700 dark:text-slate-300 font-semibold">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Format Resmi untuk Laporan Harian, Bulanan, atau Tahunan</span>
                    </div>
                </div>

                <!-- FORM FILTER PERIODE REKAP -->
                <form action="{{ route('laporan.pdf-rekap') }}" method="GET" target="_blank" class="space-y-4">
                    
                    <!-- PILIHAN MODE -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">
                            Pilih Periode Rekapitulasi:
                        </label>
                        <div class="grid grid-cols-4 gap-2 bg-slate-100 dark:bg-slate-800 p-1 rounded-xl">
                            <label class="cursor-pointer text-center">
                                <input type="radio" name="mode" value="bulanan" checked onchange="toggleModePdf(this.value)" class="peer sr-only">
                                <div class="py-1.5 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-300 peer-checked:bg-white dark:peer-checked:bg-slate-900 peer-checked:text-blue-900 dark:peer-checked:text-white peer-checked:shadow-xs transition-all">
                                    Bulanan
                                </div>
                            </label>
                            <label class="cursor-pointer text-center">
                                <input type="radio" name="mode" value="harian" onchange="toggleModePdf(this.value)" class="peer sr-only">
                                <div class="py-1.5 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-300 peer-checked:bg-white dark:peer-checked:bg-slate-900 peer-checked:text-blue-900 dark:peer-checked:text-white peer-checked:shadow-xs transition-all">
                                    Harian
                                </div>
                            </label>
                            <label class="cursor-pointer text-center">
                                <input type="radio" name="mode" value="tahunan" onchange="toggleModePdf(this.value)" class="peer sr-only">
                                <div class="py-1.5 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-300 peer-checked:bg-white dark:peer-checked:bg-slate-900 peer-checked:text-blue-900 dark:peer-checked:text-white peer-checked:shadow-xs transition-all">
                                    Tahunan
                                </div>
                            </label>
                            <label class="cursor-pointer text-center">
                                <input type="radio" name="mode" value="kustom" onchange="toggleModePdf(this.value)" class="peer sr-only">
                                <div class="py-1.5 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-300 peer-checked:bg-white dark:peer-checked:bg-slate-900 peer-checked:text-blue-900 dark:peer-checked:text-white peer-checked:shadow-xs transition-all">
                                    Kustom
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- INPUT SECTION: BULANAN (DEFAULT) -->
                    <div id="section-bulanan" class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Bulan:</label>
                            <select name="bulan" class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 py-2">
                                @php
                                    $namaBulan = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                @endphp
                                @foreach($namaBulan as $num => $nama)
                                    <option value="{{ $num }}" {{ now()->month == $num ? 'selected' : '' }}>{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Tahun:</label>
                            <select name="tahun" class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 py-2">
                                @foreach($tahunTersedia as $thn)
                                    <option value="{{ $thn }}" {{ now()->year == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- INPUT SECTION: HARIAN -->
                    <div id="section-harian" class="hidden">
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Pilih Tanggal:</label>
                        <input type="date" name="tanggal_harian" value="{{ now()->toDateString() }}" class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 py-2">
                    </div>

                    <!-- INPUT SECTION: TAHUNAN -->
                    <div id="section-tahunan" class="hidden">
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Pilih Tahun:</label>
                        <select name="tahun_only" class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 py-2">
                            @foreach($tahunTersedia as $thn)
                                <option value="{{ $thn }}" {{ now()->year == $thn ? 'selected' : '' }}>Tahun {{ $thn }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- INPUT SECTION: KUSTOM RENTANG -->
                    <div id="section-kustom" class="hidden grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Mulai Tanggal:</label>
                            <input type="date" name="tanggal_mulai" value="{{ now()->startOfMonth()->toDateString() }}" class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 py-2">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Sampai Tanggal:</label>
                            <input type="date" name="tanggal_selesai" value="{{ now()->toDateString() }}" class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 py-2">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 hover:from-blue-800 hover:via-indigo-800 hover:to-slate-800 text-white font-bold rounded-xl shadow-lg shadow-blue-900/25 hover:shadow-blue-900/40 hover:-translate-y-0.5 active:translate-y-0 border border-blue-700/40 transition-all duration-200 flex items-center justify-center gap-2 text-sm mt-4 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Cetak Rekapitulasi PDF (A4 Landscape)</span>
                    </button>
                </form>

                <!-- INFO PANDUAN PENCETAKAN -->
                <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-[11px] text-slate-400 dark:text-slate-500">
                    <span>Tips: Gunakan opsi cetak printer <strong>Fit to Page</strong></span>
                    <a href="{{ route('rekap.index') }}" class="text-blue-700 dark:text-blue-400 font-semibold hover:underline">
                        Lihat Tabel Rekap &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        function openSinglePdf() {
            const id = document.getElementById('selectKejadianId').value;
            if (!id) {
                alert('Silakan pilih salah satu laporan kejadian terlebih dahulu.');
                return;
            }
            const url = "{{ url('/laporan/pdf/kejadian') }}/" + id;
            window.open(url, '_blank');
        }

        function toggleModePdf(mode) {
            document.getElementById('section-bulanan').classList.add('hidden');
            document.getElementById('section-harian').classList.add('hidden');
            document.getElementById('section-tahunan').classList.add('hidden');
            document.getElementById('section-kustom').classList.add('hidden');

            if (mode === 'bulanan') {
                document.getElementById('section-bulanan').classList.remove('hidden');
            } else if (mode === 'harian') {
                document.getElementById('section-harian').classList.remove('hidden');
            } else if (mode === 'tahunan') {
                document.getElementById('section-tahunan').classList.remove('hidden');
            } else if (mode === 'kustom') {
                document.getElementById('section-kustom').classList.remove('hidden');
            }
        }
    </script>
    @endpush
</x-app-layout>