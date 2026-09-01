<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\Penghuni;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();

        return match ($user->role) {
            'super_admin' => view('dashboard.super-admin', [
                'totalAdmin' => User::query()->where('role', 'admin')->count(),
                'totalPemilikKos' => User::query()->where('role', 'pemilik_kos')->count(),
                'totalWilayah' => Wilayah::query()->count(),
                'totalKos' => Kos::query()->count(),
                'kosPending' => Kos::query()->where('status', 'pending')->count(),
                'kosAktif' => Kos::query()->where('status', 'active')->count(),
                'totalPenghuni' => Penghuni::query()->count(),
                'penghuniAktif' => Penghuni::query()->where('status', 'active')->count(),
            ]),
            'admin' => view('admin.dashboard', [
                'totalKos' => Kos::query()->where('wilayah_id', $user->wilayah_id)->count(),
                'kosPending' => Kos::query()->where('wilayah_id', $user->wilayah_id)->where('status', 'pending')->count(),
                'kosAktif' => Kos::query()->where('wilayah_id', $user->wilayah_id)->where('status', 'active')->count(),
                'totalPenghuni' => Penghuni::query()->whereHas('kos', fn ($query) => $query->where('wilayah_id', $user->wilayah_id))->count(),
                'penghuniAktif' => Penghuni::query()->where('status', 'active')->whereHas('kos', fn ($query) => $query->where('wilayah_id', $user->wilayah_id))->count(),
                'penghuniKeluar' => Penghuni::query()->where('status', 'inactive')->whereHas('kos', fn ($query) => $query->where('wilayah_id', $user->wilayah_id))->count(),
            ]),
            'pemilik_kos' => view('pemilik-kos.dashboard', [
                'totalKos' => Kos::query()->where('user_id', $user->id)->count(),
                'kosAktif' => Kos::query()->where('user_id', $user->id)->where('status', 'active')->count(),
                'penghuniAktif' => Penghuni::query()->where('status', 'active')->whereHas('kos', fn ($query) => $query->where('user_id', $user->id))->count(),
                'riwayatPenghuni' => Penghuni::query()->where('status', 'inactive')->whereHas('kos', fn ($query) => $query->where('user_id', $user->id))->count(),
            ]),
            default => abort(403),
        };
    }
}
