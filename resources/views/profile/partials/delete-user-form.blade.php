<section class="space-y-6">
    <header class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-800">
        <div class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200/60 dark:border-rose-800/60 flex items-center justify-center text-rose-600 dark:text-rose-400 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </div>
        <div>
            <h2 class="text-base font-bold text-slate-900 dark:text-white">
                Penonaktifan & Penghapusan Akun
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                Tindakan penghapusan akun bersifat permanen. Seluruh hak akses Anda ke sistem Pusdalops BPBD akan dicabut.
            </p>
        </div>
    </header>

    @if(Auth::user()->isAdmin() && \App\Models\User::where('role', 'admin')->count() <= 1)
        <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-900/60 text-xs text-amber-800 dark:text-amber-300 flex items-center gap-2.5">
            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>Perlindungan Sistem: Anda adalah satu-satunya <strong>Administrator IT</strong> aktif. Akun ini tidak dapat dihapus demi kelangsungan operasional sistem.</span>
        </div>
    @else
        <div class="flex items-center justify-between flex-wrap gap-4">
            <p class="text-xs text-slate-500 dark:text-slate-400 max-w-xl">
                Pastikan Anda telah mengonfirmasi kepada pimpinan operasional sebelum menghapus akun ini dari database.
            </p>
            <button
                type="button"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="px-5 py-2.5 rounded-xl bg-rose-50 dark:bg-rose-950/50 hover:bg-rose-600 hover:text-white text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800 font-bold text-xs uppercase tracking-wider transition-all shadow-2xs hover:shadow-md cursor-pointer"
            >
                Hapus Akun Ini
            </button>
        </div>

        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-8 bg-white dark:bg-slate-900">
                @csrf
                @method('delete')

                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 dark:bg-rose-950/70 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">
                        Konfirmasi Penghapusan Akun
                    </h2>
                </div>

                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
                    Apakah Anda yakin ingin menghapus akun Anda? Seluruh hak akses dan data sesi akan dibersihkan. Silakan masukkan kata sandi akun Anda untuk memverifikasi penghapusan.
                </p>

                <div class="mt-4">
                    <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Kata Sandi Verifikasi <span class="text-rose-500 font-bold">*</span>
                        <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        oninvalid="this.setCustomValidity('Kata sandi konfirmasi harap diisi')"
                        oninput="this.setCustomValidity('')"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all font-mono"
                        placeholder="Ketikkan kata sandi Anda..."
                    />

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer">
                        Batal
                    </button>

                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs uppercase tracking-wider shadow-md shadow-rose-600/30 transition-all cursor-pointer">
                        Ya, Hapus Akun Saya
                    </button>
                </div>
            </form>
        </x-modal>
    @endif
</section>