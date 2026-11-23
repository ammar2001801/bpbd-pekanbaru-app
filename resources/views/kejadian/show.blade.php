<x-app-layout>
    <x-slot name="header">
        Detail Laporan Kejadian {{ $kejadian->nomor_laporan }}
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-6" x-data="{ lightboxOpen: false, activeImage: '', activeCaption: '' }">
        
        <!-- Header & Action Buttons -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
            <div>
                <a href="{{ route('kejadian.index') }}" class="text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white flex items-center gap-1 mb-1.5 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Daftar Kejadian
                </a>
                <div class="flex flex-wrap items-center gap-2.5">
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white font-mono tracking-tight">{{ $kejadian->nomor_laporan }}</h2>
                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold text-white" style="background-color: {{ $kejadian->jenisKejadian->warna }};">
                        {{ $kejadian->jenisKejadian->nama }}
                    </span>
                    @if($kejadian->status === 'Selesai')
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            Selesai
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/50 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                            Dalam Penanganan
                        </span>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                <!-- Cetak PDF Single -->
                <a href="{{ route('laporan.pdf-single', $kejadian->id) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 hover:from-blue-800 hover:to-indigo-800 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-blue-900/25 hover:shadow-blue-900/40 hover:-translate-y-0.5 active:translate-y-0 border border-blue-700/40 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Cetak PDF</span>
                </a>

                @if(Auth::user()->isAdmin() || (Auth::user()->isPetugas() && $kejadian->user_id === Auth::id()))
                <a href="{{ route('kejadian.edit', $kejadian->id) }}" 
                   class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:to-amber-600 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40 hover:-translate-y-0.5 active:translate-y-0 border border-orange-400/40 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Edit Laporan</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Main Content 2 Columns -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- KOLOM KIRI (2 Kolom): RINCIAN LAPORAN -->
            <div class="lg:col-span-2 space-y-6">

                <!-- 1. Ringkasan Waktu & Petugas -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-4">Informasi Kejadian</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400">Tanggal Kejadian:</span>
                            <span class="font-bold text-slate-900 dark:text-slate-100 text-sm">
                                {{ $kejadian->tanggal_kejadian->locale('id')->isoFormat('dddd, D MMMM Y') }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400">Jam Kejadian:</span>
                            <span class="font-bold text-slate-900 dark:text-slate-100 text-sm font-mono">
                                {{ substr($kejadian->jam_kejadian, 0, 5) }} WIB
                            </span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400">Jam Selesai:</span>
                            <span class="font-bold text-slate-900 dark:text-slate-100 text-sm font-mono">
                                {{ $kejadian->jam_selesai ? substr($kejadian->jam_selesai, 0, 5) . ' WIB' : 'Sedang Berlangsung' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400">Sumber Informasi:</span>
                            <span class="font-bold text-slate-900 dark:text-slate-100 text-sm">
                                {{ $kejadian->sumber_informasi ?? 'Call Center 112' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400">Personel TRC Dikerahkan:</span>
                            <span class="font-bold text-slate-900 dark:text-slate-100 text-sm">
                                {{ $kejadian->jumlah_personel }} Orang
                            </span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400">Petugas Pencatat:</span>
                            <span class="font-bold text-slate-900 dark:text-slate-100 text-sm">
                                {{ $kejadian->user->name ?? 'Pusdalops' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- 2. Kronologi & Tindakan -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-5">
                    <div>
                        <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Kronologi Peristiwa</h3>
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-sm text-slate-800 dark:text-slate-200 leading-relaxed whitespace-pre-line font-normal">
                            {{ $kejadian->kronologi }}
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Tindakan Penanganan Petugas</h3>
                        <div class="p-4 rounded-xl bg-orange-50/50 dark:bg-orange-950/20 border border-orange-200/70 dark:border-orange-900/50 text-sm text-slate-800 dark:text-slate-200 leading-relaxed whitespace-pre-line font-normal">
                            {{ $kejadian->tindakan }}
                        </div>
                    </div>

                    <!-- Instansi Pendukung -->
                    @if($kejadian->instansiPendukung->count() > 0)
                    <div>
                        <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Instansi / Mitra Pendukung di Lapangan:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($kejadian->instansiPendukung as $mitra)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-950/50 border border-blue-200 dark:border-blue-800 text-blue-900 dark:text-blue-300 text-xs font-semibold">
                                    {{ $mitra->nama_instansi }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- 3. Dampak Kejadian & Kerusakan -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-4">Dampak & Kerusakan</h3>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
                        <div class="p-3.5 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-100 dark:border-rose-900/50 text-center">
                            <span class="block text-[11px] font-bold text-rose-700 dark:text-rose-400 uppercase">Korban Jiwa</span>
                            <span class="text-2xl font-black text-rose-800 dark:text-rose-300">{{ $kejadian->korban_meninggal }}</span>
                            <span class="block text-[10px] text-rose-600 dark:text-rose-400">Meninggal Dunia</span>
                        </div>
                        <div class="p-3.5 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-100 dark:border-amber-900/50 text-center">
                            <span class="block text-[11px] font-bold text-amber-700 dark:text-amber-400 uppercase">Korban Luka</span>
                            <span class="text-2xl font-black text-amber-800 dark:text-amber-300">{{ $kejadian->korban_luka }}</span>
                            <span class="block text-[10px] text-amber-600 dark:text-amber-400">Luka-Luka</span>
                        </div>
                        <div class="p-3.5 rounded-xl bg-blue-50 dark:bg-blue-950/40 border border-blue-100 dark:border-blue-900/50 text-center">
                            <span class="block text-[11px] font-bold text-blue-700 dark:text-blue-400 uppercase">KK Terdampak</span>
                            <span class="text-2xl font-black text-blue-800 dark:text-blue-300">{{ $kejadian->kk_terdampak }}</span>
                            <span class="block text-[10px] text-blue-600 dark:text-blue-400">Kepala Keluarga</span>
                        </div>
                        <div class="p-3.5 rounded-xl bg-indigo-50 dark:bg-indigo-950/40 border border-indigo-100 dark:border-indigo-900/50 text-center">
                            <span class="block text-[11px] font-bold text-indigo-700 dark:text-indigo-400 uppercase">Jiwa Terdampak</span>
                            <span class="text-2xl font-black text-indigo-800 dark:text-indigo-300">{{ $kejadian->jiwa_terdampak }}</span>
                            <span class="block text-[10px] text-indigo-600 dark:text-indigo-400">Orang / Jiwa</span>
                        </div>
                    </div>

                    <!-- Dampak Khusus (Luas Ha atau Satwa) -->
                    @if($kejadian->luas_terbakar_ha)
                        <div class="p-3.5 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 mb-3 flex items-center justify-between">
                            <span class="text-xs font-bold text-amber-900 dark:text-amber-300">Estimasi Luas Area Terbakar:</span>
                            <span class="text-base font-black text-amber-950 dark:text-amber-200 font-mono">{{ $kejadian->luas_terbakar_ha }} Hektare</span>
                        </div>
                    @endif

                    @if($kejadian->detail_hewan)
                        <div class="p-3.5 rounded-xl bg-purple-50 dark:bg-purple-950/40 border border-purple-200 dark:border-purple-800 mb-3 flex items-center justify-between">
                            <span class="text-xs font-bold text-purple-900 dark:text-purple-300">Spesimen Hewan Liar yang Dievakuasi:</span>
                            <span class="text-sm font-bold text-purple-950 dark:text-purple-200">{{ $kejadian->detail_hewan }}</span>
                        </div>
                    @endif

                    @if($kejadian->kerusakan_fasilitas)
                        <div class="mt-3">
                            <span class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase mb-1">Rincian Kerusakan Fasilitas:</span>
                            <p class="text-xs text-slate-700 dark:text-slate-300 p-3 bg-slate-50 dark:bg-slate-950 rounded-xl border border-slate-200 dark:border-slate-800">
                                {{ $kejadian->kerusakan_fasilitas }}
                            </p>
                        </div>
                    @endif
                </div>

            </div>

            <!-- KOLOM KANAN (1 Kolom): PETA LOKASI & FOTO DOKUMENTASI -->
            <div class="space-y-6">

                <!-- 1. Peta Lokasi Kejadian (Leaflet) -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Lokasi Kejadian (Peta)</h3>
                        @if($kejadian->latitude && $kejadian->longitude)
                            <a href="https://maps.google.com/?q={{ $kejadian->latitude }},{{ $kejadian->longitude }}" 
                               target="_blank" 
                               class="text-[11px] font-bold text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                                <span>Buka Google Maps</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        @endif
                    </div>

                    <!-- Map Container -->
                    <div id="detailMap" class="w-full h-56 rounded-xl border border-slate-200 dark:border-slate-800 shadow-inner mb-3 z-10"></div>

                    <!-- Info Alamat & Koordinat -->
                    <div class="text-xs space-y-1.5 text-slate-700 dark:text-slate-300">
                        <div>
                            <span class="font-bold text-slate-900 dark:text-white">Kecamatan:</span> 
                            Kec. {{ $kejadian->kecamatan->nama_kecamatan }}
                        </div>
                        @if($kejadian->kelurahan)
                        <div>
                            <span class="font-bold text-slate-900 dark:text-white">Kelurahan:</span> 
                            Kel. {{ $kejadian->kelurahan->nama_kelurahan }}
                        </div>
                        @endif
                        <div>
                            <span class="font-bold text-slate-900 dark:text-white">Alamat Detail:</span>
                            <p class="text-slate-600 dark:text-slate-400 mt-0.5">{{ $kejadian->lokasi_detail }}</p>
                        </div>
                        @if($kejadian->latitude && $kejadian->longitude)
                        <div class="pt-2 border-t border-slate-100 dark:border-slate-800 text-[11px] font-mono text-slate-500 dark:text-slate-400">
                            Lat: {{ $kejadian->latitude }}, Lng: {{ $kejadian->longitude }}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- 2. Galeri Foto Dokumentasi -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Dokumentasi Foto</h3>
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $kejadian->foto->count() }} Foto</span>
                    </div>

                    @if($kejadian->foto->count() > 0)
                        <div class="grid grid-cols-2 gap-2.5">
                            @foreach($kejadian->foto as $f)
                                <div class="group relative rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 aspect-square cursor-pointer"
                                     @click="lightboxOpen = true; activeImage = '{{ asset('storage/' . $f->file_path) }}'; activeCaption = '{{ addslashes($f->caption ?? 'Dokumentasi lapangan') }}'">
                                    <img src="{{ asset('storage/' . $f->file_path) }}" 
                                         alt="{{ $f->caption }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform" />
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-2">
                                        <p class="text-[10px] text-white font-medium truncate">{{ $f->caption }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-8 text-center text-slate-400 dark:text-slate-500">
                            <svg class="w-8 h-8 mx-auto text-slate-300 dark:text-slate-600 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-xs">Tidak ada lampiran foto dokumentasi</span>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <!-- LIGHTBOX MODAL PREVIEW FOTO -->
        <div x-cloak x-show="lightboxOpen" 
             @click="lightboxOpen = false"
             class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md flex flex-col items-center justify-center p-4">
            <div class="relative max-w-4xl max-h-[90vh] flex flex-col items-center" @click.stop>
                <button @click="lightboxOpen = false" class="absolute -top-10 right-0 text-white hover:text-orange-400 font-bold text-sm flex items-center gap-1">
                    <span>Tutup (ESC)</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <img :src="activeImage" class="max-h-[75vh] w-auto rounded-xl shadow-2xl object-contain border border-white/20" />
                <p class="text-white text-xs text-center mt-3 font-semibold px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-sm" x-text="activeCaption"></p>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lat = {{ $kejadian->latitude ?? 0.5071 }};
            const lng = {{ $kejadian->longitude ?? 101.4478 }};
            const color = '{{ $kejadian->jenisKejadian->warna ?? "#ea580c" }}';

            const map = L.map('detailMap').setView([lat, lng], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const pulsedIcon = L.divIcon({
                className: 'custom-pulsed-icon',
                html: `
                    <div style="position: relative; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                        <div style="position: absolute; width: 28px; height: 28px; border-radius: 50%; background-color: ${color}; opacity: 0.4; animation: ping 1.8s cubic-bezier(0, 0, 0.2, 1) infinite;"></div>
                        <div style="position: relative; width: 16px; height: 16px; border-radius: 50%; background-color: ${color}; border: 2.5px solid #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.4);"></div>
                    </div>
                `,
                iconSize: [30, 30],
                iconAnchor: [15, 15],
                popupAnchor: [0, -16]
            });

            const marker = L.marker([lat, lng], { icon: pulsedIcon }).addTo(map);
            marker.bindPopup("<b>{{ $kejadian->nomor_laporan }}</b><br><span style='color: " + color + "; font-weight: bold;'>{{ $kejadian->jenisKejadian->nama }}</span><br>{{ addslashes($kejadian->lokasi_detail) }}").openPopup();
        });
    </script>
    @endpush
</x-app-layout>
