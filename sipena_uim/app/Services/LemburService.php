<?php

namespace App\Services;

use App\Models\LemburApproval;
use App\Models\PengajuanLembur;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LemburService
{
    public function __construct(protected NotifikasiService $notifikasiService) {}

    public function hitungJamLembur(string $jamMulai, string $jamSelesai): float
    {
        $mulai   = Carbon::parse($jamMulai);
        $selesai = Carbon::parse($jamSelesai);
        return round($mulai->diffInMinutes($selesai) / 60, 2);
    }

    public function ajukan(array $data, int $pegawaiId): void
    {
        DB::transaction(function () use ($data, $pegawaiId) {
            $pegawai   = Pegawai::with('jabatanAktif')->findOrFail($pegawaiId);
            $jumlahJam = $this->hitungJamLembur($data['jam_mulai'], $data['jam_selesai']);

            $lembur = PengajuanLembur::create([
                'pegawai_id'     => $pegawaiId,
                'tanggal_lembur' => $data['tanggal_lembur'],
                'jam_mulai'      => $data['jam_mulai'],
                'jam_selesai'    => $data['jam_selesai'],
                'jumlah_jam'     => $jumlahJam,
                'alasan'         => $data['alasan'],
                'status'         => 'menunggu',
            ]);

            // Generate approval ke atasan jabatan utama
            $jabatanUtama = $pegawai->jabatanAktif->where('pivot.jenis', 'utama')->first();
            if ($jabatanUtama) {
                $atasanJabatan = \App\Models\Jabatan::where('unit_kerja_id', $jabatanUtama->unit_kerja_id)
                    ->where('level', '<', $jabatanUtama->level)
                    ->orderByDesc('level')
                    ->first();

                if ($atasanJabatan) {
                    $atasanPegawai = \App\Models\PegawaiJabatan::where('jabatan_id', $atasanJabatan->id)
                        ->where('is_aktif', true)
                        ->first();

                    if ($atasanPegawai) {
                        LemburApproval::create([
                            'pengajuan_lembur_id' => $lembur->id,
                            'approver_id'         => $atasanPegawai->pegawai->user_id,
                            'status'              => 'menunggu',
                        ]);
                    }
                }
            }

            // Kirim notifikasi ke semua atasan
            $this->notifikasiService->kirimNotifikasiLembur($lembur);
        });
    }

    public function getRiwayat(int $pegawaiId)
    {
        return PengajuanLembur::with('approvals.approver')
            ->where('pegawai_id', $pegawaiId)
            ->latest()
            ->get();
    }
}