<x-app-layout>
    <x-slot name="header">
        Cetak PDF Laporan {{ $kejadian->nomor_laporan }}
    </x-slot>

    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
        <h3 class="text-lg font-bold text-slate-800 mb-2">Cetak Dokumen Resmi (Tahap 7)</h3>
        <p class="text-sm text-slate-500">Ekspor PDF resmi dengan kop surat BPBD Kota Pekanbaru, lampiran foto, dan kolom tanda tangan Kepala Pelaksana BPBD akan diimplementasikan penuh pada Tahap 7.</p>
        <div class="mt-4">
            <a href="{{ route('kejadian.show', $kejadian->id) }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold">
                Kembali ke Detail
            </a>
        </div>
    </div>
</x-app-layout>
