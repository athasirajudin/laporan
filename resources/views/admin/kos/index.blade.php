@extends('layouts.app')

@section('title', 'Data Kos')

@section('content')
    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Data Kos</h1>
            <p class="text-secondary mb-0">Daftar kos pada wilayah yang menjadi tanggung jawab Anda.</p>
        </div>
    </div>

    <form method="GET" class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-md-7">
                    <label class="form-label">Cari</label>
                    <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Nama kos atau pemilik">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua status</option>
                        @foreach(['pending' => 'Menunggu Verifikasi', 'active' => 'Aktif', 'inactive' => 'Tidak Aktif', 'rejected' => 'Ditolak'] as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama Kos</th>
                        <th>Pemilik</th>
                        <th>Status</th>
                        <th>Penghuni Aktif</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kos as $item)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $item->nama_kos }}</div>
                                <div class="small text-secondary">{{ $item->alamat }}</div>
                            </td>
                            <td>{{ $item->user->name }}</td>
                            <td>
                                @php($statusLabel = ['pending' => 'Menunggu Verifikasi', 'active' => 'Aktif', 'inactive' => 'Tidak Aktif', 'rejected' => 'Ditolak'][$item->status] ?? $item->status)
                                <span class="badge text-bg-{{ $item->status === 'active' ? 'success' : ($item->status === 'pending' ? 'warning' : 'secondary') }}">{{ $statusLabel }}</span>
                            </td>
                            <td>{{ $item->penghuni()->where('status', 'active')->count() }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.kos.show', $item) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-5 text-secondary">Belum ada kos pada wilayah Anda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($kos->hasPages())
            <div class="card-footer bg-white">{{ $kos->links() }}</div>
        @endif
    </div>
@endsection
