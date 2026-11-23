<?php

namespace App\Http\Controllers;

use App\Models\PengaturanInstansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanInstansiController extends Controller
{
    /**
     * Tampilkan form pengaturan instansi & kop surat
     */
    public function index()
    {
        $pengaturan = PengaturanInstansi::getPengaturan();
        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    /**
     * Simpan pembaruan profil instansi & pejabat penandatangan
     */
    public function update(Request $request)
    {
        $pengaturan = PengaturanInstansi::getPengaturan();

        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'nama_pemda' => 'required|string|max:255',
            'nama_pimpinan' => 'required|string|max:255',
            'nip_pimpinan' => 'required|string|max:50',
            'jabatan_pimpinan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ], [
            'nama_instansi.required' => 'Nama instansi wajib diisi.',
            'nama_pemda.required' => 'Nama pemerintah daerah wajib diisi.',
            'nama_pimpinan.required' => 'Nama Kepala/Pimpinan wajib diisi.',
            'nip_pimpinan.required' => 'NIP pimpinan wajib diisi.',
            'jabatan_pimpinan.required' => 'Jabatan pimpinan penandatangan wajib diisi.',
            'alamat.required' => 'Alamat kop surat wajib diisi.',
            'logo.image' => 'File logo harus berupa gambar (PNG, JPG, SVG, WEBP).',
            'logo.max' => 'Ukuran file logo maksimal 2 MB.',
        ]);

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($pengaturan->logo_path && Storage::disk('public')->exists($pengaturan->logo_path)) {
                Storage::disk('public')->delete($pengaturan->logo_path);
            }

            $path = $request->file('logo')->store('logo', 'public');
            $validated['logo_path'] = $path;
        }

        unset($validated['logo']);

        $pengaturan->update($validated);

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Pengaturan instansi, data kop surat, dan pejabat penandatangan berhasil disimpan.');
    }
}
