@extends('layouts.app')

@section('title', 'Manajemen Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h1 class="h3 mb-1">Manajemen Admin</h1><p class="text-secondary mb-0">Kelola akun Admin dan wilayah yang menjadi tanggung jawabnya.</p></div>
    <a href="{{ route('super-admin.admin.create') }}" class="btn btn-primary">+ Tambah Admin</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th class="ps-3">Nama</th><th>Email</th><th>Wilayah</th><th>Status</th><th class="text-end pe-3">Aksi</th></tr></thead>
                <tbody>
                @forelse($admins as $admin)
                    <tr>
                        <td class="ps-3 fw-semibold">{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>RT {{ $admin->wilayah->rt }} / RW {{ $admin->wilayah->rw }} — {{ $admin->wilayah->kelurahan }}</td>
                        <td><span class="badge {{ $admin->status === 'active' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $admin->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                        <td class="text-end pe-3"><a href="{{ route('super-admin.admin.show', $admin) }}" class="btn btn-sm btn-outline-primary">Detail</a> <a href="{{ route('super-admin.admin.edit', $admin) }}" class="btn btn-sm btn-outline-secondary">Edit</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-5 text-secondary">Belum ada Admin.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($admins->hasPages())<div class="card-footer bg-white">{{ $admins->links() }}</div>@endif
</div>
@endsection
