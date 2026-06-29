<?php

namespace App\Http\Controllers;

use App\Services\ApprovalService;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function __construct(protected ApprovalService $approvalService) {}

    public function index()
    {
        $userId      = auth()->id();
        $queueCuti   = $this->approvalService->getQueueCuti($userId);
        $queueLembur = $this->approvalService->getQueueLembur($userId);
        $riwayat     = $this->approvalService->getRiwayatCuti($userId);
        return view('approval.index', compact('queueCuti', 'queueLembur', 'riwayat'));
    }

    public function prosesCuti(Request $request, int $id)
    {
        $request->validate([
            'status'  => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string|max:500',
        ]);

        $this->approvalService->prosesCuti($id, $request->status, $request->catatan);
        return back()->with('success', 'Pengajuan cuti berhasil diproses.');
    }

    public function prosesLembur(Request $request, int $id)
    {
        $request->validate([
            'status'  => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string|max:500',
        ]);

        $this->approvalService->prosesLembur($id, $request->status, $request->catatan);
        return back()->with('success', 'Pengajuan lembur berhasil diproses.');
    }
}