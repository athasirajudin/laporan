<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use App\Models\Penghuni;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $wilayahId = auth()->user()->wilayah_id;

        return view('admin.dashboard', [
            'totalKos' => Kos::query()->where('wilayah_id', $wilayahId)->count(),
            'kosPending' => Kos::query()->where('wilayah_id', $wilayahId)->where('status', 'pending')->count(),
            'kosAktif' => Kos::query()->where('wilayah_id', $wilayahId)->where('status', 'active')->count(),
            'totalPenghuni' => Penghuni::query()->whereHas('kos', fn ($query) => $query->where('wilayah_id', $wilayahId))->count(),
            'penghuniAktif' => Penghuni::query()->where('status', 'active')->whereHas('kos', fn ($query) => $query->where('wilayah_id', $wilayahId))->count(),
            'penghuniKeluar' => Penghuni::query()->where('status', 'inactive')->whereHas('kos', fn ($query) => $query->where('wilayah_id', $wilayahId))->count(),
        ]);
    }
}
