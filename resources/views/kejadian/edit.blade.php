<x-app-layout>
    <x-slot name="header">
        Edit Laporan Kejadian {{ $kejadian->nomor_laporan }}
    </x-slot>

    <div class="max-w-5xl mx-auto">
        <!-- Form Header Breadcrumb -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div>
                <a href="{{ route('kejadian.show', $kejadian->id) }}" class="text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 flex items-center gap-1 mb-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Detail Kejadian
                </a>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">Perbarui Data Kejadian</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Edit informasi penanganan atau perbarui status kejadian di lapangan.</p>
            </div>

            <!-- Nomor Laporan Badge -->
            <div class="bg-slate-900 text-white px-4 py-2.5 rounded-xl border border-slate-700 dark:border-slate-800 shadow-sm flex items-center gap-2">
                <span class="text-xs text-slate-400 font-semibold">No. Laporan:</span>
                <span class="font-mono font-bold text-sm text-orange-400">{{ $kejadian->nomor_laporan }}</span>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900/60 text-rose-800 dark:text-rose-200">
                <div class="flex items-center gap-2 font-bold text-sm mb-2">
                    <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    Terdapat kesalahan dalam formulir:
                </div>
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('kejadian.update', $kejadian->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- BAGIAN 1: WAKTU & KLASIFIKASI -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="flex items-center gap-2.5 pb-4 mb-5 border-b border-slate-100 dark:border-slate-800">
                    <div class="w-7 h-7 rounded-lg bg-orange-100 dark:bg-orange-950/70 text-orange-600 dark:text-orange-400 font-bold flex items-center justify-center text-xs">1</div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Waktu & Jenis Kejadian</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                    <!-- Tanggal Kejadian -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span>Tanggal Kejadian <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <input type="date" 
                               name="tanggal_kejadian" 
                               value="{{ old('tanggal_kejadian', $kejadian->tanggal_kejadian->format('Y-m-d')) }}" 
                               required
                               oninvalid="this.setCustomValidity('Tanggal kejadian harap diisi')"
                               oninput="this.setCustomValidity('')"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-medium focus:ring-2 focus:ring-orange-500 focus:border-orange-500" />
                    </div>

                    <!-- Jam Kejadian -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span>Jam Kejadian (WIB) <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <input type="time" 
                               name="jam_kejadian" 
                               value="{{ old('jam_kejadian', substr($kejadian->jam_kejadian, 0, 5)) }}" 
                               required
                               oninvalid="this.setCustomValidity('Jam kejadian harap diisi')"
                               oninput="this.setCustomValidity('')"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-medium focus:ring-2 focus:ring-orange-500 focus:border-orange-500" />
                    </div>

                    <!-- Jam Selesai -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Jam Selesai Penanganan
                        </label>
                        <input type="time" 
                               name="jam_selesai" 
                               value="{{ old('jam_selesai', $kejadian->jam_selesai ? substr($kejadian->jam_selesai, 0, 5) : '') }}" 
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-medium focus:ring-2 focus:ring-orange-500 focus:border-orange-500" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Jenis Kejadian -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span>Jenis Kejadian Bencana <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <select name="jenis_kejadian_id" id="selectJenis" required
                                oninvalid="this.setCustomValidity('Jenis kejadian bencana harap dipilih')"
                                oninput="this.setCustomValidity('')"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-semibold focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            @foreach($jenisList as $jenis)
                                <option value="{{ $jenis->id }}" data-nama="{{ $jenis->nama }}" {{ old('jenis_kejadian_id', $kejadian->jenis_kejadian_id) == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sumber Informasi -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Sumber Informasi / Pelapor
                        </label>
                        <input type="text" 
                               name="sumber_informasi" 
                               value="{{ old('sumber_informasi', $kejadian->sumber_informasi) }}" 
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500" />
                    </div>
                </div>

                <!-- Dynamic Karhutla -->
                <div id="dynamicKarhutla" class="mt-4 p-4 rounded-xl bg-amber-50/80 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-900/60 hidden">
                    <label class="block text-xs font-bold text-amber-900 dark:text-amber-300 uppercase tracking-wider mb-1.5">
                        Luas Area Terbakar (Hektare)
                    </label>
                    <div class="relative max-w-xs">
                        <input type="number" 
                               step="0.01" 
                               min="0"
                               name="luas_terbakar_ha" 
                               value="{{ old('luas_terbakar_ha', $kejadian->luas_terbakar_ha) }}" 
                               class="w-full px-3.5 py-2.5 rounded-xl border border-amber-300 dark:border-amber-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-white text-sm font-bold" />
                        <span class="absolute right-3.5 top-2.5 text-xs font-bold text-amber-700 dark:text-amber-400">Ha</span>
                    </div>
                </div>

                <!-- Dynamic Satwa Liar -->
                <div id="dynamicHewan" class="mt-4 p-4 rounded-xl bg-purple-50/80 dark:bg-purple-950/30 border border-purple-200 dark:border-purple-900/60 hidden">
                    <label class="block text-xs font-bold text-purple-900 dark:text-purple-300 uppercase tracking-wider mb-1.5">
                        Detail Satwa / Hewan Liar
                    </label>
                    <input type="text" 
                           name="detail_hewan" 
                           value="{{ old('detail_hewan', $kejadian->detail_hewan) }}" 
                           class="w-full px-3.5 py-2.5 rounded-xl border border-purple-300 dark:border-purple-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-white text-sm" />
                </div>
            </div>

            <!-- BAGIAN 2: WILAYAH & PETA -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-orange-100 dark:bg-orange-950/70 text-orange-600 dark:text-orange-400 font-bold flex items-center justify-center text-xs">2</div>
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Lokasi & Titik Koordinat</h3>
                    </div>

                    <button type="button" 
                            id="btnGps" 
                            onclick="getLocation()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-950/50 hover:bg-blue-100 dark:hover:bg-blue-900/50 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 font-bold text-xs transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Gunakan Lokasi Saya (GPS)</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <!-- Kecamatan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span>Kecamatan <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <select name="kecamatan_id" id="selectKecamatan" required
                                oninvalid="this.setCustomValidity('Kecamatan wilayah kejadian harap dipilih')"
                                oninput="this.setCustomValidity('')"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-semibold">
                            @foreach($kecamatanList as $kec)
                                <option value="{{ $kec->id }}" {{ old('kecamatan_id', $kejadian->kecamatan_id) == $kec->id ? 'selected' : '' }}>
                                    Kec. {{ $kec->nama_kecamatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kelurahan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Kelurahan
                        </label>
                        <select name="kelurahan_id" id="selectKelurahan"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm">
                            <option value="">-- Pilih Kelurahan --</option>
                        </select>
                    </div>
                </div>

                <!-- Alamat Detail -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                        <span>Alamat / Lokasi Detail TKP <span class="text-rose-500 font-bold">*</span></span>
                        <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                    </label>
                    <textarea name="lokasi_detail" 
                              rows="2" 
                              required
                              oninvalid="this.setCustomValidity('Alamat atau lokasi detail TKP harap diisi')"
                              oninput="this.setCustomValidity('')"
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm">{{ old('lokasi_detail', $kejadian->lokasi_detail) }}</textarea>
                </div>

                <!-- Peta Leaflet -->
                <div class="mb-4">
                    <div id="mapPicker" class="w-full h-72 rounded-2xl border border-slate-300 dark:border-slate-700 shadow-inner z-10"></div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Latitude</label>
                        <input type="text" name="latitude" id="inputLat" value="{{ old('latitude', $kejadian->latitude) }}" readonly
                               class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-700 dark:text-slate-300 text-xs font-mono font-bold" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Longitude</label>
                        <input type="text" name="longitude" id="inputLng" value="{{ old('longitude', $kejadian->longitude) }}" readonly
                               class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-700 dark:text-slate-300 text-xs font-mono font-bold" />
                    </div>
                </div>
            </div>

            <!-- BAGIAN 3: KRONOLOGI & TINDAKAN -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="flex items-center gap-2.5 pb-4 mb-5 border-b border-slate-100 dark:border-slate-800">
                    <div class="w-7 h-7 rounded-lg bg-orange-100 dark:bg-orange-950/70 text-orange-600 dark:text-orange-400 font-bold flex items-center justify-center text-xs">3</div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Kronologi & Tindakan</h3>
                </div>

                <div class="space-y-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span>Kronologi Kejadian <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <textarea name="kronologi" rows="3" required
                                  oninvalid="this.setCustomValidity('Kronologi kejadian bencana harap diisi')"
                                  oninput="this.setCustomValidity('')"
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm">{{ old('kronologi', $kejadian->kronologi) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span>Tindakan Penanganan Petugas <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <textarea name="tindakan" rows="3" required
                                  oninvalid="this.setCustomValidity('Tindakan penanganan petugas harap diisi')"
                                  oninput="this.setCustomValidity('')"
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm">{{ old('tindakan', $kejadian->tindakan) }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Jumlah Personel
                        </label>
                        <input type="number" min="0" name="jumlah_personel" value="{{ old('jumlah_personel', $kejadian->jumlah_personel) }}" 
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-bold" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span>Status Penanganan <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <select name="status" required
                                oninvalid="this.setCustomValidity('Status penanganan harap dipilih')"
                                oninput="this.setCustomValidity('')"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-bold">
                            <option value="Dalam Penanganan" {{ old('status', $kejadian->status) === 'Dalam Penanganan' ? 'selected' : '' }}>
                                Dalam Penanganan
                            </option>
                            <option value="Selesai" {{ old('status', $kejadian->status) === 'Selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Instansi Pendukung -->
                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Instansi / Mitra Pendukung:
                    </label>
                    @php $selectedInstansi = old('instansi_ids', $kejadian->instansiPendukung->pluck('id')->toArray()); @endphp
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($instansiList as $instansi)
                            <label class="inline-flex items-center gap-2 p-2 rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer text-xs text-slate-700 dark:text-slate-300">
                                <input type="checkbox" 
                                       name="instansi_ids[]" 
                                       value="{{ $instansi->id }}" 
                                       {{ in_array($instansi->id, $selectedInstansi) ? 'checked' : '' }}
                                       class="rounded border-slate-300 dark:border-slate-700 text-orange-600 focus:ring-orange-500">
                                <span class="truncate">{{ $instansi->nama_instansi }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- BAGIAN 4: DAMPAK -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="flex items-center gap-2.5 pb-4 mb-5 border-b border-slate-100 dark:border-slate-800">
                    <div class="w-7 h-7 rounded-lg bg-orange-100 dark:bg-orange-950/70 text-orange-600 dark:text-orange-400 font-bold flex items-center justify-center text-xs">4</div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Dampak Korban & Kerusakan</h3>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Korban Meninggal</label>
                        <input type="number" min="0" name="korban_meninggal" value="{{ old('korban_meninggal', $kejadian->korban_meninggal) }}"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-bold text-center" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Korban Luka</label>
                        <input type="number" min="0" name="korban_luka" value="{{ old('korban_luka', $kejadian->korban_luka) }}"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-bold text-center" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">KK Terdampak</label>
                        <input type="number" min="0" name="kk_terdampak" value="{{ old('kk_terdampak', $kejadian->kk_terdampak) }}"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-bold text-center" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Jiwa Terdampak</label>
                        <input type="number" min="0" name="jiwa_terdampak" value="{{ old('jiwa_terdampak', $kejadian->jiwa_terdampak) }}"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-bold text-center" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Kerusakan Fasilitas / Bangunan
                    </label>
                    <textarea name="kerusakan_fasilitas" rows="2"
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm">{{ old('kerusakan_fasilitas', $kejadian->kerusakan_fasilitas) }}</textarea>
                </div>
            </div>

            <!-- BAGIAN 5: KELOLA FOTO DOKUMENTASI -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-orange-100 dark:bg-orange-950/70 text-orange-600 dark:text-orange-400 font-bold flex items-center justify-center text-xs">5</div>
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Dokumentasi Foto Lapangan</h3>
                    </div>
                    <span class="text-xs text-slate-500 dark:text-slate-400">Maks. 5 Foto (Saat ini: {{ $kejadian->foto->count() }}/5)</span>
                </div>

                <!-- Foto Tersimpan Saat Ini -->
                @if($kejadian->foto->count() > 0)
                    <div class="mb-5">
                        <span class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-3">Foto yang Sudah Tersimpan:</span>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            @foreach($kejadian->foto as $f)
                                <div class="bg-slate-50 dark:bg-slate-950 rounded-xl border border-slate-200 dark:border-slate-800 p-2 flex flex-col justify-between">
                                    <div class="h-28 rounded-lg overflow-hidden mb-2 bg-slate-200 dark:bg-slate-800">
                                        <img src="{{ asset('storage/' . $f->file_path) }}" class="w-full h-full object-cover" />
                                    </div>
                                    <p class="text-[11px] text-slate-600 dark:text-slate-400 truncate mb-2" title="{{ $f->caption }}">{{ $f->caption }}</p>
                                    
                                    <!-- Tombol Hapus Foto -->
                                    <button type="submit" 
                                            formaction="{{ route('kejadian.foto.destroy', $f->id) }}" 
                                            formmethod="POST"
                                            onclick="return confirm('Hapus foto dokumentasi ini?')"
                                            class="w-full py-1 rounded bg-rose-50 dark:bg-rose-950/60 hover:bg-rose-100 dark:hover:bg-rose-900/60 text-rose-700 dark:text-rose-300 text-[11px] font-bold border border-rose-200 dark:border-rose-900">
                                        @csrf
                                        @method('DELETE')
                                        Hapus Foto
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Tambah Foto Baru (Jika belum 5) -->
                @if($kejadian->foto->count() < 5)
                    <div class="p-4 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-950/50">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Unggah Foto Tambahan (Sisa Kuota: {{ 5 - $kejadian->foto->count() }} foto):
                        </label>
                        <input type="file" 
                               name="foto[]" 
                               multiple 
                               accept="image/png,image/jpeg,image/webp" 
                               class="w-full text-xs text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-orange-50 dark:file:bg-orange-950/50 file:text-orange-700 dark:file:text-orange-400 hover:file:bg-orange-100" />
                    </div>
                @endif
            </div>

            <!-- SUBMIT BUTTONS -->
            <div class="flex items-center justify-end gap-3 pt-2 pb-8">
                <a href="{{ route('kejadian.show', $kejadian->id) }}" 
                   class="px-6 py-3 rounded-xl border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 font-bold text-sm transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-8 py-3 rounded-xl bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-bold text-sm shadow-xl shadow-orange-500/25 flex items-center gap-2 transition-all">
                    <span>Simpan Perubahan Laporan</span>
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        const dataWilayah = @json($kecamatanList);
        const selectKecamatan = document.getElementById('selectKecamatan');
        const selectKelurahan = document.getElementById('selectKelurahan');
        const currentKelurahanId = "{{ old('kelurahan_id', $kejadian->kelurahan_id) }}";

        function updateKelurahanDropdown(kecId) {
            selectKelurahan.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
            if (!kecId) return;

            const kec = dataWilayah.find(k => k.id == kecId);
            if (kec && kec.kelurahan) {
                kec.kelurahan.forEach(kel => {
                    const opt = document.createElement('option');
                    opt.value = kel.id;
                    opt.textContent = kel.nama_kelurahan;
                    if (currentKelurahanId && kel.id == currentKelurahanId) {
                        opt.selected = true;
                    }
                    selectKelurahan.appendChild(opt);
                });
            }
        }

        selectKecamatan.addEventListener('change', function() {
            updateKelurahanDropdown(this.value);
        });

        if (selectKecamatan.value) {
            updateKelurahanDropdown(selectKecamatan.value);
        }

        // Dynamic Field Toggle
        const selectJenis = document.getElementById('selectJenis');
        const dynamicKarhutla = document.getElementById('dynamicKarhutla');
        const dynamicHewan = document.getElementById('dynamicHewan');

        function toggleDynamicFields() {
            const selectedOpt = selectJenis.options[selectJenis.selectedIndex];
            const namaJenis = selectedOpt ? selectedOpt.getAttribute('data-nama') : '';

            if (namaJenis === 'Kebakaran Lahan') {
                dynamicKarhutla.classList.remove('hidden');
                dynamicHewan.classList.add('hidden');
            } else if (namaJenis === 'Evakuasi Hewan Liar') {
                dynamicHewan.classList.remove('hidden');
                dynamicKarhutla.classList.add('hidden');
            } else {
                dynamicKarhutla.classList.add('hidden');
                dynamicHewan.classList.add('hidden');
            }
        }

        selectJenis.addEventListener('change', toggleDynamicFields);
        toggleDynamicFields();

        // Leaflet Coordinate Picker
        let currentLat = parseFloat(document.getElementById('inputLat').value) || 0.5071;
        let currentLng = parseFloat(document.getElementById('inputLng').value) || 101.4478;

        const map = L.map('mapPicker').setView([currentLat, currentLng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let marker = L.marker([currentLat, currentLng], { draggable: true }).addTo(map);

        function updateCoords(lat, lng) {
            document.getElementById('inputLat').value = lat.toFixed(7);
            document.getElementById('inputLng').value = lng.toFixed(7);
        }

        marker.on('dragend', function() {
            const pos = marker.getLatLng();
            updateCoords(pos.lat, pos.lng);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateCoords(e.latlng.lat, e.latlng.lng);
        });

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        marker.setLatLng([lat, lng]);
                        map.setView([lat, lng], 16);
                        updateCoords(lat, lng);
                    },
                    (error) => alert("Gagal membaca GPS: " + error.message)
                );
            }
        }
    </script>
    @endpush
</x-app-layout>
