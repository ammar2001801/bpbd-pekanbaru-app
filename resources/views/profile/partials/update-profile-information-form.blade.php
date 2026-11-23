<section>
    <header class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-800 mb-6">
        <div class="w-10 h-10 rounded-xl bg-orange-50 dark:bg-orange-950/60 border border-orange-200/60 dark:border-orange-800/60 flex items-center justify-center text-orange-600 dark:text-orange-400 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div>
            <h2 class="text-base font-bold text-slate-900 dark:text-white">
                Informasi Biodata & Kontak Personel
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                Perbarui data nama lengkap, email kedinasan, regu kerja, dan nomor kontak darurat Anda.
            </p>
        </div>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                    Nama Lengkap <span class="text-rose-500 font-bold">*</span>
                    <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                </label>
                <div class="relative">
                    <input id="name" 
                           name="name" 
                           type="text" 
                           value="{{ old('name', $user->name) }}" 
                           required 
                           oninvalid="this.setCustomValidity('Nama lengkap harap diisi')" 
                           oninput="this.setCustomValidity('')"
                           placeholder="Masukkan nama lengkap Anda..."
                           class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all font-medium" />
                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                @error('name')
                    <p class="text-xs text-rose-600 dark:text-rose-400 font-semibold mt-1.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Email Dinas -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                    Alamat Email Dinas <span class="text-rose-500 font-bold">*</span>
                    <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                </label>
                <div class="relative">
                    <input id="email" 
                           name="email" 
                           type="email" 
                           value="{{ old('email', $user->email) }}" 
                           required 
                           oninvalid="this.setCustomValidity('Alamat email dinas harap diisi')" 
                           oninput="this.setCustomValidity('')"
                           placeholder="nama@bpbd.pekanbaru.go.id"
                           class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all font-mono font-medium" />
                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                @error('email')
                    <p class="text-xs text-rose-600 dark:text-rose-400 font-semibold mt-1.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Jabatan / Regu Operasional -->
            <div>
                <label for="jabatan" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                    Jabatan / Regu Dinas
                </label>
                <div class="relative">
                    <input id="jabatan" 
                           name="jabatan" 
                           type="text" 
                           value="{{ old('jabatan', $user->jabatan) }}" 
                           placeholder="Contoh: Anggota Regu TRC 1 / Admin IT"
                           class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all font-medium" />
                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
            </div>

            <!-- Nomor HP / WhatsApp -->
            <div>
                <label for="no_hp" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                    No. WhatsApp / Kontak Darurat
                </label>
                <div class="relative">
                    <input id="no_hp" 
                           name="no_hp" 
                           type="text" 
                           value="{{ old('no_hp', $user->no_hp) }}" 
                           placeholder="Contoh: 0812-3456-7890"
                           class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all font-mono font-medium" />
                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
            </div>
        </div>

        <!-- Role Badge Info -->
        <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200/80 dark:border-slate-800 flex items-center justify-between text-xs">
            <span class="text-slate-500 dark:text-slate-400 font-medium">Tingkat Hak Akses Sistem Anda:</span>
            <span class="font-bold uppercase tracking-wider text-[11px] px-2.5 py-1 rounded-full {{ $user->role === 'admin' ? 'bg-rose-100 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300' : ($user->role === 'petugas' ? 'bg-orange-100 dark:bg-orange-950/60 text-orange-700 dark:text-orange-300' : 'bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300') }}">
                {{ $user->role === 'admin' ? 'Administrator IT' : ($user->role === 'petugas' ? 'Petugas TRC Lapangan' : 'Pimpinan BPBD') }}
            </span>
        </div>

        <!-- Tombol Simpan & Status -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
            <div>
                @if (session('status') === 'profile-updated')
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-transition 
                         x-init="setTimeout(() => show = false, 3500)"
                         class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/50 px-3 py-1.5 rounded-xl border border-emerald-200 dark:border-emerald-800">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Data profil berhasil diperbarui!</span>
                    </div>
                @endif
            </div>

            <button type="submit" 
                    class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:via-amber-600 hover:to-orange-700 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40 hover:-translate-y-0.5 active:translate-y-0 border border-orange-400/40 transition-all duration-200 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Simpan Perubahan Profil</span>
            </button>
        </div>
    </form>
</section>