<?php

namespace App\Http\Controllers\PemilikKos;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(): View
    {
        $kos = Kos::query()
            ->where('user_id', auth()->id())
            ->with([
                'wilayah',
                'penghuni' => fn ($query) => $query->latest('tanggal_masuk'),
            ])
            ->when(request('kos_id'), fn ($query, $kosId) => $query->whereKey($kosId))
            ->first();

        $kosList = Kos::query()->where('user_id', auth()->id())->orderBy('nama_kos')->get();

        return view('pemilik-kos.laporan.index', compact('kos', 'kosList'));
    }
}
