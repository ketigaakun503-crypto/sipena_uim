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
    Schema::create('surat_jafas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
        $table->string('nomor_surat')->unique();
        $table->string('jabatan_fungsional_diajukan');
        $table->string('jabatan_fungsional_sekarang');
        $table->string('pangkat_golongan');
        $table->date('tmt_pangkat');
        $table->text('daftar_karya')->nullable();
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
        Schema::dropIfExists('surat_jafas');
    }
};
