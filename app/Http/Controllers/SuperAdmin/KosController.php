<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KosController extends Controller
{
    public function index(): View
    {
        $kos = Kos::query()
            ->with(['user', 'wilayah'])
            ->withCount('penghuni')
            ->latest()
            ->paginate(20);

        return view('super-admin.kos.index', compact('kos'));
    }

    public function show(Kos $kos): View
    {
        $kos->load(['user', 'wilayah', 'penghuni' => fn ($query) => $query->latest('tanggal_masuk')]);

        return view('super-admin.kos.show', compact('kos'));
    }

    public function verify(Kos $kos): RedirectResponse
    {
        $this->authorize('verify', $kos);

        if ($kos->status !== 'pending') {
            return back()->with('error', 'Hanya kos berstatus pending yang dapat diverifikasi.');
        }

        $kos->update(['status' => 'active']);

        return back()->with('success', 'Kos berhasil disetujui.');
    }

    public function reject(Kos $kos): RedirectResponse
    {
        $this->authorize('verify', $kos);

        if ($kos->status !== 'pending') {
            return back()->with('error', 'Hanya kos berstatus pending yang dapat ditolak.');
        }

        $kos->update(['status' => 'rejected']);

        return back()->with('success', 'Pendaftaran kos berhasil ditolak.');
    }
}
