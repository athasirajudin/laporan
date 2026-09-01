<?php

namespace App\Http\Controllers\PemilikKos;

use App\Http\Controllers\Controller;
use App\Http\Requests\PemilikKos\MarkPenghuniKeluarRequest;
use App\Http\Requests\PemilikKos\StorePenghuniRequest;
use App\Http\Requests\PemilikKos\UpdatePenghuniRequest;
use App\Models\Kos;
use App\Models\Penghuni;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PenghuniController extends Controller
{
    public function index(): View
    {
        $penghuni = Penghuni::query()
            ->whereHas('kos', fn ($query) => $query->where('user_id', auth()->id()))
            ->where('status', 'active')
            ->with('kos')
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nomor_identitas', 'like', "%{$search}%");
                });
            })
            ->when(request('kos_id'), fn ($query, $kosId) => $query->where('kos_id', $kosId))
            ->latest('tanggal_masuk')
            ->paginate(10)
            ->withQueryString();

        $kosList = Kos::query()->where('user_id', auth()->id())->orderBy('nama_kos')->get();

        return view('pemilik-kos.penghuni.index', compact('penghuni', 'kosList'));
    }

    public function history(): View
    {
        $penghuni = Penghuni::query()
            ->whereHas('kos', fn ($query) => $query->where('user_id', auth()->id()))
            ->where('status', 'inactive')
            ->with('kos')
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nomor_identitas', 'like', "%{$search}%");
                });
            })
            ->when(request('kos_id'), fn ($query, $kosId) => $query->where('kos_id', $kosId))
            ->latest('tanggal_keluar')
            ->paginate(10)
            ->withQueryString();

        $kosList = Kos::query()->where('user_id', auth()->id())->orderBy('nama_kos')->get();

        return view('pemilik-kos.penghuni.history', compact('penghuni', 'kosList'));
    }

    public function create(): View
    {
        $this->authorize('create', Penghuni::class);

        $kosList = Kos::query()
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->orderBy('nama_kos')
            ->get();

        return view('pemilik-kos.penghuni.create', compact('kosList'));
    }

    public function store(StorePenghuniRequest $request): RedirectResponse
    {
        $this->authorize('create', Penghuni::class);

        $validated = $request->validated();
        $kos = Kos::query()
            ->whereKey($validated['kos_id'])
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->firstOrFail();

        $kos->penghuni()->create([
            'jenis_identitas' => $validated['jenis_identitas'],
            'nomor_identitas' => $validated['nomor_identitas'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'pekerjaan' => $validated['pekerjaan'],
            'tanggal_masuk' => $validated['tanggal_masuk'],
            'status' => 'active',
            'tanggal_keluar' => null,
            'keterangan' => null,
        ]);

        return redirect()->route('pemilik-kos.penghuni.index')->with('success', 'Penghuni berhasil ditambahkan sebagai penghuni aktif.');
    }

    public function show(Penghuni $penghuni): View
    {
        $this->authorize('view', $penghuni);
        $penghuni->load('kos.wilayah');

        return view('pemilik-kos.penghuni.show', compact('penghuni'));
    }

    public function edit(Penghuni $penghuni): View
    {
        $this->authorize('update', $penghuni);

        return view('pemilik-kos.penghuni.edit', compact('penghuni'));
    }

    public function update(UpdatePenghuniRequest $request, Penghuni $penghuni): RedirectResponse
    {
        $this->authorize('update', $penghuni);
        $penghuni->update($request->validated());

        return redirect()->route('pemilik-kos.penghuni.show', $penghuni)->with('success', 'Data penghuni berhasil diperbarui.');
    }

    public function markAsExited(Penghuni $penghuni, MarkPenghuniKeluarRequest $request): RedirectResponse
    {
        $this->authorize('markAsExited', $penghuni);

        $penghuni->update([
            'status' => 'inactive',
            'tanggal_keluar' => $request->validated('tanggal_keluar'),
            'keterangan' => $request->validated('keterangan'),
        ]);

        return redirect()->route('pemilik-kos.penghuni.history')->with('success', 'Penghuni berhasil ditandai sudah keluar.');
    }
}
