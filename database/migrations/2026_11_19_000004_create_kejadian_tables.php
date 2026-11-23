<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kejadian', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_laporan')->unique()->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('tanggal_kejadian')->index();
            $table->time('jam_kejadian');
            $table->time('jam_selesai')->nullable();
            
            $table->foreignId('jenis_kejadian_id')->constrained('jenis_kejadian')->restrictOnDelete()->index();
            $table->foreignId('kecamatan_id')->constrained('kecamatan')->restrictOnDelete()->index();
            $table->foreignId('kelurahan_id')->nullable()->constrained('kelurahan')->nullOnDelete();
            
            $table->text('lokasi_detail');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            
            $table->text('kronologi');
            $table->text('tindakan');
            $table->integer('jumlah_personel')->default(0);
            $table->string('sumber_informasi')->nullable(); // Warga, patroli, call center 112, dll
            
            // Dampak
            $table->decimal('luas_terbakar_ha', 8, 2)->nullable();
            $table->string('detail_hewan')->nullable(); // e.g. Ular Sanca 3.5m (1 ekor), Sarang Tawon Vespa
            $table->integer('korban_meninggal')->default(0);
            $table->integer('korban_luka')->default(0);
            $table->integer('kk_terdampak')->default(0);
            $table->integer('jiwa_terdampak')->default(0);
            $table->text('kerusakan_fasilitas')->nullable();
            
            // Status penanganan
            $table->enum('status', ['Dalam Penanganan', 'Selesai'])->default('Dalam Penanganan')->index();
            $table->text('catatan_status')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('kejadian_instansi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kejadian_id')->constrained('kejadian')->cascadeOnDelete();
            $table->foreignId('instansi_pendukung_id')->constrained('instansi_pendukung')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('foto_kejadian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kejadian_id')->constrained('kejadian')->cascadeOnDelete();
            $table->string('file_path');
            $table->string('caption')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_kejadian');
        Schema::dropIfExists('kejadian_instansi');
        Schema::dropIfExists('kejadian');
    }
};
