<x-app-layout>
    <x-slot name="header">
        Data Kejadian Bencana & Rekapitulasi Laporan
    </x-slot>

    <!-- Header Actions & Title -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">Daftar Kejadian Bencana</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400">Pencatatan rekapitulasi data darurat dan bencana di wilayah Kota Pekanbaru.</p>
        </div>

        <div class="flex items-center gap-2.5">
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-900 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                Total: <strong class="text-slate-900 dark:text-white font-mono">{{ $kejadian->total() }}</strong> Laporan
            </span>

            @if(Auth::user()->role !== 'pimpinan')
            <a href="{{ route('kejadian.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:via-amber-600 hover:to-orange-700 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40 hover:-translate-y-0.5 active:translate-y-0 border border-orange-400/40 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Input Kejadian Baru</span>
            </a>
            @endif
        </div>
    </div>

    <!-- FILTER & PENCARIAN CARD -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm mb-6" x-data="{ advancedFilter: false }">
        <form method="GET" action="{{ route('kejadian.index') }}" class="space-y-4">
            
            <!-- Baris 1: Pencarian Keyword & Filter Cepat -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- Search Input -->
                <div class="lg:col-span-2 relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nomor laporan, lokasi jalan, kronologi, sumber..."
                           class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" />
                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                <!-- Filter Jenis Kejadian -->
                <div>
                    <select name="jenis_id" 
                            class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs sm:text-sm text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">-- Semua Jenis Bencana --</option>
                        @foreach($jenisList as $jenis)
                            <option value="{{ $jenis->id }}" {{ request('jenis_id') == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Status -->
                <div>
                    <select name="status" 
                            class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs sm:text-sm text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 font-medium">
                        <option value="">-- Semua Status --</option>
                        <option value="Dalam Penanganan" {{ request('status') === 'Dalam Penanganan' ? 'selected' : '' }}>Dalam Penanganan</option>
                        <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
            </div>

            <!-- Baris 2: Filter Tambahan (Kecamatan & Rentang Tanggal) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 border-t border-slate-100 dark:border-slate-800">
                <!-- Filter Kecamatan -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Kecamatan</label>
                    <select name="kecamatan_id" 
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">-- Semua Kecamatan Kota Pekanbaru --</option>
                        @foreach($kecamatanList as $kec)
                            <option value="{{ $kec->id }}" {{ request('kecamatan_id') == $kec->id ? 'selected' : '' }}>
                                Kec. {{ $kec->nama_kecamatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Mulai -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Dari Tanggal</label>
                    <input type="date" 
                           name="tanggal_mulai" 
                           value="{{ request('tanggal_mulai') }}" 
                           class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" />
                </div>

                <!-- Tanggal Selesai -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Sampai Tanggal</label>
                    <input type="date" 
                           name="tanggal_selesai" 
                           value="{{ request('tanggal_selesai') }}" 
                           class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-xs text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" />
                </div>
            </div>

            <!-- Tombol Submit & Reset Filter -->
            <div class="flex items-center justify-between pt-2">
                <div class="text-[11px] text-slate-500 dark:text-slate-400">
                    @if(request()->anyFilled(['search', 'jenis_id', 'kecamatan_id', 'status', 'tanggal_mulai', 'tanggal_selesai']))
                        <span class="inline-flex items-center gap-1 text-orange-600 dark:text-orange-400 font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span> Filter aktif diterapkan
                        </span>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    @if(request()->anyFilled(['search', 'jenis_id', 'kecamatan_id', 'status', 'tanggal_mulai', 'tanggal_selesai']))
                        <a href="{{ route('kejadian.index') }}" 
                           class="px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 font-bold text-xs hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                            Reset Filter
                        </a>
                    @endif
                    <button type="submit" 
                            class="px-4 py-2 rounded-xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 dark:from-orange-500 dark:via-amber-500 dark:to-orange-600 hover:from-black hover:to-slate-900 dark:hover:from-orange-600 dark:hover:to-amber-600 text-white font-bold text-xs flex items-center gap-1.5 shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Terapkan Filter</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- TABEL DATA KEJADIAN -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700 dark:text-slate-200">
                <thead class="bg-slate-50 dark:bg-slate-950 text-slate-500 dark:text-slate-400 text-[11px] font-bold uppercase tracking-wider border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="px-5 py-3.5 w-12 text-center">No</th>
                        <th class="px-5 py-3.5">Nomor Laporan</th>
                        <th class="px-5 py-3.5">Waktu</th>
                        <th class="px-5 py-3.5">Jenis Bencana</th>
                        <th class="px-5 py-3.5">Wilayah & TKP</th>
                        <th class="px-5 py-3.5">Dampak / Detail</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5 text-center">Foto</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($kejadian as $index => $item)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition-colors">
                            <!-- No Urut -->
                            <td class="px-5 py-4 text-center text-xs font-mono text-slate-400 dark:text-slate-500">
                                {{ $kejadian->firstItem() + $index }}
                            </td>

                            <!-- Nomor Laporan -->
                            <td class="px-5 py-4 font-mono font-bold text-xs text-blue-950 dark:text-blue-400 whitespace-nowrap">
                                <a href="{{ route('kejadian.show', $item->id) }}" class="hover:text-orange-600 dark:hover:text-orange-400 transition-colors">
                                    {{ $item->nomor_laporan }}
                                </a>
                                <div class="text-[10px] text-slate-400 dark:text-slate-500 font-sans mt-0.5">
                                    Oleh: {{ $item->user->name ?? 'Pusdalops' }}
                                </div>
                            </td>

                            <!-- Waktu Kejadian -->
                            <td class="px-5 py-4 text-xs whitespace-nowrap">
                                <div class="font-bold text-slate-800 dark:text-slate-200">{{ $item->tanggal_kejadian->format('d/m/Y') }}</div>
                                <div class="text-slate-500 dark:text-slate-400 font-mono">{{ substr($item->jam_kejadian, 0, 5) }} WIB</div>
                            </td>

                            <!-- Jenis Kejadian -->
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold"
                                      style="background-color: {{ $item->jenisKejadian->warna }}18; color: {{ $item->jenisKejadian->warna }};">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $item->jenisKejadian->warna }};"></span>
                                    {{ $item->jenisKejadian->nama }}
                                </span>
                            </td>

                            <!-- Wilayah & Lokasi Detail -->
                            <td class="px-5 py-4 text-xs max-w-xs">
                                <div class="font-bold text-slate-800 dark:text-slate-200">
                                    Kec. {{ $item->kecamatan->nama_kecamatan }}
                                    @if($item->kelurahan)
                                        <span class="text-slate-500 dark:text-slate-400 font-normal">({{ $item->kelurahan->nama_kelurahan }})</span>
                                    @endif
                                </div>
                                <div class="text-slate-500 dark:text-slate-400 truncate" title="{{ $item->lokasi_detail }}">
                                    {{ $item->lokasi_detail }}
                                </div>
                            </td>

                            <!-- Dampak / Detail Khusus -->
                            <td class="px-5 py-4 text-xs">
                                @if($item->luas_terbakar_ha)
                                    <span class="inline-block px-2 py-0.5 rounded bg-amber-50 dark:bg-amber-950/50 border border-amber-200 dark:border-amber-800 text-amber-800 dark:text-amber-300 font-bold text-[11px]">
                                        {{ $item->luas_terbakar_ha }} Ha
                                    </span>
                                @elseif($item->detail_hewan)
                                    <span class="text-purple-700 dark:text-purple-400 font-semibold text-[11px] truncate block max-w-[150px]" title="{{ $item->detail_hewan }}">
                                        {{ $item->detail_hewan }}
                                    </span>
                                @elseif($item->kk_terdampak > 0)
                                    <span class="text-blue-700 dark:text-blue-400 font-semibold text-[11px]">
                                        {{ $item->kk_terdampak }} KK / {{ $item->jiwa_terdampak }} Jiwa
                                    </span>
                                @else
                                    <span class="text-slate-400 dark:text-slate-500 text-[11px]">-</span>
                                @endif
                            </td>

                            <!-- Status Penanganan -->
                            <td class="px-5 py-4 text-center whitespace-nowrap">
                                @if($item->status === 'Selesai')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                        Selesai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 dark:bg-amber-950/50 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span>
                                        <span>Dalam Penanganan</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Jumlah Foto -->
                            <td class="px-5 py-4 text-center whitespace-nowrap">
                                @if($item->foto->count() > 0)
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-lg">
                                        <svg class="w-3.5 h-3.5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>{{ $item->foto->count() }}</span>
                                    </span>
                                @else
                                    <span class="text-slate-400 dark:text-slate-500 text-xs">-</span>
                                @endif
                            </td>

                            <!-- Tombol Aksi -->
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- Detail -->
                                    <a href="{{ route('kejadian.show', $item->id) }}" 
                                       title="Lihat Rincian Laporan"
                                       class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white border border-blue-200/60 dark:border-blue-800/60 flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-md hover:scale-105 active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    <!-- Edit (Admin atau Pembuat) -->
                                    @if(Auth::user()->isAdmin() || (Auth::user()->isPetugas() && $item->user_id === Auth::id()))
                                    <a href="{{ route('kejadian.edit', $item->id) }}" 
                                       title="Edit Laporan"
                                       class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 hover:bg-amber-500 hover:text-white dark:hover:bg-amber-500 dark:hover:text-white border border-amber-200/60 dark:border-amber-800/60 flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-md hover:scale-105 active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <!-- Hapus (Soft Delete) -->
                                    <form method="POST" action="{{ route('kejadian.destroy', $item->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan {{ $item->nomor_laporan }}? Data dapat dipulihkan oleh Administrator.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                title="Hapus Laporan"
                                                class="w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white dark:hover:bg-rose-600 dark:hover:text-white border border-rose-200/60 dark:border-rose-800/60 flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-md hover:scale-105 active:scale-95 cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-slate-400 dark:text-slate-500">
                                <svg class="w-10 h-10 mx-auto text-slate-300 dark:text-slate-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <div class="font-bold text-slate-700 dark:text-slate-300 text-sm">Tidak Ada Laporan Kejadian yang Ditemukan</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian atau bersihkan filter yang diterapkan.</div>
                                <a href="{{ route('kejadian.index') }}" class="inline-block mt-3 text-xs font-bold text-orange-600 dark:text-orange-400 hover:underline">
                                    Reset Semua Filter
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950">
            {{ $kejadian->links() }}
        </div>
    </div>
</x-app-layout>
