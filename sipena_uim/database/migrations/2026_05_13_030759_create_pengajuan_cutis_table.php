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
    Schema::create('pengajuan_cutis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
        $table->enum('jenis_cuti', ['tahunan', 'sakit', 'melahirkan', 'alasan_penting']);
        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai');
        $table->integer('jumlah_hari')->default(0);
        $table->text('alasan');
        $table->string('lampiran')->nullable();
        $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_cutis');
    }
};
