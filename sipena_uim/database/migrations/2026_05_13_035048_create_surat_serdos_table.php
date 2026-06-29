<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('surat_serdos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
        $table->string('nomor_surat')->unique();
        $table->string('program_studi');
        $table->string('bidang_ilmu');
        $table->integer('jumlah_sks')->default(0);
        $table->integer('tahun_mulai_mengajar');
        $table->text('mata_kuliah')->nullable();
        $table->enum('status', ['draft', 'diajukan', 'diverifikasi', 'ditolak'])->default('draft');
        $table->string('file_scan')->nullable();
        $table->text('catatan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_serdos');
    }
};
