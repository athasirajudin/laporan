@extends('layouts.app')

@section('title', 'Data Penghuni')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Data Penghuni</h1>
        <p class="text-secondary mb-0">Data penghuni seluruh kos pada wilayah Anda.</p>
    </div>

    <form method="GET" class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-md-6">
                    <label class="form-label">Cari</label>
                    <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Nama atau nomor identitas">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua status</option>
                        <option value="active" @selected(request('status') === 'active')>Aktif</option>
                        <option value="inactive" @selected(request('status') === 'inactive')>Sudah Keluar</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end"><button class="btn btn-primary w-100">Filter</button></div>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>Nama</th><th>Kos</th><th>Pekerjaan</th><th>Tanggal Masuk</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse($penghuni as $item)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $item->nama_lengkap }}</div>
                                <div class="small text-secondary">{{ $item->jenis_identitas }}: {{ substr($item->nomor_identitas, 0, 4) }}{{ str_repeat('*', max(strlen($item->nomor_identitas) - 8, 0)) }}{{ substr($item->nomor_identitas, -4) }}</div>
                            </td>
                            <td>{{ $item->kos->nama_kos }}</td>
                            <td>{{ $item->pekerjaan }}</td>
                            <td>{{ $item->tanggal_masuk->format('d-m-Y') }}</td>
                            <td><span class="badge text-bg-{{ $item->status === 'active' ? 'success' : 'secondary' }}">{{ $item->status === 'active' ? 'Aktif' : 'Sudah Keluar' }}</span></td>
                            <td class="text-end"><a href="{{ route('admin.penghuni.show', $item) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-5 text-secondary">Belum ada data penghuni.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($penghuni->hasPages())<div class="card-footer bg-white">{{ $penghuni->links() }}</div>@endif
    </div>
@endsection
