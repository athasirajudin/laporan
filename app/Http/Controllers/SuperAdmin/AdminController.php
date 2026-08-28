<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\StoreAdminRequest;
use App\Http\Requests\SuperAdmin\UpdateAdminRequest;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $admins = User::query()
            ->where('role', 'admin')
            ->with('wilayah')
            ->orderBy('name')
            ->paginate(20);

        return view('super-admin.admin.index', compact('admins'));
    }

    public function create(): View
    {
        $wilayah = Wilayah::query()->orderBy('rt')->orderBy('rw')->get();

        return view('super-admin.admin.create', compact('wilayah'));
    }

    public function store(StoreAdminRequest $request): RedirectResponse
    {
        User::query()->create([
            ...$request->validated(),
            'role' => 'admin',
        ]);

        return redirect()->route('super-admin.admin.index')
            ->with('success', 'Admin berhasil dibuat.');
    }

    public function show(User $admin): View
    {
        abort_unless($admin->role === 'admin', 404);

        $admin->load('wilayah.kos');

        return view('super-admin.admin.show', compact('admin'));
    }

    public function edit(User $admin): View
    {
        abort_unless($admin->role === 'admin', 404);

        $wilayah = Wilayah::query()->orderBy('rt')->orderBy('rw')->get();

        return view('super-admin.admin.edit', compact('admin', 'wilayah'));
    }

    public function update(UpdateAdminRequest $request, User $admin): RedirectResponse
    {
        abort_unless($admin->role === 'admin', 404);

        $data = $request->safe()->except('password');

        if ($request->filled('password')) {
            $data['password'] = $request->string('password')->toString();
        }

        $admin->update($data);

        return redirect()->route('super-admin.admin.index')
            ->with('success', 'Data Admin berhasil diperbarui.');
    }

    public function toggleStatus(User $admin): RedirectResponse
    {
        abort_unless($admin->role === 'admin', 404);

        $this->authorize('manageStatus', $admin);

        $admin->update([
            'status' => $admin->status === 'active' ? 'inactive' : 'active',
        ]);

        return back()->with('success', 'Status Admin berhasil diperbarui.');
    }
}
