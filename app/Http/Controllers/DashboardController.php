<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\Penghuni;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View|Response
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
            'admin' => view('dashboard.admin'),
            'pemilik_kos' => view('dashboard.pemilik-kos'),
            default => abort(403),
        };
    }
}
