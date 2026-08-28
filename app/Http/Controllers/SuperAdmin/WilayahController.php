<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\StoreWilayahRequest;
use App\Http\Requests\SuperAdmin\UpdateWilayahRequest;
use App\Models\Wilayah;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WilayahController extends Controller
{
    public function index(): View
    {
        $wilayah = Wilayah::query()
            ->withCount(['kos', 'users'])
            ->orderBy('rt')
            ->orderBy('rw')
            ->paginate(20);

        return view('super-admin.wilayah.index', compact('wilayah'));
    }

    public function create(): View
    {
        return view('super-admin.wilayah.create');
    }

    public function store(StoreWilayahRequest $request): RedirectResponse
    {
        Wilayah::query()->create($request->validated());

        return redirect()->route('super-admin.wilayah.index')
            ->with('success', 'Wilayah berhasil dibuat.');
    }

    public function show(Wilayah $wilayah): View
    {
        $wilayah->loadCount(['kos', 'users']);

        return view('super-admin.wilayah.show', compact('wilayah'));
    }

    public function edit(Wilayah $wilayah): View
    {
        return view('super-admin.wilayah.edit', compact('wilayah'));
    }

    public function update(UpdateWilayahRequest $request, Wilayah $wilayah): RedirectResponse
    {
        $wilayah->update($request->validated());

        return redirect()->route('super-admin.wilayah.index')
            ->with('success', 'Wilayah berhasil diperbarui.');
    }
}
