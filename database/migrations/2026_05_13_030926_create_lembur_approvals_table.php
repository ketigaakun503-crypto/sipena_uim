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
    Schema::create('lembur_approvals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pengajuan_lembur_id')->constrained()->cascadeOnDelete();
        $table->foreignId('approver_id')->constrained('users')->cascadeOnDelete();
        $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
        $table->text('catatan')->nullable();
        $table->timestamp('diproses_pada')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembur_approvals');
    }
};
