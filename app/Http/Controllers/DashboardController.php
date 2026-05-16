<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PengajuanCuti;
use App\Models\PengajuanLembur;
use App\Models\SuratJafa;
use App\Models\SuratSerdos;
use App\Models\CutiApproval;
use App\Models\LemburApproval;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->hasRole('admin_sdm')) {
            return $this->dashboardAdmin();
        } elseif ($user->hasAnyRole(['rektor', 'wakil_rektor', 'dekan', 'kaprodi', 'ka_biro'])) {
            return $this->dashboardPejabat($user);
        } else {
            return $this->dashboardPegawai($user);
        }
    }


    private function dashboardAdmin()
    {
        $stats = [
            'total_pegawai'  => Pegawai::count(),
            'total_dosen'    => Pegawai::where('jenis_pegawai', 'dosen')->count(),
            'total_tendik'   => Pegawai::where('jenis_pegawai', 'tendik')->count(),
            'cuti_menunggu'  => PengajuanCuti::where('status', 'menunggu')->count(),
            'lembur_menunggu'=> PengajuanLembur::where('status', 'menunggu')->count(),
            'jafa_menunggu'  => SuratJafa::where('status', 'diajukan')->count(),
            'serdos_menunggu'=> SuratSerdos::where('status', 'diajukan')->count(),
        ];

        // Data chart: cuti per bulan tahun ini
        $cutiPerBulan = PengajuanCuti::selectRaw('MONTH(tanggal_mulai) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_mulai', now()->year)
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $chartCuti = array_fill(1, 12, 0);
        foreach ($cutiPerBulan as $bulan => $total) {
            $chartCuti[$bulan] = $total;
        }

        return view('dashboard.admin', compact('stats', 'chartCuti'));
    }

    private function dashboardPejabat($user)
    {
        $queueCuti   = CutiApproval::with(['pengajuanCuti.pegawai'])
            ->where('approver_id', $user->id)
            ->where('status', 'menunggu')
            ->count();

        $queueLembur = LemburApproval::where('approver_id', $user->id)
            ->where('status', 'menunggu')
            ->count();

        return view('dashboard.pejabat', compact('queueCuti', 'queueLembur', 'user'));
    }

    private function dashboardPegawai($user)
    {
        $pegawai = $user->pegawai;

        if (!$pegawai) {
            return view('dashboard.index');
        }

        $sisaCuti      = $pegawai->sisa_cuti;
        $totalPengajuan = PengajuanCuti::where('pegawai_id', $pegawai->id)->count();
        $jafaProgress  = SuratJafa::where('pegawai_id', $pegawai->id)->latest()->first();
        $serdosProgress = SuratSerdos::where('pegawai_id', $pegawai->id)->latest()->first();

        return view('dashboard.pegawai', compact(
            'pegawai', 'sisaCuti', 'totalPengajuan', 'jafaProgress', 'serdosProgress'
        ));
    }
}