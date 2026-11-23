<x-guest-layout>
    <div class="w-full max-w-md">
        
        <!-- Back to Public Portal Link -->
        <div class="mb-4">
            <a href="{{ route('welcome') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-orange-600 dark:text-slate-400 dark:hover:text-orange-400 transition-colors uppercase tracking-wider">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Portal Publik BPBD</span>
            </a>
        </div>

        <!-- Header Brand Card -->
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo-bpbd.png') }}" alt="Logo BPBD Kota Pekanbaru" class="w-20 h-20 rounded-full object-contain mx-auto mb-3 drop-shadow-xl">
            <h2 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white uppercase">
                BPBD KOTA PEKANBARU
            </h2>
            <p class="text-xs font-semibold text-orange-600 dark:text-orange-400 tracking-wider uppercase mt-0.5">
                Pusdalops Penanggulangan Bencana
            </p>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                Sistem Rekapitulasi Kejadian Bencana & Pelaporan Harian
            </p>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl dark:shadow-2xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-orange-500 via-amber-500 to-blue-900"></div>
            <h3 class="text-base font-bold text-slate-800 dark:text-white mb-1">Masuk ke Portal Satu Data</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Masukkan kredensial akun petugas TRC, Admin IT, atau Pimpinan.</p>

            <!-- Session Status Alert -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4" id="loginForm">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                        <span>Alamat Email Dinas <span class="text-rose-500 font-bold">*</span></span>
                        <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                    </label>
                    <div class="relative">
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               oninvalid="this.setCustomValidity('Alamat email dinas harap diisi')"
                               oninput="this.setCustomValidity('')"
                               placeholder="nama@bpbd.pekanbaru.go.id"
                               class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-500" />
                        <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider flex items-center justify-between w-full">
                            <span>Kata Sandi <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                    </div>
                    <div class="relative">
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required 
                               oninvalid="this.setCustomValidity('Kata sandi akun harap diisi')"
                               oninput="this.setCustomValidity('')"
                               autocomplete="current-password" 
                               placeholder="••••••••"
                               class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-500" />
                        <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-orange-600 focus:ring-orange-500 bg-white dark:bg-slate-950" name="remember">
                        <span class="ms-2 text-xs text-slate-600 dark:text-slate-300">Ingat sesi saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:via-amber-600 hover:to-orange-700 text-white font-bold text-sm tracking-wide shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40 hover:-translate-y-0.5 active:translate-y-0 border border-orange-400/40 transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer">
                        <span>Masuk ke Sistem</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </form>

            <!-- Quick Demo Login Helper -->
            <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800">
                <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2.5 text-center">
                    Akses Cepat Akun Demo (Klik untuk Isi)
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" 
                            onclick="fillCredentials('petugas@bpbd.pekanbaru.go.id', 'password')"
                            class="py-2 px-2 rounded-xl bg-orange-50 dark:bg-orange-950/40 hover:bg-orange-500 hover:text-white dark:hover:bg-orange-600 border border-orange-200 dark:border-orange-800/80 text-orange-800 dark:text-orange-300 text-[11px] font-bold text-center transition-all duration-200 hover:-translate-y-0.5 shadow-2xs cursor-pointer">
                        Petugas TRC
                    </button>
                    <button type="button" 
                            onclick="fillCredentials('admin@bpbd.pekanbaru.go.id', 'password')"
                            class="py-2 px-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-900 hover:text-white dark:hover:bg-slate-700 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-[11px] font-bold text-center transition-all duration-200 hover:-translate-y-0.5 shadow-2xs cursor-pointer">
                        Admin IT
                    </button>
                    <button type="button" 
                            onclick="fillCredentials('pimpinan@bpbd.pekanbaru.go.id', 'password')"
                            class="py-2 px-2 rounded-xl bg-blue-50 dark:bg-blue-950/40 hover:bg-blue-700 hover:text-white dark:hover:bg-blue-600 border border-blue-200 dark:border-blue-800/80 text-blue-800 dark:text-blue-300 text-[11px] font-bold text-center transition-all duration-200 hover:-translate-y-0.5 shadow-2xs cursor-pointer">
                        Pimpinan
                    </button>
                </div>
                <p class="text-[10px] text-slate-400 dark:text-slate-500 text-center mt-2">
                    Password default semua akun: <code class="bg-slate-100 dark:bg-slate-800 px-1 py-0.5 rounded text-slate-600 dark:text-slate-400 font-mono">password</code>
                </p>
            </div>
        </div>

        <!-- Emergency Hotline Information -->
        <div class="mt-6 text-center text-xs text-slate-500 dark:text-slate-400">
            Call Center Darurat Bencana: <strong class="text-orange-600 dark:text-orange-400">112</strong> / <strong class="text-slate-800 dark:text-white">0811-7604-800</strong>
        </div>
    </div>

    <script>
        function fillCredentials(email, pass) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = pass;
        }
    </script>
</x-guest-layout>
