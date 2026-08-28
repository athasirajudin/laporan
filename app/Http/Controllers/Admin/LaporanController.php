<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $wilayahId = $request->user()->wilayah_id;

        $kosQuery = Kos::query()->where('wilayah_id', $wilayahId);
        $penghuniQuery = Penghuni::query()->whereHas('kos', fn ($query) => $query->where('wilayah_id', $wilayahId));

        if ($request->filled('status_kos')) {
            $kosQuery->where('status', $request->string('status_kos')->toString());
        }

        if ($request->filled('status_penghuni')) {
            $penghuniQuery->where('status', $request->string('status_penghuni')->toString());
        }

        if ($request->filled('kos_id')) {
            $penghuniQuery->where('kos_id', $request->integer('kos_id'));
        }

        $kos = $kosQuery->with('user')->orderBy('nama_kos')->get();
        $penghuni = $penghuniQuery->with('kos')->latest()->get();

        return view('admin.laporan.index', [
            'wilayah' => $request->user()->wilayah,
            'kos' => $kos,
            'penghuni' => $penghuni,
        ]);
    }
}
