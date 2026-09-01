<?php

namespace App\Http\Controllers\PemilikKos;

use App\Http\Controllers\Controller;
use App\Http\Requests\PemilikKos\StoreKosRequest;
use App\Http\Requests\PemilikKos\UpdateKosRequest;
use App\Models\Kos;
use App\Models\Wilayah;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KosController extends Controller
{
    public function index(): View
    {
        $kos = Kos::query()
            ->where('user_id', auth()->id())
            ->with('wilayah')
            ->withCount(['penghuni as penghuni_aktif_count' => fn ($query) => $query->where('status', 'active')])
            ->latest()
            ->paginate(10);

        return view('pemilik-kos.kos.index', compact('kos'));
    }

    public function create(): View
    {
        $this->authorize('create', Kos::class);
        $wilayah = Wilayah::query()->orderBy('provinsi')->orderBy('kabupaten_kota')->orderBy('kecamatan')->orderBy('kelurahan')->orderBy('rw')->orderBy('rt')->get();

        return view('pemilik-kos.kos.create', compact('wilayah'));
    }

    public function store(StoreKosRequest $request): RedirectResponse
    {
        $this->authorize('create', Kos::class);

        Kos::query()->create([
            ...$request->validated(),
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        return redirect()->route('pemilik-kos.kos.index')->with('success', 'Kos berhasil didaftarkan dan menunggu verifikasi Admin.');
    }

    public function show(Kos $kos): View
    {
        $this->authorize('view', $kos);

        $kos->load([
            'wilayah',
            'penghuni' => fn ($query) => $query->latest('tanggal_masuk'),
        ]);

        return view('pemilik-kos.kos.show', compact('kos'));
    }

    public function edit(Kos $kos): View
    {
        $this->authorize('update', $kos);

        $wilayah = Wilayah::query()->orderBy('provinsi')->orderBy('kabupaten_kota')->orderBy('kecamatan')->orderBy('kelurahan')->orderBy('rw')->orderBy('rt')->get();

        return view('pemilik-kos.kos.edit', compact('kos', 'wilayah'));
    }

    public function update(UpdateKosRequest $request, Kos $kos): RedirectResponse
    {
        $this->authorize('update', $kos);

        $kos->update($request->validated());

        return redirect()->route('pemilik-kos.kos.show', $kos)->with('success', 'Data kos berhasil diperbarui.');
    }
}
