<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKejadianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal_kejadian' => ['required', 'date'],
            'jam_kejadian' => ['required'],
            'jam_selesai' => ['nullable'],
            'jenis_kejadian_id' => ['required', 'exists:jenis_kejadian,id'],
            'kecamatan_id' => ['required', 'exists:kecamatan,id'],
            'kelurahan_id' => ['nullable', 'exists:kelurahan,id'],
            'lokasi_detail' => ['required', 'string', 'max:1000'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'kronologi' => ['required', 'string'],
            'tindakan' => ['required', 'string'],
            'jumlah_personel' => ['nullable', 'integer', 'min:0'],
            'sumber_informasi' => ['nullable', 'string', 'max:255'],
            'instansi_ids' => ['nullable', 'array'],
            'instansi_ids.*' => ['exists:instansi_pendukung,id'],
            'luas_terbakar_ha' => ['nullable', 'numeric', 'min:0'],
            'detail_hewan' => ['nullable', 'string', 'max:255'],
            'korban_meninggal' => ['nullable', 'integer', 'min:0'],
            'korban_luka' => ['nullable', 'integer', 'min:0'],
            'kk_terdampak' => ['nullable', 'integer', 'min:0'],
            'jiwa_terdampak' => ['nullable', 'integer', 'min:0'],
            'kerusakan_fasilitas' => ['nullable', 'string'],
            'status' => ['required', 'in:Dalam Penanganan,Selesai'],
            'catatan_status' => ['nullable', 'string'],
            'foto' => ['nullable', 'array', 'max:5'],
            'foto.*' => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'captions' => ['nullable', 'array'],
            'captions.*' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_kejadian.required' => 'Tanggal kejadian wajib diisi.',
            'jam_kejadian.required' => 'Jam kejadian wajib diisi.',
            'jenis_kejadian_id.required' => 'Pilih salah satu jenis kejadian bencana.',
            'kecamatan_id.required' => 'Kecamatan wajib dipilih.',
            'lokasi_detail.required' => 'Alamat atau detail lokasi kejadian wajib diisi.',
            'kronologi.required' => 'Uraian kronologi kejadian wajib diisi.',
            'tindakan.required' => 'Uraian tindakan penanganan wajib diisi.',
            'status.required' => 'Status penanganan wajib ditentukan.',
            'foto.max' => 'Maksimal 5 foto per laporan kejadian.',
            'foto.*.image' => 'Berkas dokumentasi harus berupa gambar.',
            'foto.*.mimes' => 'Format foto hanya diperbolehkan JPG, PNG, atau WEBP.',
            'foto.*.max' => 'Ukuran maksimal tiap foto adalah 5 MB.',
        ];
    }
}
