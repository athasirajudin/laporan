<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View|RedirectResponse
    {
        return match (auth()->user()->role) {
            'super_admin' => view('dashboard.super-admin'),
            'admin' => view('dashboard.admin'),
            'pemilik_kos' => view('dashboard.pemilik-kos'),
            default => auth()->logout() ?: redirect()->route('login'),
        };
    }
}
