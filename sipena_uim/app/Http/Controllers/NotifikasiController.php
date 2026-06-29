<?php

namespace App\Http\Controllers;

use App\Services\NotifikasiService;

class NotifikasiController extends Controller
{
    public function __construct(protected NotifikasiService $notifikasiService) {}

    public function tandaiDibaca(int $id)
    {
        $this->notifikasiService->tandaiDibaca($id);
        return back();
    }

    public function tandaiSemuaDibaca()
    {
        $this->notifikasiService->tandaiSemuaDibaca(auth()->id());
        return back()->with('success', 'Semua notifikasi ditandai dibaca.');
    }
}