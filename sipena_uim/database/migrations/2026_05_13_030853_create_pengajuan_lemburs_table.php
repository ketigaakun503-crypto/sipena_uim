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
    Schema::create('pengajuan_lemburs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
        $table->date('tanggal_lembur');
        $table->time('jam_mulai');
        $table->time('jam_selesai');
        $table->decimal('jumlah_jam', 4, 2)->default(0);
        $table->text('alasan');
        $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
        $table->text('catatan_approver')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_lemburs');
    }
};
