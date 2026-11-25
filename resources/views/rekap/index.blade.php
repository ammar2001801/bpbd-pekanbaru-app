<x-app-layout>
    <x-slot name="header">
        Rekapitulasi Bencana & Pelaporan
    </x-slot>

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">Rekapitulasi Kejadian Bencana</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400">Rekapitulasi berkala Pusdalops-PB Kota Pekanbaru: {{ $periodeJudul }}</p>
        </div>

        <!-- Tombol Aksi Ekspor -->
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <a href="{{ route('laporan.pdf-rekap', request()->all()) }}" target="_blank"
               class="flex-1 sm:flex-initial justify-center inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 hover:from-blue-800 hover:via-indigo-800 hover:to-slate-800 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-blue-900/25 hover:shadow-blue-900/40 hover:-translate-y-0.5 active:translate-y-0 border border-blue-700/40 transition-all duration-200">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak PDF</span>
            </a>

            <a href="{{ route('rekap.excel', request()->all()) }}" 
               class="flex-1 sm:flex-initial justify-center inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 hover:from-emerald-500 hover:via-teal-500 hover:to-emerald-600 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-emerald-600/25 hover:shadow-emerald-600/40 hover:-translate-y-0.5 active:translate-y-0 border border-emerald-500/40 transition-all duration-200">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Ekspor Excel</span>
            </a>
        </div>
    </div>

    <!-- FILTER PERIODE REKAPITULASI (TAB & CONTROLS) -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 sm:p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm mb-6" x-data="{ currentMode: '{{ $mode }}' }">
        <form method="GET" action="{{ route('rekap.index') }}" id="formRekap">
            
            <!-- Mode Selector Tabs (Modern Segmented Pill Capsule) -->
            <div class="flex items-center gap-1.5 p-1 bg-slate-100 dark:bg-slate-950/80 rounded-2xl border border-slate-200/80 dark:border-slate-800/80 max-w-full w-fit mb-5 overflow-x-auto shadow-inner">
                <label class="cursor-pointer shrink-0">
                    <input type="radio" name="mode" value="bulanan" x-model="currentMode" class="hidden" onchange="this.form.submit()">
                    <span :class="currentMode === 'bulanan' ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-md shadow-orange-500/25 font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-semibold'"
                          class="px-3.5 sm:px-4 py-2 rounded-xl text-xs transition-all inline-block select-none whitespace-nowrap">
                        Rekap Bulanan
                    </span>
                </label>

                <label class="cursor-pointer shrink-0">
                    <input type="radio" name="mode" value="harian" x-model="currentMode" class="hidden" onchange="this.form.submit()">
                    <span :class="currentMode === 'harian' ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-md shadow-orange-500/25 font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-semibold'"
                          class="px-3.5 sm:px-4 py-2 rounded-xl text-xs transition-all inline-block select-none whitespace-nowrap">
                        Rekap Harian
                    </span>
                </label>

                <label class="cursor-pointer shrink-0">
                    <input type="radio" name="mode" value="tahunan" x-model="currentMode" class="hidden" onchange="this.form.submit()">
                    <span :class="currentMode === 'tahunan' ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-md shadow-orange-500/25 font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-semibold'"
                          class="px-3.5 sm:px-4 py-2 rounded-xl text-xs transition-all inline-block select-none whitespace-nowrap">
                        Rekap Tahunan
                    </span>
                </label>

                <label class="cursor-pointer shrink-0">
                    <input type="radio" name="mode" value="kustom" x-model="currentMode" class="hidden" onchange="this.form.submit()">
                    <span :class="currentMode === 'kustom' ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-md shadow-orange-500/25 font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-semibold'"
                          class="px-3.5 sm:px-4 py-2 rounded-xl text-xs transition-all inline-block select-none whitespace-nowrap">
                        Rentang Tanggal
                    </span>
                </label>
            </div>

            <!-- Dynamic Input Sesuai Mode -->
            <div class="flex flex-wrap items-center gap-3">
                
                <!-- Input Mode Bulanan -->
                <template x-if="currentMode === 'bulanan'">
                    <div class="flex items-center gap-2">
                        <select name="bulan" class="px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-bold text-slate-800 dark:text-slate-100">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create(2026, $m, 1)->locale('id')->isoFormat('MMMM') }}
                                </option>
                            @endfor
                        </select>

                        <select name="tahun" class="px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-bold text-slate-800 dark:text-slate-100">
                            @foreach($tahunTersedia as $thn)
                                <option value="{{ $thn }}" {{ $tahun == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                            @endforeach
                        </select>
                    </div>
                </template>

                <!-- Input Mode Harian -->
                <template x-if="currentMode === 'harian'">
                    <div class="flex items-center gap-2">
                        <label class="text-xs font-semibold text-slate-600 dark:text-slate-400">Pilih Tanggal:</label>
                        <input type="date" name="tanggal_harian" value="{{ $tanggalHarian }}" 
                               class="px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-bold text-slate-800 dark:text-slate-100" />
                    </div>
                </template>

                <!-- Input Mode Tahunan -->
                <template x-if="currentMode === 'tahunan'">
                    <div class="flex items-center gap-2">
                        <label class="text-xs font-semibold text-slate-600 dark:text-slate-400">Pilih Tahun:</label>
                        <select name="tahun" class="px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-bold text-slate-800 dark:text-slate-100">
                            @foreach($tahunTersedia as $thn)
                                <option value="{{ $thn }}" {{ $tahun == $thn ? 'selected' : '' }}>Tahun {{ $thn }}</option>
                            @endforeach
                        </select>
                    </div>
                </template>

                <!-- Input Mode Kustom -->
                <template x-if="currentMode === 'kustom'">
                    <div class="flex items-center gap-2">
                        <input type="date" name="tanggal_mulai" value="{{ $tanggalMulai }}" 
                               class="px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-bold text-slate-800 dark:text-slate-100" />
                        <span class="text-xs font-bold text-slate-400">s/d</span>
                        <input type="date" name="tanggal_selesai" value="{{ $tanggalSelesai }}" 
                               class="px-3.5 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs font-bold text-slate-800 dark:text-slate-100" />
                    </div>
                </template>

                <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 dark:from-orange-500 dark:via-amber-500 dark:to-orange-600 hover:from-black hover:to-slate-900 dark:hover:from-orange-600 dark:hover:to-amber-600 text-white font-bold text-xs shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span>Tampilkan Rekap</span>
                </button>
            </div>
        </form>
    </div>

    <!-- 4 KARTU AGREGASI STATISTIK PERIODE -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-800 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-blue-600"></div>
            <span class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Total Kejadian</span>
            <span class="text-2xl sm:text-3xl font-black text-blue-900 dark:text-blue-400">{{ $totalKejadian }}</span>
            <span class="block text-[10px] text-slate-400 dark:text-slate-500 mt-1">Laporan Terverifikasi</span>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-800 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-rose-500"></div>
            <span class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Korban Jiwa & Luka</span>
            <div class="text-2xl sm:text-3xl font-black text-rose-600 dark:text-rose-400">
                {{ $totalMeninggal }} <span class="text-sm font-semibold text-slate-400 dark:text-slate-500">/ {{ $totalLuka }} Luka</span>
            </div>
            <span class="block text-[10px] text-slate-400 dark:text-slate-500 mt-1">Orang Terdampak</span>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-800 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-indigo-500"></div>
            <span class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">KK & Jiwa Terdampak</span>
            <div class="text-2xl sm:text-3xl font-black text-blue-700 dark:text-blue-400">
                {{ $totalKK }} <span class="text-sm font-semibold text-slate-400 dark:text-slate-500">KK ({{ $totalJiwa }} Jiwa)</span>
            </div>
            <span class="block text-[10px] text-slate-400 dark:text-slate-500 mt-1">Warga Terpapar</span>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-800 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-orange-500"></div>
            <span class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Karhutla & Hewan</span>
            <div class="text-2xl sm:text-3xl font-black text-amber-600 dark:text-amber-400">
                {{ number_format($totalLuasKarhutla, 1) }} <span class="text-sm font-semibold text-slate-400 dark:text-slate-500">Ha</span>
            </div>
            <span class="block text-[10px] text-slate-400 dark:text-slate-500 mt-1">{{ $totalHewan }} Operasi Animal Rescue</span>
        </div>
    </div>

    <!-- MATRIKS REKAPITULASI (KECAMATAN X JENIS BENCANA) -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Matriks Kejadian Berdasarkan Wilayah & Jenis Bencana</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Agregasi silang 15 Kecamatan resmi Kota Pekanbaru</p>
            </div>
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-2.5 py-1 rounded-lg">Cross-Tabulation Matrix</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-900 dark:bg-slate-950 text-white font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="px-3.5 py-3 w-10 text-center">No</th>
                        <th class="px-4 py-3 min-w-[140px]">Kecamatan</th>
                        @foreach($semuaJenis as $j)
                            <th class="px-2.5 py-3 text-center whitespace-nowrap" title="{{ $j->nama }}">
                                {{ $j->nama }}
                            </th>
                        @endforeach
                        <th class="px-3.5 py-3 text-center bg-orange-600 text-white font-black min-w-[70px]">TOTAL</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($semuaKecamatan as $idx => $kec)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition-colors {{ $totalPerKecamatan[$kec->id] > 0 ? 'bg-amber-50/20 dark:bg-amber-950/15' : '' }}">
                            <td class="px-3.5 py-2.5 text-center font-mono text-slate-400 dark:text-slate-500">{{ $idx + 1 }}</td>
                            <td class="px-4 py-2.5 font-bold text-slate-900 dark:text-slate-100">
                                Kec. {{ $kec->nama_kecamatan }}
                            </td>
                            @foreach($semuaJenis as $j)
                                @php $val = $matrix[$kec->id][$j->id] ?? 0; @endphp
                                <td class="px-2.5 py-2.5 text-center font-mono {{ $val > 0 ? 'font-bold text-orange-600 dark:text-orange-400 bg-orange-50/50 dark:bg-orange-950/30' : 'text-slate-300 dark:text-slate-700' }}">
                                    {{ $val > 0 ? $val : '-' }}
                                </td>
                            @endforeach
                            <td class="px-3.5 py-2.5 text-center font-mono font-black text-slate-900 dark:text-slate-100 bg-slate-100 dark:bg-slate-800">
                                {{ $totalPerKecamatan[$kec->id] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-slate-100 dark:bg-slate-950 font-black text-slate-900 dark:text-white border-t-2 border-slate-300 dark:border-slate-800">
                    <tr>
                        <td colspan="2" class="px-4 py-3 text-right uppercase tracking-wider">TOTAL KEJADIAN:</td>
                        @foreach($semuaJenis as $j)
                            <td class="px-2.5 py-3 text-center font-mono text-orange-600 dark:text-orange-400">
                                {{ $totalPerJenis[$j->id] }}
                            </td>
                        @endforeach
                        <td class="px-3.5 py-3 text-center font-mono text-base bg-orange-600 text-white font-black">
                            {{ $totalKejadian }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- TABEL RINCIAN SEMUA LAPORAN PADA PERIODE INI -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Daftar Laporan Terperinci ({{ $totalKejadian }} Laporan)</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Rincian data kejadian yang masuk dalam periode {{ $periodeJudul }}</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-50 dark:bg-slate-950 text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider border-b border-slate-200 dark:border-slate-800 text-[10px]">
                    <tr>
                        <th class="px-4 py-3 text-center">No</th>
                        <th class="px-4 py-3">Nomor Laporan</th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Jenis Bencana</th>
                        <th class="px-4 py-3">Wilayah & Lokasi</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($daftarKejadian as $i => $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors">
                            <td class="px-4 py-3 text-center font-mono text-slate-400 dark:text-slate-500">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 font-mono font-bold text-blue-900 dark:text-blue-400">{{ $item->nomor_laporan }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="font-bold text-slate-800 dark:text-slate-200">{{ $item->tanggal_kejadian->format('d/m/Y') }}</div>
                                <div class="text-slate-400 dark:text-slate-500 font-mono">{{ substr($item->jam_kejadian, 0, 5) }} WIB</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold text-white inline-block" style="background-color: {{ $item->jenisKejadian->warna }};">
                                    {{ $item->jenisKejadian->nama }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-bold text-slate-800 dark:text-slate-200">Kec. {{ $item->kecamatan->nama_kecamatan }}</div>
                                <div class="text-slate-500 dark:text-slate-400 truncate max-w-xs">{{ $item->lokasi_detail }}</div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($item->status === 'Selesai')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">Selesai</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-950/50 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800">Penanganan</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('kejadian.show', $item->id) }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-orange-500 hover:text-white dark:hover:bg-orange-500 dark:hover:text-white text-slate-700 dark:text-slate-200 font-bold transition-all shadow-2xs">
                                    <span>Detail</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400 dark:text-slate-500">
                                Tidak ada laporan kejadian pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
