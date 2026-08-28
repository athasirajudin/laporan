<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KosController extends Controller
{
    public function index(Request $request): View
    {
        $query = Kos::query()
            ->with(['user', 'wilayah'])
            ->where('wilayah_id', $request->user()->wilayah_id);

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->where('nama_kos', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($user) => $user->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        $kos = $query->latest()->paginate(20)->withQueryString();

        return view('admin.kos.index', compact('kos'));
    }

    public function show(Kos $kos): View
    {
        $this->authorize('view', $kos);

        $kos->load(['user', 'wilayah']);
        $penghuniAktif = $kos->penghuni()->where('status', 'active')->latest()->get();
        $riwayatPenghuni = $kos->penghuni()->where('status', 'inactive')->latest('tanggal_keluar')->get();

        return view('admin.kos.show', compact('kos', 'penghuniAktif', 'riwayatPenghuni'));
    }

    public function verify(Kos $kos): RedirectResponse
    {
        $this->authorize('verify', $kos);

        abort_unless($kos->status === 'pending', 422, 'Kos hanya dapat diverifikasi saat berstatus pending.');
        $kos->update(['status' => 'active']);

        return back()->with('success', 'Kos berhasil diverifikasi.');
    }

    public function reject(Kos $kos): RedirectResponse
    {
        $this->authorize('verify', $kos);

        abort_unless($kos->status === 'pending', 422, 'Kos hanya dapat ditolak saat berstatus pending.');
        $kos->update(['status' => 'rejected']);

        return back()->with('success', 'Kos berhasil ditolak.');
    }
}
