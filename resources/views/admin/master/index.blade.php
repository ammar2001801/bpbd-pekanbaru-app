<x-app-layout>
    <x-slot name="header">
        Master Data Wilayah & Kejadian
    </x-slot>

    <div x-data="{
        currentTab: '{{ $activeTab }}',
        showAddJenis: false,
        showEditJenis: false,
        editJenis: { id: null, nama: '', warna: '#EA580C', ikon: 'alert-triangle', keterangan: '' },
        showAddInstansi: false,
        showEditInstansi: false,
        editInstansi: { id: null, nama_instansi: '', kontak: '' },
        showAddKelurahan: false,
        
        openEditJenis(j) {
            this.editJenis = { ...j };
            this.showEditJenis = true;
        },
        openEditInstansi(i) {
            this.editInstansi = { ...i };
            this.showEditInstansi = true;
        }
    }">

        <!-- PAGE HEADER & SUMMARY BADGES -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">Master Data & Wilayah Administratif</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kelola klasifikasi jenis bencana, instansi mitra gabungan, serta data wilayah kecamatan & kelurahan Kota Pekanbaru.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-900 px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                    <span><strong class="text-slate-900 dark:text-white font-mono">{{ $jenisList->count() }}</strong> Jenis</span>
                </span>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-900 px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <span><strong class="text-slate-900 dark:text-white font-mono">{{ $instansiList->count() }}</strong> Mitra</span>
                </span>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-900 px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span><strong class="text-slate-900 dark:text-white font-mono">15</strong> Kecamatan</span>
                </span>
            </div>
        </div>

        <!-- TABS NAVIGASI MASTER DATA (MODERN SEGMENTED CAPSULE) -->
        <div class="flex items-center gap-1.5 p-1.5 bg-slate-200/70 dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 max-w-full w-fit mb-6 overflow-x-auto shadow-inner">
            <button @click="currentTab = 'jenis'" 
                    :class="currentTab === 'jenis' ? 'bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 text-white shadow-md shadow-orange-500/25 font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-800/60 font-semibold'"
                    class="px-4 py-2.5 rounded-xl text-xs transition-all duration-200 flex items-center gap-2 whitespace-nowrap cursor-pointer select-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                <span>Jenis Kejadian Bencana</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] font-mono" :class="currentTab === 'jenis' ? 'bg-white/20 text-white' : 'bg-slate-300/70 dark:bg-slate-800 text-slate-700 dark:text-slate-300'">{{ $jenisList->count() }}</span>
            </button>

            <button @click="currentTab = 'instansi'" 
                    :class="currentTab === 'instansi' ? 'bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 text-white shadow-md shadow-orange-500/25 font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-800/60 font-semibold'"
                    class="px-4 py-2.5 rounded-xl text-xs transition-all duration-200 flex items-center gap-2 whitespace-nowrap cursor-pointer select-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span>Instansi Pendukung / Mitra</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] font-mono" :class="currentTab === 'instansi' ? 'bg-white/20 text-white' : 'bg-slate-300/70 dark:bg-slate-800 text-slate-700 dark:text-slate-300'">{{ $instansiList->count() }}</span>
            </button>

            <button @click="currentTab = 'wilayah'" 
                    :class="currentTab === 'wilayah' ? 'bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 text-white shadow-md shadow-orange-500/25 font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-800/60 font-semibold'"
                    class="px-4 py-2.5 rounded-xl text-xs transition-all duration-200 flex items-center gap-2 whitespace-nowrap cursor-pointer select-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Wilayah (15 Kecamatan & Kelurahan)</span>
            </button>
        </div>

        <!-- ================= TAB 1: JENIS KEJADIAN BENCANA ================= -->
        <div x-show="currentTab === 'jenis'" class="space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">Daftar Jenis Kejadian Bencana & Kedaruratan</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kategori bencana yang digunakan untuk filter, klasifikasi form input, serta pewarnaan grafik & peta.</p>
                </div>
                <button @click="showAddJenis = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:via-amber-600 hover:to-orange-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40 hover:-translate-y-0.5 active:translate-y-0 border border-orange-400/40 transition-all duration-200 cursor-pointer shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Jenis</span>
                </button>
            </div>

            <!-- GRID KARTU JENIS KEJADIAN -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($jenisList as $j)
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-2xs flex flex-col justify-between hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                        <div class="absolute top-0 left-0 right-0 h-1.5" style="background-color: {{ $j->warna }};"></div>
                        
                        <div>
                            <div class="flex items-start justify-between gap-2 mt-1 mb-2.5">
                                <span class="font-bold text-sm text-slate-800 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">{{ $j->nama }}</span>
                                <span class="w-5 h-5 rounded-full flex-shrink-0 border-2 border-white dark:border-slate-800 shadow-xs" style="background-color: {{ $j->warna }};" title="Kode Warna: {{ $j->warna }}"></span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mb-4 leading-relaxed">
                                {{ $j->keterangan ?? 'Klasifikasi bencana BPBD Kota Pekanbaru' }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-semibold text-[11px]">
                                <span>Terpakai:</span>
                                <strong class="text-slate-900 dark:text-white font-mono">{{ $j->kejadian_count }}</strong>
                            </span>
                            <div class="flex items-center gap-1.5">
                                <button @click="openEditJenis({{ json_encode($j) }})" class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white border border-blue-200/60 dark:border-blue-800/60 flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-md hover:scale-105 cursor-pointer" title="Edit Jenis">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                @if($j->kejadian_count === 0)
                                    <form method="POST" action="{{ route('admin.master.jenis.destroy', $j->id) }}" onsubmit="return confirm('Hapus jenis kejadian {{ $j->nama }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white dark:hover:bg-rose-600 dark:hover:text-white border border-rose-200/60 dark:border-rose-800/60 flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-md hover:scale-105 cursor-pointer" title="Hapus Jenis">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- ================= TAB 2: INSTANSI PENDUKUNG ================= -->
        <div x-show="currentTab === 'instansi'" class="space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">Daftar Instansi / Mitra Operasi PB</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Instansi stakeholder gabungan yang terlibat dalam penanganan kedaruratan (TNI, Polri, Damkar, Basarnas, dll).</p>
                </div>
                <button @click="showAddInstansi = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:via-amber-600 hover:to-orange-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40 hover:-translate-y-0.5 active:translate-y-0 border border-orange-400/40 transition-all duration-200 cursor-pointer shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Instansi</span>
                </button>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-950/80 border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 uppercase font-bold text-[11px] tracking-wider">
                        <tr>
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4">Nama Instansi / Lembaga</th>
                            <th class="py-3.5 px-4">Kontak / Call Center</th>
                            <th class="py-3.5 px-4 text-center">Keterlibatan Laporan</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @foreach($instansiList as $idx => $inst)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="py-3.5 px-4 text-center text-slate-400 font-mono font-bold">{{ $idx + 1 }}</td>
                                <td class="py-3.5 px-4 font-bold text-slate-800 dark:text-white">{{ $inst->nama_instansi }}</td>
                                <td class="py-3.5 px-4 text-slate-500 dark:text-slate-400 font-mono">{{ $inst->kontak ?? '-' }}</td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 font-bold text-slate-700 dark:text-slate-300 text-[11px]">
                                        {{ $inst->kejadian_count }} kejadian
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button @click="openEditInstansi({{ json_encode($inst) }})" class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white border border-blue-200/60 dark:border-blue-800/60 flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-md hover:scale-105 cursor-pointer" title="Edit Instansi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        @if($inst->kejadian_count === 0)
                                            <form method="POST" action="{{ route('admin.master.instansi.destroy', $inst->id) }}" onsubmit="return confirm('Hapus instansi {{ $inst->nama_instansi }}?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white dark:hover:bg-rose-600 dark:hover:text-white border border-rose-200/60 dark:border-rose-800/60 flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-md hover:scale-105 cursor-pointer" title="Hapus Instansi">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ================= TAB 3: WILAYAH (15 KECAMATAN & KELURAHAN) ================= -->
        <div x-show="currentTab === 'wilayah'" class="space-y-6">
            
            <!-- Banner Resmi Pemko Pekanbaru -->
            <div class="bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900/60 rounded-2xl p-4 text-xs text-blue-900 dark:text-blue-200 flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <div class="font-bold uppercase tracking-wide text-[11px]">Data Wilayah Administratif Kota Pekanbaru</div>
                    <div class="text-blue-800 dark:text-blue-300 mt-0.5">
                        Daftar 15 Kecamatan resmi berdasarkan <strong>Perda Kota Pekanbaru Nomor 2 Tahun 2020</strong> (Pemekaran Wilayah Baru: Rumbai Barat, Rumbai Timur, Tuah Madani, Kulim, dsb). Data master wilayah terkunci sesuai regulasi resmi Pemko Pekanbaru.
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Kolom Kiri (1 Kolom): Daftar 15 Kecamatan -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-4">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-white mb-3 flex items-center justify-between">
                        <span>15 Kecamatan Pekanbaru</span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">Perda 2/2020</span>
                    </h4>
                    <div class="space-y-1.5 max-h-[500px] overflow-y-auto pr-1">
                        @foreach($kecamatanList as $kec)
                            <a href="{{ route('admin.master.index', ['tab' => 'wilayah', 'kecamatan_id' => $kec->id]) }}" 
                               class="flex items-center justify-between p-2.5 rounded-xl border text-xs transition-colors {{ $selectedKecamatanId == $kec->id ? 'bg-orange-50 dark:bg-orange-950/50 border-orange-300 dark:border-orange-800 text-orange-900 dark:text-orange-300 font-bold' : 'bg-slate-50/70 dark:bg-slate-950/50 border-slate-100 dark:border-slate-800/80 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300' }}">
                                <span>Kec. {{ $kec->nama_kecamatan }}</span>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 font-mono">
                                        {{ $kec->kelurahan_count }} Kel.
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Kolom Kanan (2 Kolom): Kelurahan & Tambah Kelurahan -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                            <div>
                                <h4 class="font-bold text-sm text-slate-800 dark:text-white">
                                    Daftar Kelurahan 
                                    @if($selectedKecamatanId)
                                        <span class="text-orange-600 dark:text-orange-400">(Kecamatan {{ $kecamatanList->find($selectedKecamatanId)->nama_kecamatan ?? '' }})</span>
                                    @endif
                                </h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Kelurahan yang digunakan untuk dependent dropdown saat penginputan laporan kejadian.</p>
                            </div>

                            <button @click="showAddKelurahan = true" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:via-amber-600 hover:to-orange-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-md shadow-orange-500/25 hover:shadow-orange-500/40 hover:-translate-y-0.5 active:translate-y-0 border border-orange-400/40 transition-all duration-200 self-start sm:self-auto cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                <span>Tambah Kelurahan</span>
                            </button>
                        </div>

                        <!-- Filter Pilih Kecamatan Dropdown -->
                        <div class="mb-4">
                            <form method="GET" action="{{ route('admin.master.index') }}">
                                <input type="hidden" name="tab" value="wilayah">
                                <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Filter Berdasarkan Kecamatan:</label>
                                <select name="kecamatan_id" onchange="this.form.submit()" class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white focus:border-orange-500 focus:ring-orange-500 py-2">
                                    <option value="">-- Tampilkan Seluruh Kelurahan di Kota Pekanbaru --</option>
                                    @foreach($kecamatanList as $k)
                                        <option value="{{ $k->id }}" {{ $selectedKecamatanId == $k->id ? 'selected' : '' }}>
                                            Kecamatan {{ $k->nama_kecamatan }} ({{ $k->kelurahan_count }} Kelurahan)
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <!-- Tabel Kelurahan -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50 dark:bg-slate-950/80 border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 uppercase font-semibold text-[10px]">
                                    <tr>
                                        <th class="py-2.5 px-3">Nama Kelurahan</th>
                                        <th class="py-2.5 px-3">Kecamatan</th>
                                        <th class="py-2.5 px-3 text-center">Kode Pos</th>
                                        <th class="py-2.5 px-3 text-center">Kejadian</th>
                                        <th class="py-2.5 px-3 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                                    @forelse($kelurahanList as $kel)
                                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                            <td class="py-2.5 px-3 font-bold text-slate-800 dark:text-white">Kel. {{ $kel->nama_kelurahan }}</td>
                                            <td class="py-2.5 px-3 text-slate-500 dark:text-slate-400">Kec. {{ $kel->kecamatan->nama_kecamatan ?? '-' }}</td>
                                            <td class="py-2.5 px-3 text-center font-mono text-slate-400 dark:text-slate-500">{{ $kel->kode_pos ?? '-' }}</td>
                                            <td class="py-2.5 px-3 text-center">
                                                <span class="px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-semibold text-[10px]">
                                                    {{ $kel->kejadian_count }}
                                                </span>
                                            </td>
                                            <td class="py-2.5 px-3 text-right">
                                                @if($kel->kejadian_count === 0)
                                                    <form method="POST" action="{{ route('admin.master.kelurahan.destroy', $kel->id) }}" onsubmit="return confirm('Hapus kelurahan {{ $kel->nama_kelurahan }}?');" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-7 h-7 rounded-lg bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white dark:hover:bg-rose-600 dark:hover:text-white border border-rose-200/60 dark:border-rose-800/60 inline-flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-md hover:scale-105 cursor-pointer" title="Hapus Kelurahan">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-6 text-center text-slate-400 italic">
                                                Tidak ada kelurahan yang terdaftar pada filter ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($kelurahanList->hasPages())
                            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800">
                                {{ $kelurahanList->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= MODAL TAMBAH JENIS ================= -->
        <div x-show="showAddJenis" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4" x-cloak>
            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">Tambah Jenis Kejadian</h3>
                    <button @click="showAddJenis = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 font-bold">&times;</button>
                </div>
                <form method="POST" action="{{ route('admin.master.jenis.store') }}" class="space-y-3.5">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1 flex items-center justify-between">
                            <span>Nama Jenis Kejadian <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <input type="text" name="nama" required 
                               oninvalid="this.setCustomValidity('Nama jenis kejadian harap diisi')"
                               oninput="this.setCustomValidity('')"
                               placeholder="Contoh: Tanah Longsor" class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white py-2 focus:border-orange-500 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Warna Penanda Label/Peta *</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="warna" value="#EA580C" class="h-10 w-16 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 cursor-pointer">
                            <span class="text-xs text-slate-500 dark:text-slate-400">Pilih warna untuk titik pada peta dan badge</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Keterangan / Deskripsi Singkat</label>
                        <textarea name="keterangan" rows="2" class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white py-2 focus:border-orange-500 focus:ring-orange-500"></textarea>
                    </div>
                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" @click="showAddJenis = false" class="px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors cursor-pointer">Batal</button>
                        <button type="submit" class="px-5 py-2 text-xs font-bold bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:to-amber-600 text-white rounded-xl shadow-md shadow-orange-500/25 transition-all cursor-pointer">Simpan Jenis</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ================= MODAL EDIT JENIS ================= -->
        <div x-show="showEditJenis" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4" x-cloak>
            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">Edit Jenis Kejadian</h3>
                    <button @click="showEditJenis = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 font-bold">&times;</button>
                </div>
                <form :action="'{{ url('admin/master/jenis') }}/' + editJenis.id" method="POST" class="space-y-3.5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1 flex items-center justify-between">
                            <span>Nama Jenis Kejadian <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <input type="text" name="nama" x-model="editJenis.nama" required 
                               oninvalid="this.setCustomValidity('Nama jenis kejadian harap diisi')"
                               oninput="this.setCustomValidity('')"
                               class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white py-2 focus:border-orange-500 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Warna Penanda Label/Peta *</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="warna" x-model="editJenis.warna" class="h-10 w-16 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 cursor-pointer">
                            <span class="text-xs text-slate-500 dark:text-slate-400">Pilih warna untuk titik pada peta dan badge</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Keterangan / Deskripsi Singkat</label>
                        <textarea name="keterangan" x-model="editJenis.keterangan" rows="2" class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white py-2 focus:border-orange-500 focus:ring-orange-500"></textarea>
                    </div>
                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" @click="showEditJenis = false" class="px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors cursor-pointer">Batal</button>
                        <button type="submit" class="px-5 py-2 text-xs font-bold bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 hover:from-blue-800 hover:to-indigo-800 text-white rounded-xl shadow-md shadow-blue-900/25 transition-all cursor-pointer">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ================= MODAL TAMBAH INSTANSI ================= -->
        <div x-show="showAddInstansi" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4" x-cloak>
            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">Tambah Instansi Pendukung</h3>
                    <button @click="showAddInstansi = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 font-bold">&times;</button>
                </div>
                <form method="POST" action="{{ route('admin.master.instansi.store') }}" class="space-y-3.5">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1 flex items-center justify-between">
                            <span>Nama Instansi / Lembaga <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <input type="text" name="nama_instansi" required 
                               oninvalid="this.setCustomValidity('Nama instansi atau lembaga mitra harap diisi')"
                               oninput="this.setCustomValidity('')"
                               placeholder="Contoh: Polresta Pekanbaru" class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white py-2 focus:border-orange-500 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Kontak / Call Center (Opsional)</label>
                        <input type="text" name="kontak" placeholder="Contoh: 110 / 0812-xxxx" class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white py-2 focus:border-orange-500 focus:ring-orange-500">
                    </div>
                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" @click="showAddInstansi = false" class="px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors cursor-pointer">Batal</button>
                        <button type="submit" class="px-5 py-2 text-xs font-bold bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:to-amber-600 text-white rounded-xl shadow-md shadow-orange-500/25 transition-all cursor-pointer">Simpan Instansi</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ================= MODAL EDIT INSTANSI ================= -->
        <div x-show="showEditInstansi" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4" x-cloak>
            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">Edit Instansi Pendukung</h3>
                    <button @click="showEditInstansi = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 font-bold">&times;</button>
                </div>
                <form :action="'{{ url('admin/master/instansi') }}/' + editInstansi.id" method="POST" class="space-y-3.5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1 flex items-center justify-between">
                            <span>Nama Instansi / Lembaga <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <input type="text" name="nama_instansi" x-model="editInstansi.nama_instansi" required 
                               oninvalid="this.setCustomValidity('Nama instansi atau lembaga mitra harap diisi')"
                               oninput="this.setCustomValidity('')"
                               class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white py-2 focus:border-orange-500 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Kontak / Call Center</label>
                        <input type="text" name="kontak" x-model="editInstansi.kontak" class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white py-2 focus:border-orange-500 focus:ring-orange-500">
                    </div>
                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" @click="showEditInstansi = false" class="px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors cursor-pointer">Batal</button>
                        <button type="submit" class="px-5 py-2 text-xs font-bold bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 hover:from-blue-800 hover:to-indigo-800 text-white rounded-xl shadow-md shadow-blue-900/25 transition-all cursor-pointer">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ================= MODAL TAMBAH KELURAHAN ================= -->
        <div x-show="showAddKelurahan" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4" x-cloak>
            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">Tambah Kelurahan Baru</h3>
                    <button @click="showAddKelurahan = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 font-bold">&times;</button>
                </div>
                <form method="POST" action="{{ route('admin.master.kelurahan.store') }}" class="space-y-3.5">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1 flex items-center justify-between">
                            <span>Kecamatan <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <select name="kecamatan_id" required 
                                oninvalid="this.setCustomValidity('Kecamatan wilayah harap dipilih')"
                                oninput="this.setCustomValidity('')"
                                class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white py-2 focus:border-orange-500 focus:ring-orange-500">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($kecamatanList as $k)
                                <option value="{{ $k->id }}" {{ $selectedKecamatanId == $k->id ? 'selected' : '' }}>
                                    Kecamatan {{ $k->nama_kecamatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1 flex items-center justify-between">
                            <span>Nama Kelurahan <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <input type="text" name="nama_kelurahan" required 
                               oninvalid="this.setCustomValidity('Nama kelurahan harap diisi')"
                               oninput="this.setCustomValidity('')"
                               placeholder="Contoh: Tangkerang Labuai" class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white py-2 focus:border-orange-500 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Kode Pos (Opsional)</label>
                        <input type="text" name="kode_pos" placeholder="Contoh: 28282" class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white py-2 focus:border-orange-500 focus:ring-orange-500">
                    </div>
                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" @click="showAddKelurahan = false" class="px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors cursor-pointer">Batal</button>
                        <button type="submit" class="px-5 py-2 text-xs font-bold bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:to-amber-600 text-white rounded-xl shadow-md shadow-orange-500/25 transition-all cursor-pointer">Simpan Kelurahan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
