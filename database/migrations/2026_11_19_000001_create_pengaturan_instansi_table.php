<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_instansi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi')->default('Badan Penanggulangan Bencana Daerah Kota Pekanbaru');
            $table->string('singkatan')->default('BPBD Kota Pekanbaru');
            $table->string('nama_pemda')->default('Pemerintah Kota Pekanbaru');
            $table->string('nama_pimpinan')->default('Zarman Candra, S.STP, M.Si');
            $table->string('nip_pimpinan')->default('19750510 199402 1 001');
            $table->string('jabatan_pimpinan')->default('Kepala Pelaksana BPBD Kota Pekanbaru');
            $table->text('alamat')->nullable();
            $table->string('kontak')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_instansi');
    }
};
