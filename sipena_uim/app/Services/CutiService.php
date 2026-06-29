<?php

namespace App\Services;

use App\Models\CutiApproval;
use App\Models\PengajuanCuti;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CutiService
{
    public function __construct(
        protected NotifikasiService $notifikasiService
    ) {}

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
            if (!$start->isWeekend()) $hari++;
            $start->addDay();
        }

        return $hari;
    }

    public function ajukan(array $data, int $pegawaiId): void
    {
        DB::transaction(function () use ($data, $pegawaiId) {
            $pegawai    = Pegawai::with('jabatanAktif.unitKerja')->findOrFail($pegawaiId);
            $jumlahHari = $this->hitungHariKerja($data['tanggal_mulai'], $data['tanggal_selesai']);

            $pengajuan = PengajuanCuti::create([
                'pegawai_id'      => $pegawaiId,
                'jenis_cuti'      => $data['jenis_cuti'],
                'tanggal_mulai'   => $data['tanggal_mulai'],
                'tanggal_selesai' => $data['tanggal_selesai'],
                'jumlah_hari'     => $jumlahHari,
                'alasan'          => $data['alasan'],
                'status'          => 'menunggu',
            ]);

            $this->applyKeSemuaJabatan($pengajuan, $pegawai);
        });
    }

    public function applyKeSemuaJabatan(PengajuanCuti $pengajuan, Pegawai $pegawai): void
    {
        $sudahDiproses = [];

        foreach ($pegawai->jabatanAktif as $jabatan) {
            $atasanJabatan = \App\Models\Jabatan::where('unit_kerja_id', $jabatan->unit_kerja_id)
                ->where('level', '<', $jabatan->level)
                ->orderByDesc('level')
                ->first();

            if (!$atasanJabatan) {
                $unitKerja = \App\Models\UnitKerja::find($jabatan->unit_kerja_id);
                if ($unitKerja && $unitKerja->parent_id) {
                    $atasanJabatan = \App\Models\Jabatan::where('unit_kerja_id', $unitKerja->parent_id)
                        ->orderBy('level')
                        ->first();
                }
            }

            if (!$atasanJabatan) continue;

            $atasanPegawaiJabatan = \App\Models\PegawaiJabatan::with('pegawai')
                ->where('jabatan_id', $atasanJabatan->id)
                ->where('is_aktif', true)
                ->first();

            if (!$atasanPegawaiJabatan || !$atasanPegawaiJabatan->pegawai) continue;

            $approverId = $atasanPegawaiJabatan->pegawai->user_id;

            if (in_array($approverId, $sudahDiproses)) continue;
            if ($approverId === $pegawai->user_id) continue;

            $sudahDiproses[] = $approverId;

            CutiApproval::create([
                'pengajuan_cuti_id' => $pengajuan->id,
                'approver_id'       => $approverId,
                'jabatan_id'        => $jabatan->id,
                'status'            => 'menunggu',
            ]);

            // ✅ Kirim notifikasi ke setiap approver
            $this->notifikasiService->kirim(
                $approverId,
                'Pengajuan Cuti Baru',
                "{$pegawai->nama_lengkap} mengajukan cuti " .
                ucwords(str_replace('_', ' ', $pengajuan->jenis_cuti)) .
                " ({$pengajuan->tanggal_mulai->format('d/m/Y')} - {$pengajuan->tanggal_selesai->format('d/m/Y')}, {$pengajuan->jumlah_hari} hari). Mohon segera diproses.",
                'info',
                route('approval.index')
            );
        }

        // Fallback ke Admin SDM kalau tidak ada approver
        if (empty($sudahDiproses)) {
            $adminUser = \App\Models\User::role('admin_sdm')->first();
            if ($adminUser) {
                CutiApproval::create([
                    'pengajuan_cuti_id' => $pengajuan->id,
                    'approver_id'       => $adminUser->id,
                    'jabatan_id'        => $pegawai->jabatanAktif->first()?->id,
                    'status'            => 'menunggu',
                ]);

                $this->notifikasiService->kirim(
                    $adminUser->id,
                    'Pengajuan Cuti Baru',
                    "{$pegawai->nama_lengkap} mengajukan cuti dan tidak ditemukan atasan langsung. Mohon diproses secara manual.",
                    'warning',
                    route('approval.index')
                );
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