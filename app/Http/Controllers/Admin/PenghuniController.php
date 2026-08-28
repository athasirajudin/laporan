<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenghuniController extends Controller
{
    public function index(Request $request): View
    {
        $wilayahId = $request->user()->wilayah_id;

        $query = Penghuni::query()
            ->with(['kos.user', 'kos.wilayah'])
            ->whereHas('kos', fn ($kos) => $kos->where('wilayah_id', $wilayahId));

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nomor_identitas', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        $penghuni = $query->latest()->paginate(20)->withQueryString();

        return view('admin.penghuni.index', compact('penghuni'));
    }

    public function show(Penghuni $penghuni): View
    {
        $this->authorize('view', $penghuni);

        $penghuni->load(['kos.user', 'kos.wilayah']);

        return view('admin.penghuni.show', compact('penghuni'));
    }
}
