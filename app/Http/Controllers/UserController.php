<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Tampilkan daftar akun pengguna dengan filter & statistik
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $status = $request->input('status');

        $query = User::query()->withCount('kejadian');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        if ($role) {
            $query->where('role', $role);
        }

        if ($status !== null && $status !== '') {
            $query->where('status_aktif', (bool) $status);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        // Statistik Role Pengguna
        $totalUsers = User::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalPimpinan = User::where('role', 'pimpinan')->count();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'totalAdmin',
            'totalPetugas',
            'totalPimpinan',
            'search',
            'role',
            'status'
        ));
    }

    /**
     * Simpan pengguna baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,petugas,pimpinan',
            'jabatan' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'status_aktif' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 6 karakter.',
            'role.required' => 'Role pengguna wajib dipilih.',
            'role.in' => 'Role yang dipilih tidak valid.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'jabatan' => $validated['jabatan'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'status_aktif' => $request->has('status_aktif') ? (bool) $request->input('status_aktif') : true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna baru berhasil ditambahkan.');
    }

    /**
     * Perbarui data pengguna
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,petugas,pimpinan',
            'jabatan' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'status_aktif' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan pengguna lain.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'role.required' => 'Role pengguna wajib dipilih.',
        ]);

        // Pencegahan: Admin tidak boleh men-downgrade akunnya sendiri saat sedang login
        if ($user->id === Auth::id() && $validated['role'] !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri yang sedang aktif.');
        }

        // Pencegahan: Admin tidak boleh menonaktifkan akunnya sendiri
        $statusAktif = $request->has('status_aktif') ? (bool) $request->input('status_aktif') : false;
        if ($user->id === Auth::id() && !$statusAktif) {
            return redirect()->back()->with('error', 'Anda tidak dapat menonaktifkan akun yang sedang Anda gunakan.');
        }

        $dataUpdate = [
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'role' => $validated['role'],
            'jabatan' => $validated['jabatan'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'status_aktif' => $statusAktif,
        ];

        if (!empty($validated['password'])) {
            $dataUpdate['password'] = Hash::make($validated['password']);
        }

        $user->update($dataUpdate);

        return redirect()->route('admin.users.index')->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
    }

    /**
     * Hapus akun pengguna
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jangan hapus akun sendiri
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Periksa apakah user memiliki relasi data kejadian
        $kejadianCount = $user->kejadian()->count();
        if ($kejadianCount > 0) {
            return redirect()->back()->with('error', "Pengguna {$user->name} memiliki {$kejadianCount} data laporan kejadian. Untuk menjaga integritas data, nonaktifkan akun pengguna ini alih-alih menghapusnya.");
        }

        $nama = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "Akun pengguna {$nama} berhasil dihapus.");
    }

    /**
     * Toggle status aktif / nonaktif cepat
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah status akun Anda sendiri.');
        }

        $user->status_aktif = !$user->status_aktif;
        $user->save();

        $statusStr = $user->status_aktif ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Akun {$user->name} berhasil {$statusStr}.");
    }
}
