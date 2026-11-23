<x-app-layout>
    <x-slot name="header">
        Manajemen Akun Pengguna
    </x-slot>

    <div x-data="{
        showAddModal: false,
        showEditModal: false,
        editUser: {
            id: null,
            name: '',
            email: '',
            role: 'petugas',
            jabatan: '',
            no_hp: '',
            status_aktif: true
        },
        openEdit(user) {
            this.editUser = { ...user };
            this.showEditModal = true;
        }
    }">

        <!-- PAGE HEADER TITLE -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">Manajemen Akun & Hak Akses Pengguna</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kelola akun personel Tim Reaksi Cepat (TRC), Administrator IT, dan Pimpinan BPBD Kota Pekanbaru.</p>
            </div>
            <button @click="showAddModal = true" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:via-amber-600 hover:to-orange-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40 hover:-translate-y-0.5 active:translate-y-0 border border-orange-400/40 whitespace-nowrap transition-all duration-200 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Pengguna Baru</span>
            </button>
        </div>

        <!-- STATISTIK RINGKAS PENGGUNA -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 sm:p-5 border border-slate-200/90 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group flex items-center justify-between">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-slate-700 to-slate-900 dark:from-slate-500 dark:to-slate-300"></div>
                <div>
                    <div class="text-[11px] font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Akun</div>
                    <div class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $totalUsers }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300 group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 sm:p-5 border border-slate-200/90 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group flex items-center justify-between">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-rose-600 to-red-600"></div>
                <div>
                    <div class="text-[11px] font-extrabold text-rose-600 dark:text-rose-400 uppercase tracking-wider">Admin IT</div>
                    <div class="text-3xl font-black text-rose-600 dark:text-rose-400 mt-1">{{ $totalAdmin }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-950/60 flex items-center justify-center text-rose-600 dark:text-rose-400 group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 sm:p-5 border border-slate-200/90 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group flex items-center justify-between">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-orange-500 to-amber-500"></div>
                <div>
                    <div class="text-[11px] font-extrabold text-orange-600 dark:text-orange-400 uppercase tracking-wider">Petugas TRC</div>
                    <div class="text-3xl font-black text-orange-600 dark:text-orange-400 mt-1">{{ $totalPetugas }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-orange-50 dark:bg-orange-950/60 flex items-center justify-center text-orange-600 dark:text-orange-400 group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 sm:p-5 border border-slate-200/90 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group flex items-center justify-between">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-600 to-indigo-600"></div>
                <div>
                    <div class="text-[11px] font-extrabold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Pimpinan</div>
                    <div class="text-3xl font-black text-blue-600 dark:text-blue-400 mt-1">{{ $totalPimpinan }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
            </div>
        </div>

        <!-- HEADER AKSI & FILTER PENCARIAN -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                
                <!-- Filter Form -->
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-3 flex-1">
                    <div class="relative flex-1 min-w-[200px]">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, email, jabatan..." 
                               class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-orange-500 focus:ring-orange-500 pl-8 py-2.5">
                        <svg class="w-4 h-4 absolute left-2.5 top-3 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <select name="role" onchange="this.form.submit()" class="text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 focus:border-orange-500 focus:ring-orange-500 py-2.5 font-medium">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin IT</option>
                        <option value="petugas" {{ $role === 'petugas' ? 'selected' : '' }}>Petugas TRC</option>
                        <option value="pimpinan" {{ $role === 'pimpinan' ? 'selected' : '' }}>Pimpinan BPBD</option>
                    </select>

                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 focus:border-orange-500 focus:ring-orange-500 py-2.5 font-medium">
                        <option value="">Semua Status</option>
                        <option value="1" {{ $status === '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ $status === '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>

                    <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 dark:from-orange-500 dark:via-amber-500 dark:to-orange-600 hover:from-black hover:to-slate-900 text-white rounded-xl text-xs font-bold shadow-sm hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 cursor-pointer">
                        Terapkan
                    </button>

                    @if($search || $role || $status !== null && $status !== '')
                        <a href="{{ route('admin.users.index') }}" class="px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- TABEL DATA PENGGUNA -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 uppercase font-semibold text-[11px] tracking-wider">
                        <tr>
                            <th class="py-3 px-4">Pengguna</th>
                            <th class="py-3 px-4">Kontak / Jabatan</th>
                            <th class="py-3 px-4 text-center">Role Akses</th>
                            <th class="py-3 px-4 text-center">Laporan Dibuat</th>
                            <th class="py-3 px-4 text-center">Status Akun</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($users as $u)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/60 transition-colors {{ $u->id === Auth::id() ? 'bg-orange-50/30 dark:bg-orange-950/20' : '' }}">
                                <!-- Kolom Pengguna -->
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs shadow-2xs {{ $u->role === 'admin' ? 'bg-rose-100 dark:bg-rose-950/60 text-rose-700 dark:text-rose-400' : ($u->role === 'petugas' ? 'bg-orange-100 dark:bg-orange-950/60 text-orange-700 dark:text-orange-400' : 'bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-400') }}">
                                            {{ strtoupper(substr($u->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-1.5">
                                                <span>{{ $u->name }}</span>
                                                @if($u->id === Auth::id())
                                                    <span class="text-[10px] bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 px-1.5 py-0.2 rounded font-bold">Anda</span>
                                                @endif
                                            </div>
                                            <div class="text-[11px] text-slate-400 dark:text-slate-500 font-mono">{{ $u->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Kolom Kontak / Jabatan -->
                                <td class="py-3.5 px-4">
                                    <div class="font-medium text-slate-700 dark:text-slate-300">{{ $u->jabatan ?? '-' }}</div>
                                    <div class="text-[11px] text-slate-400 dark:text-slate-500">{{ $u->no_hp ?? '-' }}</div>
                                </td>

                                <!-- Kolom Role -->
                                <td class="py-3.5 px-4 text-center">
                                    @if($u->role === 'admin')
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 dark:bg-rose-950/50 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800 uppercase">
                                            Admin IT
                                        </span>
                                    @elseif($u->role === 'petugas')
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-orange-50 dark:bg-orange-950/50 text-orange-700 dark:text-orange-300 border border-orange-200 dark:border-orange-800 uppercase">
                                            Petugas TRC
                                        </span>
                                    @else
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 dark:bg-blue-950/50 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800 uppercase">
                                            Pimpinan
                                        </span>
                                    @endif
                                </td>

                                <!-- Kolom Jumlah Laporan -->
                                <td class="py-3.5 px-4 text-center">
                                    <span class="px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs">
                                        {{ $u->kejadian_count }}
                                    </span>
                                </td>

                                <!-- Kolom Status -->
                                <td class="py-3.5 px-4 text-center">
                                    @if($u->id === Auth::id())
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Aktif (Sedang Dipakai)</span>
                                        </span>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.toggle-status', $u->id) }}" class="inline-block">
                                            @csrf
                                            <button type="submit" title="Klik untuk mengubah status" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold border transition-all cursor-pointer {{ $u->status_aktif ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800 hover:bg-emerald-100 dark:hover:bg-emerald-900/50' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-300 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $u->status_aktif ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                                <span>{{ $u->status_aktif ? 'Aktif' : 'Nonaktif' }}</span>
                                            </button>
                                        </form>
                                    @endif
                                </td>

                                <!-- Kolom Aksi -->
                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <!-- Edit Button -->
                                        <button @click="openEdit({{ json_encode([
                                            'id' => $u->id,
                                            'name' => $u->name,
                                            'email' => $u->email,
                                            'role' => $u->role,
                                            'jabatan' => $u->jabatan ?? '',
                                            'no_hp' => $u->no_hp ?? '',
                                            'status_aktif' => (bool)$u->status_aktif
                                        ]) }})" class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white border border-blue-200/60 dark:border-blue-800/60 flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-md hover:scale-105 cursor-pointer" title="Edit Akun">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>

                                        <!-- Delete Button -->
                                        @if($u->id !== Auth::id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengguna {{ $u->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white dark:hover:bg-rose-600 dark:hover:text-white border border-rose-200/60 dark:border-rose-800/60 flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-md hover:scale-105 cursor-pointer" title="Hapus Pengguna">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-slate-400 dark:text-slate-500 italic">
                                    Tidak ada data pengguna yang sesuai dengan kriteria pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        <!-- MODAL TAMBAH PENGGUNA BARU -->
        <div x-show="showAddModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4" x-cloak>
            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-800 animate-in fade-in zoom-in duration-200">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">
                        Tambah Pengguna Baru
                    </h3>
                    <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 font-bold text-lg">
                        &times;
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-3.5">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1 flex items-center justify-between">
                            <span>Nama Lengkap <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <input type="text" name="name" required 
                               oninvalid="this.setCustomValidity('Nama lengkap harap diisi')"
                               oninput="this.setCustomValidity('')"
                               placeholder="Contoh: Ahmad Fadli, S.Kom" 
                               class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-orange-500 focus:ring-orange-500 py-2">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1 flex items-center justify-between">
                            <span>Email Dinas / Akun <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <input type="email" name="email" required 
                               oninvalid="this.setCustomValidity('Alamat email dinas harap diisi')"
                               oninput="this.setCustomValidity('')"
                               placeholder="Contoh: ahmad@pekanbaru.go.id" 
                               class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-orange-500 focus:ring-orange-500 py-2">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1 flex items-center justify-between">
                                <span>Role Hak Akses <span class="text-rose-500 font-bold">*</span></span>
                            </label>
                            <select name="role" required class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 focus:border-orange-500 focus:ring-orange-500 py-2">
                                <option value="petugas">Petugas TRC</option>
                                <option value="admin">Admin IT</option>
                                <option value="pimpinan">Pimpinan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1 flex items-center justify-between">
                                <span>Password Awal <span class="text-rose-500 font-bold">*</span></span>
                                <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                            </label>
                            <input type="password" name="password" required 
                                   oninvalid="this.setCustomValidity('Password awal akun harap diisi')"
                                   oninput="this.setCustomValidity('')"
                                   placeholder="Min. 6 karakter" 
                                   class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-orange-500 focus:ring-orange-500 py-2">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Jabatan / Regu</label>
                            <input type="text" name="jabatan" placeholder="Contoh: Anggota Regu TRC 1" 
                                   class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-orange-500 focus:ring-orange-500 py-2">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">No. WhatsApp / HP</label>
                            <input type="text" name="no_hp" placeholder="Contoh: 081234567890" 
                                   class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-orange-500 focus:ring-orange-500 py-2">
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-2 text-xs font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                            <input type="checkbox" name="status_aktif" value="1" checked class="rounded border-slate-300 dark:border-slate-700 text-orange-600 focus:ring-orange-500 bg-white dark:bg-slate-950">
                            <span>Akun Langsung Aktif</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" @click="showAddModal = false" class="px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-xs font-bold bg-orange-600 hover:bg-orange-700 text-white rounded-xl shadow-md shadow-orange-600/30">
                            Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL EDIT PENGGUNA -->
        <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4" x-cloak>
            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-800 animate-in fade-in zoom-in duration-200">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">
                        Edit Data Pengguna
                    </h3>
                    <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 font-bold text-lg">
                        &times;
                    </button>
                </div>

                <form :action="'{{ url('admin/users') }}/' + editUser.id" method="POST" class="space-y-3.5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1 flex items-center justify-between">
                            <span>Nama Lengkap <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <input type="text" name="name" x-model="editUser.name" required 
                               oninvalid="this.setCustomValidity('Nama lengkap harap diisi')"
                               oninput="this.setCustomValidity('')"
                               class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-orange-500 focus:ring-orange-500 py-2">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1 flex items-center justify-between">
                            <span>Email Dinas / Akun <span class="text-rose-500 font-bold">*</span></span>
                            <span class="text-[10px] text-rose-500 font-semibold normal-case">(Harap diisi)</span>
                        </label>
                        <input type="email" name="email" x-model="editUser.email" required 
                               oninvalid="this.setCustomValidity('Alamat email dinas harap diisi')"
                               oninput="this.setCustomValidity('')"
                               class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-orange-500 focus:ring-orange-500 py-2">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Role Hak Akses *</label>
                            <select name="role" x-model="editUser.role" required class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 focus:border-orange-500 focus:ring-orange-500 py-2">
                                <option value="petugas">Petugas TRC</option>
                                <option value="admin">Admin IT</option>
                                <option value="pimpinan">Pimpinan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Ganti Password (Opsional)</label>
                            <input type="password" name="password" placeholder="Kosongkan jika tak diubah" 
                                   class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-orange-500 focus:ring-orange-500 py-2">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Jabatan / Regu</label>
                            <input type="text" name="jabatan" x-model="editUser.jabatan" 
                                   class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-orange-500 focus:ring-orange-500 py-2">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">No. WhatsApp / HP</label>
                            <input type="text" name="no_hp" x-model="editUser.no_hp" 
                                   class="w-full text-xs rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-orange-500 focus:ring-orange-500 py-2">
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-2 text-xs font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                            <input type="checkbox" name="status_aktif" value="1" x-model="editUser.status_aktif" class="rounded border-slate-300 dark:border-slate-700 text-orange-600 focus:ring-orange-500 bg-white dark:bg-slate-950">
                            <span>Status Akun Aktif (Bisa Login)</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" @click="showEditModal = false" class="px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-xs font-bold bg-blue-900 hover:bg-blue-950 text-white rounded-xl shadow-md shadow-blue-900/30">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
