<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKejadianRequest;
use App\Http\Requests\UpdateKejadianRequest;
use App\Models\Kejadian;
use App\Models\JenisKejadian;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\InstansiPendukung;
use App\Models\FotoKejadian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KejadianController extends Controller
{
    public function index(Request $request)
    {
        $query = Kejadian::with(['jenisKejadian', 'kecamatan', 'kelurahan', 'user', 'foto'])
            ->latest('tanggal_kejadian')
            ->latest('jam_kejadian');

        if ($request->filled('search')) {
            $query->filter(['search' => $request->search]);
        }
        if ($request->filled('jenis_id')) {
            $query->where('jenis_kejadian_id', $request->jenis_id);
        }
        if ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->kecamatan_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_kejadian', $request->tanggal);
        }
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_kejadian', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_kejadian', '<=', $request->tanggal_selesai);
        }

        $kejadian = $query->paginate(10)->withQueryString();
        $jenisList = JenisKejadian::all();
        $kecamatanList = Kecamatan::all();

        return view('kejadian.index', compact('kejadian', 'jenisList', 'kecamatanList'));
    }

    public function create()
    {
        $nomorLaporanPreview = Kejadian::generateNomorLaporan();
        $jenisList = JenisKejadian::all();
        $kecamatanList = Kecamatan::with('kelurahan')->orderBy('nama_kecamatan')->get();
        $instansiList = InstansiPendukung::orderBy('nama_instansi')->get();

        return view('kejadian.create', compact('nomorLaporanPreview', 'jenisList', 'kecamatanList', 'instansiList'));
    }

    public function store(StoreKejadianRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // Generate nomor laporan resmi sesuai tanggal kejadian
            $nomorLaporan = Kejadian::generateNomorLaporan($validated['tanggal_kejadian']);

            $kejadian = Kejadian::create([
                'nomor_laporan' => $nomorLaporan,
                'user_id' => Auth::id(),
                'tanggal_kejadian' => $validated['tanggal_kejadian'],
                'jam_kejadian' => $validated['jam_kejadian'],
                'jam_selesai' => $validated['jam_selesai'] ?? null,
                'jenis_kejadian_id' => $validated['jenis_kejadian_id'],
                'kecamatan_id' => $validated['kecamatan_id'],
                'kelurahan_id' => $validated['kelurahan_id'] ?? null,
                'lokasi_detail' => $validated['lokasi_detail'],
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'kronologi' => $validated['kronologi'],
                'tindakan' => $validated['tindakan'],
                'jumlah_personel' => $validated['jumlah_personel'] ?? 0,
                'sumber_informasi' => $validated['sumber_informasi'] ?? null,
                'luas_terbakar_ha' => $validated['luas_terbakar_ha'] ?? null,
                'detail_hewan' => $validated['detail_hewan'] ?? null,
                'korban_meninggal' => $validated['korban_meninggal'] ?? 0,
                'korban_luka' => $validated['korban_luka'] ?? 0,
                'kk_terdampak' => $validated['kk_terdampak'] ?? 0,
                'jiwa_terdampak' => $validated['jiwa_terdampak'] ?? 0,
                'kerusakan_fasilitas' => $validated['kerusakan_fasilitas'] ?? null,
                'status' => $validated['status'],
                'catatan_status' => $validated['catatan_status'] ?? null,
            ]);

            // Sinkronisasi instansi pendukung
            if (!empty($validated['instansi_ids'])) {
                $kejadian->instansiPendukung()->sync($validated['instansi_ids']);
            }

            // Simpan foto dokumentasi (maks 5 foto)
            if ($request->hasFile('foto')) {
                $uploadedFiles = $request->file('foto');
                $captions = $request->input('captions', []);

                foreach ($uploadedFiles as $index => $file) {
                    if ($file && $file->isValid()) {
                        $path = $file->store("foto_kejadian/{$kejadian->id}", 'public');
                        $caption = $captions[$index] ?? 'Dokumentasi penanganan di lapangan';

                        FotoKejadian::create([
                            'kejadian_id' => $kejadian->id,
                            'file_path' => $path,
                            'caption' => $caption,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('kejadian.success', $kejadian->id)
                ->with('success', 'Laporan kejadian bencana berhasil disimpan dengan nomor: ' . $nomorLaporan);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan laporan: ' . $e->getMessage());
        }
    }

    public function success($id)
    {
        $kejadian = Kejadian::with(['jenisKejadian', 'kecamatan', 'kelurahan', 'foto'])->findOrFail($id);
        return view('kejadian.success', compact('kejadian'));
    }

    public function show($id)
    {
        $kejadian = Kejadian::with(['jenisKejadian', 'kecamatan', 'kelurahan', 'instansiPendukung', 'foto', 'user'])->findOrFail($id);
        return view('kejadian.show', compact('kejadian'));
    }

    public function edit($id)
    {
        $kejadian = Kejadian::with(['instansiPendukung', 'foto'])->findOrFail($id);

        if (Auth::user()->isPetugas() && $kejadian->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak: Anda hanya dapat mengedit laporan yang Anda buat sendiri.');
        }

        $jenisList = JenisKejadian::all();
        $kecamatanList = Kecamatan::with('kelurahan')->orderBy('nama_kecamatan')->get();
        $instansiList = InstansiPendukung::orderBy('nama_instansi')->get();

        return view('kejadian.edit', compact('kejadian', 'jenisList', 'kecamatanList', 'instansiList'));
    }

    public function update(UpdateKejadianRequest $request, $id)
    {
        $kejadian = Kejadian::findOrFail($id);

        if (Auth::user()->isPetugas() && $kejadian->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak: Anda hanya dapat mengedit laporan yang Anda buat sendiri.');
        }

        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $kejadian->update([
                'tanggal_kejadian' => $validated['tanggal_kejadian'],
                'jam_kejadian' => $validated['jam_kejadian'],
                'jam_selesai' => $validated['jam_selesai'] ?? null,
                'jenis_kejadian_id' => $validated['jenis_kejadian_id'],
                'kecamatan_id' => $validated['kecamatan_id'],
                'kelurahan_id' => $validated['kelurahan_id'] ?? null,
                'lokasi_detail' => $validated['lokasi_detail'],
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'kronologi' => $validated['kronologi'],
                'tindakan' => $validated['tindakan'],
                'jumlah_personel' => $validated['jumlah_personel'] ?? 0,
                'sumber_informasi' => $validated['sumber_informasi'] ?? null,
                'luas_terbakar_ha' => $validated['luas_terbakar_ha'] ?? null,
                'detail_hewan' => $validated['detail_hewan'] ?? null,
                'korban_meninggal' => $validated['korban_meninggal'] ?? 0,
                'korban_luka' => $validated['korban_luka'] ?? 0,
                'kk_terdampak' => $validated['kk_terdampak'] ?? 0,
                'jiwa_terdampak' => $validated['jiwa_terdampak'] ?? 0,
                'kerusakan_fasilitas' => $validated['kerusakan_fasilitas'] ?? null,
                'status' => $validated['status'],
                'catatan_status' => $validated['catatan_status'] ?? null,
            ]);

            // Sync instansi pendukung
            $kejadian->instansiPendukung()->sync($validated['instansi_ids'] ?? []);

            // Upload foto tambahan jika ada
            if ($request->hasFile('foto')) {
                $currentCount = $kejadian->foto()->count();
                $uploadedFiles = $request->file('foto');
                $captions = $request->input('captions', []);

                foreach ($uploadedFiles as $index => $file) {
                    if ($currentCount >= 5) break; // Maksimal 5 foto per laporan
                    if ($file && $file->isValid()) {
                        $path = $file->store("foto_kejadian/{$kejadian->id}", 'public');
                        $caption = $captions[$index] ?? 'Dokumentasi penanganan';

                        FotoKejadian::create([
                            'kejadian_id' => $kejadian->id,
                            'file_path' => $path,
                            'caption' => $caption,
                        ]);
                        $currentCount++;
                    }
                }
            }

            DB::commit();

            return redirect()->route('kejadian.show', $kejadian->id)
                ->with('success', 'Laporan ' . $kejadian->nomor_laporan . ' berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui laporan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $kejadian = Kejadian::findOrFail($id);

        // Hanya Admin atau Pembuat Laporan yang dapat menghapus
        if (Auth::user()->isPetugas() && $kejadian->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak: Anda hanya dapat menghapus laporan yang Anda buat sendiri.');
        }

        $nomor = $kejadian->nomor_laporan;
        $kejadian->delete(); // Soft delete

        return redirect()->route('kejadian.index')
            ->with('success', 'Laporan kejadian ' . $nomor . ' berhasil dihapus.');
    }

    public function hapusFoto($id)
    {
        $foto = FotoKejadian::findOrFail($id);
        $kejadian = $foto->kejadian;

        if (Auth::user()->isPetugas() && $kejadian->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        Storage::disk('public')->delete($foto->file_path);
        $foto->delete();

        return back()->with('success', 'Foto dokumentasi berhasil dihapus.');
    }
}
