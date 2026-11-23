<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_kejadian', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('warna')->default('#EF4444'); // Hex color for markers/badges
            $table->string('ikon')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('instansi_pendukung', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi');
            $table->string('kontak')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instansi_pendukung');
        Schema::dropIfExists('jenis_kejadian');
    }
};
