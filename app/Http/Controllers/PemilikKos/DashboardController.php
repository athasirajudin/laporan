<?php

namespace App\Http\Controllers\PemilikKos;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use App\Models\Penghuni;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $userId = auth()->id();

        return view('pemilik-kos.dashboard', [
            'totalKos' => Kos::query()->where('user_id', $userId)->count(),
            'kosAktif' => Kos::query()->where('user_id', $userId)->where('status', 'active')->count(),
            'penghuniAktif' => Penghuni::query()
                ->where('status', 'active')
                ->whereHas('kos', fn ($query) => $query->where('user_id', $userId))
                ->count(),
            'riwayatPenghuni' => Penghuni::query()
                ->where('status', 'inactive')
                ->whereHas('kos', fn ($query) => $query->where('user_id', $userId))
                ->count(),
        ]);
    }
}
