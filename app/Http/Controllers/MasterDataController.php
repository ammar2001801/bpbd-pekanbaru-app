<?php

namespace App\Http\Controllers;

use App\Models\JenisKejadian;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\InstansiPendukung;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterDataController extends Controller
{
    /**
     * Halaman Utama Master Data (Ber-tab)
     */
    public function index(Request $request)
    {
        $activeTab = $request->input('tab', 'jenis');

        $jenisList = JenisKejadian::withCount('kejadian')->get();
        $instansiList = InstansiPendukung::withCount('kejadian')->get();
        $kecamatanList = Kecamatan::withCount(['kelurahan', 'kejadian'])->orderBy('nama_kecamatan')->get();
        
        $selectedKecamatanId = $request->input('kecamatan_id');
        $kelurahanQuery = Kelurahan::with(['kecamatan'])->withCount('kejadian');
        if ($selectedKecamatanId) {
            $kelurahanQuery->where('kecamatan_id', $selectedKecamatanId);
        }
        $kelurahanList = $kelurahanQuery->orderBy('nama_kelurahan')->paginate(20)->withQueryString();

        return view('admin.master.index', compact(
            'activeTab',
            'jenisList',
            'instansiList',
            'kecamatanList',
            'kelurahanList',
            'selectedKecamatanId'
        ));
    }

    /**
     * CRUD: Jenis Kejadian
     */
    public function storeJenis(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:jenis_kejadian,nama',
            'warna' => 'required|string|max:20',
            'ikon' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'nama.required' => 'Nama jenis kejadian wajib diisi.',
            'nama.unique' => 'Jenis kejadian ini sudah ada.',
            'warna.required' => 'Warna penanda wajib dipilih.',
        ]);

        JenisKejadian::create([
            'nama' => $validated['nama'],
            'slug' => Str::slug($validated['nama']),
            'warna' => $validated['warna'],
            'ikon' => $validated['ikon'] ?? 'alert-triangle',
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('admin.master.index', ['tab' => 'jenis'])->with('success', 'Jenis kejadian baru berhasil ditambahkan.');
    }

    public function updateJenis(Request $request, $id)
    {
        $jenis = JenisKejadian::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:jenis_kejadian,nama,' . $jenis->id,
            'warna' => 'required|string|max:20',
            'ikon' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'nama.required' => 'Nama jenis kejadian wajib diisi.',
            'nama.unique' => 'Jenis kejadian dengan nama ini sudah ada.',
        ]);

        $jenis->update([
            'nama' => $validated['nama'],
            'slug' => Str::slug($validated['nama']),
            'warna' => $validated['warna'],
            'ikon' => $validated['ikon'] ?? $jenis->ikon,
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('admin.master.index', ['tab' => 'jenis'])->with('success', "Jenis kejadian {$jenis->nama} berhasil diperbarui.");
    }

    public function destroyJenis($id)
    {
        $jenis = JenisKejadian::findOrFail($id);

        if ($jenis->kejadian()->count() > 0) {
            return redirect()->route('admin.master.index', ['tab' => 'jenis'])
                ->with('error', "Jenis kejadian '{$jenis->nama}' tidak dapat dihapus karena telah terhubung dengan data laporan kejadian.");
        }

        $nama = $jenis->nama;
        $jenis->delete();

        return redirect()->route('admin.master.index', ['tab' => 'jenis'])->with('success', "Jenis kejadian {$nama} berhasil dihapus.");
    }

    /**
     * CRUD: Instansi Pendukung
     */
    public function storeInstansi(Request $request)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:150|unique:instansi_pendukung,nama_instansi',
            'kontak' => 'nullable|string|max:100',
        ], [
            'nama_instansi.required' => 'Nama instansi pendukung wajib diisi.',
            'nama_instansi.unique' => 'Instansi ini sudah ada.',
        ]);

        InstansiPendukung::create($validated);

        return redirect()->route('admin.master.index', ['tab' => 'instansi'])->with('success', 'Instansi pendukung berhasil ditambahkan.');
    }

    public function updateInstansi(Request $request, $id)
    {
        $instansi = InstansiPendukung::findOrFail($id);

        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:150|unique:instansi_pendukung,nama_instansi,' . $instansi->id,
            'kontak' => 'nullable|string|max:100',
        ]);

        $instansi->update($validated);

        return redirect()->route('admin.master.index', ['tab' => 'instansi'])->with('success', "Instansi pendukung {$instansi->nama_instansi} berhasil diperbarui.");
    }

    public function destroyInstansi($id)
    {
        $instansi = InstansiPendukung::findOrFail($id);

        if ($instansi->kejadian()->count() > 0) {
            return redirect()->route('admin.master.index', ['tab' => 'instansi'])
                ->with('error', "Instansi pendukung '{$instansi->nama_instansi}' tidak dapat dihapus karena telah tercatat dalam laporan kejadian.");
        }

        $nama = $instansi->nama_instansi;
        $instansi->delete();

        return redirect()->route('admin.master.index', ['tab' => 'instansi'])->with('success', "Instansi {$nama} berhasil dihapus.");
    }

    /**
     * CRUD: Kelurahan
     */
    public function storeKelurahan(Request $request)
    {
        $validated = $request->validate([
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'nama_kelurahan' => 'required|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
        ], [
            'kecamatan_id.required' => 'Kecamatan wajib dipilih.',
            'nama_kelurahan.required' => 'Nama kelurahan wajib diisi.',
        ]);

        Kelurahan::create($validated);

        return redirect()->route('admin.master.index', ['tab' => 'wilayah', 'kecamatan_id' => $validated['kecamatan_id']])
            ->with('success', 'Kelurahan baru berhasil ditambahkan.');
    }

    public function destroyKelurahan($id)
    {
        $kelurahan = Kelurahan::findOrFail($id);

        if ($kelurahan->kejadian()->count() > 0) {
            return redirect()->route('admin.master.index', ['tab' => 'wilayah'])
                ->with('error', "Kelurahan '{$kelurahan->nama_kelurahan}' tidak dapat dihapus karena tercatat dalam riwayat laporan kejadian.");
        }

        $nama = $kelurahan->nama_kelurahan;
        $kecId = $kelurahan->kecamatan_id;
        $kelurahan->delete();

        return redirect()->route('admin.master.index', ['tab' => 'wilayah', 'kecamatan_id' => $kecId])
            ->with('success', "Kelurahan {$nama} berhasil dihapus.");
    }
}
