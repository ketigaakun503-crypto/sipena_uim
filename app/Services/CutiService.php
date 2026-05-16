<?php

namespace App\Services;

use App\Models\CutiApproval;
use App\Models\PengajuanCuti;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CutiService
{
    public function getPengajuanByPegawai(int $pegawaiId)
    {
        return PengajuanCuti::with('approvals.approver')
            ->where('pegawai_id', $pegawaiId)
            ->latest()
            ->get();
    }

    public function hitungHariKerja(string $mulai, string $selesai): int
    {
        $start = Carbon::parse($mulai);
        $end   = Carbon::parse($selesai);
        $hari  = 0;

        while ($start->lte($end)) {
            if (!$start->isWeekend()) {
                $hari++;
            }
            $start->addDay();
        }

        return $hari;
    }

    public function ajukan(array $data, int $pegawaiId): void
    {
        DB::transaction(function () use ($data, $pegawaiId) {
            $pegawai   = Pegawai::with('jabatanAktif.unitKerja')->findOrFail($pegawaiId);
            $jumlahHari = $this->hitungHariKerja($data['tanggal_mulai'], $data['tanggal_selesai']);

            // Buat pengajuan cuti
            $pengajuan = PengajuanCuti::create([
                'pegawai_id'      => $pegawaiId,
                'jenis_cuti'      => $data['jenis_cuti'],
                'tanggal_mulai'   => $data['tanggal_mulai'],
                'tanggal_selesai' => $data['tanggal_selesai'],
                'jumlah_hari'     => $jumlahHari,
                'alasan'          => $data['alasan'],
                'status'          => 'menunggu',
            ]);

            // ✅ SMART LEAVE: Generate approval untuk SEMUA atasan dari SEMUA jabatan aktif
            $this->applyKeSemuaJabatan($pengajuan, $pegawai);
        });
    }

    public function applyKeSemuaJabatan(PengajuanCuti $pengajuan, Pegawai $pegawai): void
    {
        foreach ($pegawai->jabatanAktif as $jabatan) {
            // Cari atasan langsung berdasarkan unit kerja & level jabatan
            $atasanJabatan = \App\Models\Jabatan::where('unit_kerja_id', $jabatan->unit_kerja_id)
                ->where('level', '<', $jabatan->level)
                ->orderByDesc('level')
                ->first();

            if ($atasanJabatan) {
                // Cari user yang memegang jabatan atasan tsb
                $atasanPegawai = \App\Models\PegawaiJabatan::where('jabatan_id', $atasanJabatan->id)
                    ->where('is_aktif', true)
                    ->first();

                if ($atasanPegawai) {
                    CutiApproval::create([
                        'pengajuan_cuti_id' => $pengajuan->id,
                        'approver_id'       => $atasanPegawai->pegawai->user_id,
                        'jabatan_id'        => $jabatan->id,
                        'status'            => 'menunggu',
                    ]);
                }
            }
        }
    }

    public function getRiwayat(int $pegawaiId)
    {
        return PengajuanCuti::with(['approvals.approver', 'approvals.jabatan'])
            ->where('pegawai_id', $pegawaiId)
            ->latest()
            ->get();
    }
}