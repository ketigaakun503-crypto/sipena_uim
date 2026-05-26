<?php

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\PengajuanCuti;
use App\Models\PengajuanLembur;
use App\Models\Pegawai;

class NotifikasiService
{
    public function kirim(int $userId, string $judul, string $pesan, string $tipe = 'info', string $url = null): void
    {
        Notifikasi::create([
            'user_id' => $userId,
            'judul'   => $judul,
            'pesan'   => $pesan,
            'tipe'    => $tipe,
            'url'     => $url,
        ]);
    }

    public function kirimCrossNotifikasi(PengajuanCuti $pengajuan): void
    {
        $pegawai = Pegawai::with('jabatanAktif.unitKerja')->findOrFail($pengajuan->pegawai_id);

        $notifData = [];

        foreach ($pegawai->jabatanAktif as $jabatan) {
            $atasanPegawaiJabatan = \App\Models\PegawaiJabatan::with('pegawai.user')
                ->whereHas('jabatan', function ($q) use ($jabatan) {
                    $q->where('unit_kerja_id', $jabatan->unit_kerja_id)
                      ->where('level', '<', $jabatan->level);
                })
                ->where('is_aktif', true)
                ->get();

            foreach ($atasanPegawaiJabatan as $atasanPJ) {
                if ($atasanPJ->pegawai && $atasanPJ->pegawai->user) {
                    $notifData[$atasanPJ->pegawai->user_id] = [
                        'user_id'    => $atasanPJ->pegawai->user_id,
                        'judul'      => 'Informasi Cuti Pegawai',
                        'pesan'      => "{$pegawai->nama_lengkap} sedang cuti ({$pengajuan->tanggal_mulai->format('d/m/Y')} - {$pengajuan->tanggal_selesai->format('d/m/Y')}) melalui jabatan di unit kerja Anda.",
                        'tipe'       => 'warning',
                        'url'        => null,
                        'dibaca'     => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        if (!empty($notifData)) {
            Notifikasi::insert(array_values($notifData));
        }
    }

    public function kirimNotifikasiLembur(PengajuanLembur $pengajuan): void
    {
        $pegawai = Pegawai::with('jabatanAktif.unitKerja')->findOrFail($pengajuan->pegawai_id);

        $notifData = [];

        foreach ($pegawai->jabatanAktif as $jabatan) {
            $atasanPegawaiJabatan = \App\Models\PegawaiJabatan::with('pegawai.user')
                ->whereHas('jabatan', function ($q) use ($jabatan) {
                    $q->where('unit_kerja_id', $jabatan->unit_kerja_id)
                      ->where('level', '<', $jabatan->level);
                })
                ->where('is_aktif', true)
                ->get();

            foreach ($atasanPegawaiJabatan as $atasanPJ) {
                if ($atasanPJ->pegawai && $atasanPJ->pegawai->user) {
                    $notifData[$atasanPJ->pegawai->user_id] = [
                        'user_id'    => $atasanPJ->pegawai->user_id,
                        'judul'      => 'Pengajuan Lembur Baru',
                        'pesan'      => "{$pegawai->nama_lengkap} mengajukan lembur pada " .
                                        \Carbon\Carbon::parse($pengajuan->tanggal_lembur)->format('d/m/Y') .
                                        " ({$pengajuan->jam_mulai} - {$pengajuan->jam_selesai}, {$pengajuan->jumlah_jam} jam). Silakan tinjau pengajuan.",
                        'tipe'       => 'warning',
                        'url'        => route('approver.lembur.show', $pengajuan->id),
                        'dibaca'     => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        if (!empty($notifData)) {
            Notifikasi::insert(array_values($notifData));
        }
    }

    public function tandaiDibaca(int $notifikasiId): void
    {
        Notifikasi::where('id', $notifikasiId)->update(['dibaca' => true]);
    }

    public function tandaiSemuaDibaca(int $userId): void
    {
        Notifikasi::where('user_id', $userId)->update(['dibaca' => true]);
    }
}