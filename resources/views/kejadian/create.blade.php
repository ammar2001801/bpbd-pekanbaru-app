<x-app-layout>
    <x-slot name="header">
        Input Kejadian Bencana Baru
    </x-slot>

    <div class="max-w-5xl mx-auto">
        <!-- Form Header Breadcrumb & Info -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div>
                <a href="{{ route('kejadian.index') }}" class="text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 flex items-center gap-1 mb-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Data Kejadian
                </a>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">Formulir Rekap Kejadian Bencana</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Isi data laporan kejadian dengan cepat, akurat, dan lengkap.</p>
            </div>

            <!-- Auto Nomor Laporan Badge -->
            <div class="bg-gradient-to-r from-blue-900 to-slate-900 text-white px-4 py-2.5 rounded-xl border border-blue-800 dark:border-blue-900 shadow-sm flex items-center gap-3">
                <span class="text-xs text-slate-400 font-semibold">Estimasi No. Laporan:</span>
                <span class="font-mono font-bold text-sm text-orange-400">{{ $nomorLaporanPreview }}</span>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900/60 text-rose-800 dark:text-rose-200">
                <div class="flex items-center gap-2 font-bold text-sm mb-2">
                    <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    Terdapat kesalahan pengisian formulir:
                </div>
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('kejadian.store') }}" enctype="multipart/form-data" class="space-y-6" id="formKejadian">
            @csrf

            <!-- BAGIAN 1: WAKTU & KLASIFIKASI KEJADIAN -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="flex items-center gap-2.5 pb-4 mb-5 border-b border-slate-100 dark:border-slate-800">
                    <div class="w-7 h-7 rounded-lg bg-orange-100 dark:bg-orange-950/70 text-orange-600 dark:text-orange-400 font-bold flex items-center justify-center text-xs">1</div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Waktu & Jenis Kejadian</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                    <!-- Tanggal Kejadian -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Tanggal Kejadian <span class="text-rose-500 font-bold">*</span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <input type="date" 
                               name="tanggal_kejadian" 
                               value="{{ old('tanggal_kejadian', date('Y-m-d')) }}" 
                               required
                               oninvalid="this.setCustomValidity('Tanggal kejadian harap diisi')"
                               oninput="this.setCustomValidity('')"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 font-medium" />
                    </div>

                    <!-- Jam Kejadian -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Jam Kejadian (WIB) <span class="text-rose-500 font-bold">*</span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <input type="time" 
                               name="jam_kejadian" 
                               value="{{ old('jam_kejadian', date('H:i')) }}" 
                               required
                               oninvalid="this.setCustomValidity('Jam kejadian harap diisi')"
                               oninput="this.setCustomValidity('')"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 font-medium" />
                    </div>

                    <!-- Jam Selesai -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Jam Selesai Penanganan
                        </label>
                        <input type="time" 
                               name="jam_selesai" 
                               value="{{ old('jam_selesai') }}" 
                               placeholder="Opsional"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 font-medium" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Jenis Kejadian -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Jenis Kejadian Bencana <span class="text-rose-500 font-bold">*</span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap dipilih)</span>
                        </label>
                        <select name="jenis_kejadian_id" id="selectJenis" required
                                oninvalid="this.setCustomValidity('Jenis kejadian bencana harap dipilih')"
                                oninput="this.setCustomValidity('')"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-semibold focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">-- Pilih Jenis Bencana / Kedaruratan --</option>
                            @foreach($jenisList as $jenis)
                                <option value="{{ $jenis->id }}" data-nama="{{ $jenis->nama }}" {{ old('jenis_kejadian_id') == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sumber Informasi / Pelapor -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Sumber Informasi / Pelapor
                        </label>
                        <input type="text" 
                               name="sumber_informasi" 
                               value="{{ old('sumber_informasi') }}" 
                               placeholder="Contoh: Call Center 112, Warga, Patroli TRC"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500" />
                    </div>
                </div>

                <!-- DYNAMIC FIELD 1: Kebakaran Lahan (Luas Ha) -->
                <div id="dynamicKarhutla" class="mt-4 p-4 rounded-xl bg-amber-50/80 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-900/60 hidden">
                    <label class="block text-xs font-bold text-amber-900 dark:text-amber-300 uppercase tracking-wider mb-1.5">
                        Luas Area Terbakar (Hektare)
                    </label>
                    <div class="relative max-w-xs">
                        <input type="number" 
                               step="0.01" 
                               min="0"
                               name="luas_terbakar_ha" 
                               id="inputLuasHa"
                               value="{{ old('luas_terbakar_ha') }}" 
                               placeholder="Contoh: 1.50"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-amber-300 dark:border-amber-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-white text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 font-bold" />
                        <span class="absolute right-3.5 top-2.5 text-xs font-bold text-amber-700 dark:text-amber-400">Ha</span>
                    </div>
                    <p class="text-[11px] text-amber-700 dark:text-amber-400 mt-1.5">Estimasi luas hamparan lahan gambut atau semak belukar yang terbakar.</p>
                </div>

                <!-- DYNAMIC FIELD 2: Evakuasi Hewan Liar (Jenis & Jumlah) -->
                <div id="dynamicHewan" class="mt-4 p-4 rounded-xl bg-purple-50/80 dark:bg-purple-950/30 border border-purple-200 dark:border-purple-900/60 hidden">
                    <label class="block text-xs font-bold text-purple-900 dark:text-purple-300 uppercase tracking-wider mb-1.5">
                        Detail Satwa / Hewan Liar
                    </label>
                    <input type="text" 
                           name="detail_hewan" 
                           id="inputDetailHewan"
                           value="{{ old('detail_hewan') }}" 
                           placeholder="Contoh: Ular Sanca Batik panjang 3.5 meter (1 ekor), Sarang Tawon Vespa diameter 40 cm"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-purple-300 dark:border-purple-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-white text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500" />
                    <p class="text-[11px] text-purple-700 dark:text-purple-400 mt-1.5">Tuliskan jenis spesimen, ukuran estimasi, serta jumlah ekor/sarang yang dievakuasi.</p>
                </div>
            </div>

            <!-- BAGIAN 2: LOKASI KEJADIAN & PETA KOORDINAT (LEAFLET + GPS) -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-orange-100 dark:bg-orange-950/70 text-orange-600 dark:text-orange-400 font-bold flex items-center justify-center text-xs">2</div>
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Lokasi & Titik Koordinat</h3>
                    </div>

                    <!-- Tombol GPS Lokasi Saya -->
                    <button type="button" 
                            id="btnGps" 
                            onclick="getLocation()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-950/50 hover:bg-blue-100 dark:hover:bg-blue-900/50 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 font-bold text-xs transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span id="gpsText">Gunakan Lokasi Saya (GPS)</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <!-- Kecamatan (Master Data) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Kecamatan <span class="text-rose-500 font-bold">*</span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap dipilih)</span>
                        </label>
                        <select name="kecamatan_id" id="selectKecamatan" required
                                oninvalid="this.setCustomValidity('Kecamatan wilayah kejadian harap dipilih')"
                                oninput="this.setCustomValidity('')"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-semibold focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">-- Pilih Kecamatan Kota Pekanbaru --</option>
                            @foreach($kecamatanList as $kec)
                                <option value="{{ $kec->id }}" {{ old('kecamatan_id') == $kec->id ? 'selected' : '' }}>
                                    Kec. {{ $kec->nama_kecamatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kelurahan (Dependent Dropdown) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Kelurahan
                        </label>
                        <select name="kelurahan_id" id="selectKelurahan"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">-- Pilih Kelurahan (Pilih Kecamatan Dahulu) --</option>
                        </select>
                    </div>
                </div>

                <!-- Alamat / Lokasi Detail -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Alamat / Lokasi Detail TKP <span class="text-rose-500 font-bold">*</span>
                        <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                    </label>
                    <textarea name="lokasi_detail" 
                              rows="2" 
                              required
                              oninvalid="this.setCustomValidity('Alamat atau lokasi detail TKP harap diisi')"
                              oninput="this.setCustomValidity('')"
                              placeholder="Tuliskan nama jalan, nomor rumah/RT/RW, patokan lokasi (contoh: Jl. Badak Ujung RT 02 RW 05 dekat kantor Walikota)"
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('lokasi_detail') }}</textarea>
                </div>

                <!-- Peta Interaktif Leaflet -->
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Klik peta atau seret marker untuk menentukan titik koordinat:</span>
                        <span class="text-[11px] text-slate-400 dark:text-slate-500">Peta OpenStreetMap</span>
                    </div>
                    <div id="mapPicker" class="w-full h-72 rounded-2xl border border-slate-300 dark:border-slate-700 shadow-inner z-10"></div>
                </div>

                <!-- Field Koordinat Latitude & Longitude -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Latitude</label>
                        <input type="text" 
                               name="latitude" 
                               id="inputLat" 
                               value="{{ old('latitude', '0.5071000') }}" 
                               readonly
                               class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-700 dark:text-slate-300 text-xs font-mono font-bold" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Longitude</label>
                        <input type="text" 
                               name="longitude" 
                               id="inputLng" 
                               value="{{ old('longitude', '101.4478000') }}" 
                               readonly
                               class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-700 dark:text-slate-300 text-xs font-mono font-bold" />
                    </div>
                </div>
            </div>

            <!-- BAGIAN 3: KRONOLOGI, TINDAKAN & PERSONEL -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="flex items-center gap-2.5 pb-4 mb-5 border-b border-slate-100 dark:border-slate-800">
                    <div class="w-7 h-7 rounded-lg bg-orange-100 dark:bg-orange-950/70 text-orange-600 dark:text-orange-400 font-bold flex items-center justify-center text-xs">3</div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Kronologi & Tindakan Petugas</h3>
                </div>

                <div class="space-y-4 mb-4">
                    <!-- Kronologi -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Kronologi Kejadian <span class="text-rose-500 font-bold">*</span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <textarea name="kronologi" 
                                  rows="3" 
                                  required
                                  oninvalid="this.setCustomValidity('Kronologi kejadian bencana harap diisi')"
                                  oninput="this.setCustomValidity('')"
                                  placeholder="Jelaskan secara singkat urutan peristiwa awal terjadinya bencana atau laporan kedaruratan yang diterima..."
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('kronologi') }}</textarea>
                    </div>

                    <!-- Tindakan Penanganan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Tindakan Penanganan yang Dilakukan <span class="text-rose-500 font-bold">*</span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <textarea name="tindakan" 
                                  rows="3" 
                                  required
                                  oninvalid="this.setCustomValidity('Tindakan penanganan regu TRC harap diisi')"
                                  oninput="this.setCustomValidity('')"
                                  placeholder="Jelaskan tindakan operasi TRC BPBD dan alat yang dikerahkan (contoh: pemadaman 2 roll selang, evakuasi warga via perahu karet, dll)..."
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('tindakan') }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Jumlah Personel -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Jumlah Personel yang Dikerahkan
                        </label>
                        <input type="number" 
                               min="0"
                               name="jumlah_personel" 
                               value="{{ old('jumlah_personel', 5) }}" 
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 font-bold" />
                    </div>

                    <!-- Status Laporan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Status Penanganan <span class="text-rose-500 font-bold">*</span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap dipilih)</span>
                        </label>
                        <select name="status" required
                                oninvalid="this.setCustomValidity('Status penanganan harap dipilih')"
                                oninput="this.setCustomValidity('')"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-bold focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="Dalam Penanganan" {{ old('status') === 'Dalam Penanganan' ? 'selected' : '' }}>
                                Dalam Penanganan (Masih di TKP)
                            </option>
                            <option value="Selesai" {{ old('status', 'Selesai') === 'Selesai' ? 'selected' : '' }}>
                                Selesai (Situasi Terkendali)
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Instansi Pendukung (Multi-checkbox) -->
                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Instansi / Mitra Pendukung di Lapangan:
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($instansiList as $instansi)
                            <label class="inline-flex items-center gap-2 p-2 rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer text-xs text-slate-700 dark:text-slate-300">
                                <input type="checkbox" 
                                       name="instansi_ids[]" 
                                       value="{{ $instansi->id }}" 
                                       {{ in_array($instansi->id, old('instansi_ids', [])) ? 'checked' : '' }}
                                       class="rounded border-slate-300 dark:border-slate-700 text-orange-600 focus:ring-orange-500">
                                <span class="truncate">{{ $instansi->nama_instansi }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- BAGIAN 4: DAMPAK KEJADIAN -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="flex items-center gap-2.5 pb-4 mb-5 border-b border-slate-100 dark:border-slate-800">
                    <div class="w-7 h-7 rounded-lg bg-orange-100 dark:bg-orange-950/70 text-orange-600 dark:text-orange-400 font-bold flex items-center justify-center text-xs">4</div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Dampak Korban & Kerusakan</h3>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Korban Meninggal</label>
                        <input type="number" min="0" name="korban_meninggal" value="{{ old('korban_meninggal', 0) }}"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-bold text-center" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Korban Luka-Luka</label>
                        <input type="number" min="0" name="korban_luka" value="{{ old('korban_luka', 0) }}"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-bold text-center" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">KK Terdampak</label>
                        <input type="number" min="0" name="kk_terdampak" value="{{ old('kk_terdampak', 0) }}"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-bold text-center" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Jiwa Terdampak</label>
                        <input type="number" min="0" name="jiwa_terdampak" value="{{ old('jiwa_terdampak', 0) }}"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm font-bold text-center" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Kerusakan Fisik & Bangunan / Fasilitas Umum
                    </label>
                    <textarea name="kerusakan_fasilitas" 
                              rows="2" 
                              placeholder="Contoh: 2 unit rumah semi-permanen rusak berat 100%, 1 tiang listrik PLN patah, pagar jalan roboh..."
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-white text-slate-800 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('kerusakan_fasilitas') }}</textarea>
                </div>
            </div>

            <!-- BAGIAN 5: UPLOAD DOKUMENTASI FOTO (PREVIEW + CAPTION PER FOTO) -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-orange-100 dark:bg-orange-950/70 text-orange-600 dark:text-orange-400 font-bold flex items-center justify-center text-xs">5</div>
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Dokumentasi Foto Lapangan</h3>
                    </div>
                    <span class="text-xs text-slate-500 dark:text-slate-400">Maks. 5 foto (JPG, PNG, WEBP &bull; Maks. 5 MB)</span>
                </div>

                <div class="mb-4">
                    <label class="block w-full border-2 border-dashed border-slate-300 dark:border-slate-700 hover:border-orange-500 dark:hover:border-orange-500 rounded-2xl p-6 text-center cursor-pointer bg-slate-50 dark:bg-slate-950/50 hover:bg-orange-50/30 dark:hover:bg-slate-900/60 transition-colors">
                        <div class="flex flex-col items-center">
                            <svg class="w-8 h-8 text-slate-400 dark:text-slate-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="text-sm font-bold text-slate-800 dark:text-white">Pilih Foto Dokumentasi Lapangan</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400 mt-1">Dapat memilih hingga 5 foto sekaligus dari galeri atau kamera HP</span>
                        </div>
                        <input type="file" 
                               name="foto[]" 
                               id="inputFoto" 
                               multiple 
                               accept="image/png,image/jpeg,image/webp" 
                               class="hidden" 
                               onchange="previewPhotos(this)" />
                    </label>
                </div>

                <!-- Container Preview Foto & Input Caption -->
                <div id="previewContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"></div>
            </div>

            <!-- TOMBOL AKSI SUBMIT -->
            <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-2 pb-8">
                <a href="{{ route('kejadian.index') }}" 
                   class="w-full sm:w-auto px-6 py-3 rounded-xl border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 text-center font-bold text-sm transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="w-full sm:w-auto px-8 py-3 rounded-xl bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-bold text-sm shadow-xl shadow-orange-500/25 flex items-center justify-center gap-2 transition-all">
                    <span>Simpan Laporan Kejadian</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        // 1. Data Kecamatan & Kelurahan Kota Pekanbaru
        const dataWilayah = @json($kecamatanList);
        const selectKecamatan = document.getElementById('selectKecamatan');
        const selectKelurahan = document.getElementById('selectKelurahan');
        const oldKelurahanId = "{{ old('kelurahan_id') }}";

        function updateKelurahanDropdown(kecId) {
            selectKelurahan.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
            if (!kecId) return;

            const kec = dataWilayah.find(k => k.id == kecId);
            if (kec && kec.kelurahan) {
                kec.kelurahan.forEach(kel => {
                    const opt = document.createElement('option');
                    opt.value = kel.id;
                    opt.textContent = kel.nama_kelurahan;
                    if (oldKelurahanId && kel.id == oldKelurahanId) {
                        opt.selected = true;
                    }
                    selectKelurahan.appendChild(opt);
                });
            }
        }

        selectKecamatan.addEventListener('change', function() {
            updateKelurahanDropdown(this.value);
        });

        // Trigger on load if old value exists
        if (selectKecamatan.value) {
            updateKelurahanDropdown(selectKecamatan.value);
        }

        // 2. Dynamic Field Toggle (Kebakaran Lahan vs Evakuasi Hewan)
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
        toggleDynamicFields(); // Check initial value

        // 3. Leaflet OpenStreetMap Coordinate Picker
        let defaultLat = parseFloat(document.getElementById('inputLat').value) || 0.5071;
        let defaultLng = parseFloat(document.getElementById('inputLng').value) || 101.4478;

        const map = L.map('mapPicker').setView([defaultLat, defaultLng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        function updateCoords(lat, lng) {
            document.getElementById('inputLat').value = lat.toFixed(7);
            document.getElementById('inputLng').value = lng.toFixed(7);
        }

        marker.on('dragend', function(e) {
            const pos = marker.getLatLng();
            updateCoords(pos.lat, pos.lng);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateCoords(e.latlng.lat, e.latlng.lng);
        });

        // 4. GPS "Gunakan Lokasi Saya"
        function getLocation() {
            const btnGps = document.getElementById('btnGps');
            const gpsText = document.getElementById('gpsText');
            
            if (navigator.geolocation) {
                gpsText.textContent = "Mencari koordinat...";
                btnGps.classList.add('opacity-75');

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        marker.setLatLng([lat, lng]);
                        map.setView([lat, lng], 16);
                        updateCoords(lat, lng);

                        gpsText.textContent = "Lokasi Terdeteksi";
                        btnGps.classList.remove('opacity-75', 'bg-blue-50', 'text-blue-700');
                        btnGps.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-300', 'dark:bg-emerald-950/60', 'dark:text-emerald-300', 'dark:border-emerald-800');
                    },
                    (error) => {
                        alert("Gagal membaca GPS: " + error.message + ". Silakan klik langsung pada peta.");
                        gpsText.textContent = "Gunakan Lokasi Saya (GPS)";
                        btnGps.classList.remove('opacity-75');
                    },
                    { enableHighAccuracy: true, timeout: 10000 }
                );
            } else {
                alert("Browser Anda tidak mendukung geolokasi GPS.");
            }
        }

        // 5. Multi-photo preview with per-photo captions
        function previewPhotos(input) {
            const container = document.getElementById('previewContainer');
            container.innerHTML = '';

            if (input.files && input.files.length > 0) {
                if (input.files.length > 5) {
                    alert('Maksimal hanya boleh memilih 5 foto. Hanya 5 foto pertama yang akan diproses.');
                }

                const limit = Math.min(input.files.length, 5);
                for (let i = 0; i < limit; i++) {
                    const file = input.files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const card = document.createElement('div');
                        card.className = "bg-slate-50 dark:bg-slate-950 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm flex flex-col";
                        card.innerHTML = `
                            <div class="h-36 bg-slate-200 dark:bg-slate-800 overflow-hidden relative">
                                <img src="${e.target.result}" class="w-full h-full object-cover" />
                                <span class="absolute top-2 left-2 bg-black/60 text-white text-[10px] font-bold px-1.5 py-0.5 rounded backdrop-blur-sm">Foto ${i + 1}</span>
                            </div>
                            <div class="p-2.5 flex-1 flex flex-col justify-between">
                                <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Keterangan / Caption Foto:</label>
                                <input type="text" 
                                       name="captions[]" 
                                       placeholder="Contoh: Kondisi awal api di semak belukar" 
                                       class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-xs focus:ring-1 focus:ring-orange-500" />
                            </div>
                        `;
                        container.appendChild(card);
                    };

                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
