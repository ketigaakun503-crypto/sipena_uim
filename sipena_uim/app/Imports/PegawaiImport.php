<?php

namespace App\Imports;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PegawaiImport
{
    public array $errors  = [];
    public int   $success = 0;

    public function import(string $filePath): void
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet       = $spreadsheet->getActiveSheet();
        $rows        = $sheet->toArray();

        // Skip header row
        foreach (array_slice($rows, 1) as $i => $row) {
            $line = $i + 2;

            // Skip baris kosong
            if (empty($row[0]) && empty($row[1])) continue;

            try {
                $namaLengkap  = trim($row[0] ?? '');
                $nip          = trim($row[1] ?? '') ?: null;
                $nidn         = trim($row[2] ?? '') ?: null;
                $email        = trim($row[3] ?? '');
                $jenisPegawai = strtolower(trim($row[4] ?? 'dosen'));
                $jenisKelamin = strtoupper(trim($row[5] ?? 'L'));
                $noHp         = trim($row[6] ?? '') ?: null;

                if (empty($namaLengkap) || empty($email)) {
                    $this->errors[] = "Baris {$line}: Nama dan email wajib diisi.";
                    continue;
                }

                if (User::where('email', $email)->exists()) {
                    $this->errors[] = "Baris {$line}: Email {$email} sudah terdaftar.";
                    continue;
                }

                // Buat user
                $user = User::create([
                    'name'     => $namaLengkap,
                    'email'    => $email,
                    'password' => Hash::make('password123'),
                ]);

                // Assign role
                $role = $jenisPegawai === 'dosen' ? 'dosen' : 'tendik';
                $user->assignRole($role);

                // Buat pegawai
                Pegawai::create([
                    'user_id'       => $user->id,
                    'nama_lengkap'  => $namaLengkap,
                    'nip'           => $nip,
                    'nidn'          => $nidn,
                    'email'         => $email,
                    'jenis_pegawai' => in_array($jenisPegawai, ['dosen', 'tendik']) ? $jenisPegawai : 'dosen',
                    'jenis_kelamin' => in_array($jenisKelamin, ['L', 'P']) ? $jenisKelamin : 'L',
                    'no_hp'         => $noHp,
                    'status'        => 'aktif',
                    'sisa_cuti'     => 12,
                ]);

                $this->success++;

            } catch (\Exception $e) {
                $this->errors[] = "Baris {$line}: " . $e->getMessage();
            }
        }
    }
}