<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use App\Models\Penghuni;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $kosQuery = Kos::query()->with('user', 'wilayah')->withCount('penghuni')->orderBy('nama_kos');
        $penghuniQuery = Penghuni::query()->with('kos.wilayah')->latest('tanggal_masuk');

        if ($request->filled('wilayah_id')) {
            $kosQuery->where('wilayah_id', $request->integer('wilayah_id'));
            $penghuniQuery->whereHas('kos', fn ($query) => $query->where('wilayah_id', $request->integer('wilayah_id')));
        }

        if ($request->filled('kos_id')) {
            $kosQuery->whereKey($request->integer('kos_id'));
            $penghuniQuery->where('kos_id', $request->integer('kos_id'));
        }

        if ($request->filled('status_kos')) {
            $kosQuery->where('status', $request->string('status_kos')->toString());
            $penghuniQuery->whereHas('kos', fn ($query) => $query->where('status', $request->string('status_kos')->toString()));
        }

        if ($request->filled('status_penghuni')) {
            $penghuniQuery->where('status', $request->string('status_penghuni')->toString());
        }

        if ($request->filled('tanggal_mulai')) {
            $penghuniQuery->whereDate('tanggal_masuk', '>=', $request->date('tanggal_mulai'));
        }

        if ($request->filled('tanggal_selesai')) {
            $penghuniQuery->whereDate('tanggal_masuk', '<=', $request->date('tanggal_selesai'));
        }

        $kos = $kosQuery->get();
        $penghuni = $penghuniQuery->get();
        $wilayah = Wilayah::query()->orderBy('provinsi')->orderBy('kabupaten_kota')->orderBy('kecamatan')->orderBy('kelurahan')->orderBy('rw')->orderBy('rt')->get();
        $kosList = Kos::query()->orderBy('nama_kos')->get();

        return view('super-admin.laporan.index', compact('kos', 'penghuni', 'wilayah', 'kosList'));
    }
}
