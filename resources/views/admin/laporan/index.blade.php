@extends('layouts.app')

@section('title', 'Laporan Wilayah')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Laporan Wilayah</h1>
        <p class="text-secondary mb-0">Ringkasan data kos dan penghuni untuk {{ $wilayah->rt }}/{{ $wilayah->rw }}, {{ $wilayah->kelurahan }}.</p>
    </div>

    <form method="GET" class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label">Status Kos</label>
                    <select name="status_kos" class="form-select">
                        <option value="">Semua</option>
                        @foreach(['pending' => 'Menunggu Verifikasi', 'active' => 'Aktif', 'inactive' => 'Tidak Aktif', 'rejected' => 'Ditolak'] as $value => $label)
                            <option value="{{ $value }}" @selected(request('status_kos') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kos</label>
                    <select name="kos_id" class="form-select">
                        <option value="">Semua Kos</option>
                        @foreach($kos as $item)
                            <option value="{{ $item->id }}" @selected((string) request('kos_id') === (string) $item->id)>{{ $item->nama_kos }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status Penghuni</label>
                    <select name="status_penghuni" class="form-select">
                        <option value="">Semua</option>
                        <option value="active" @selected(request('status_penghuni') === 'active')>Aktif</option>
                        <option value="inactive" @selected(request('status_penghuni') === 'inactive')>Sudah Keluar</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end"><button class="btn btn-primary w-100">Filter</button></div>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white"><strong>Daftar Kos</strong></div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>Nama Kos</th><th>Pemilik</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($kos as $item)
                        <tr><td>{{ $item->nama_kos }}</td><td>{{ $item->user->name }}</td><td>{{ ucfirst($item->status) }}</td></tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-4 text-secondary">Tidak ada kos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white"><strong>Data Penghuni</strong></div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>Nama</th><th>Kos</th><th>Pekerjaan</th><th>Masuk</th><th>Keluar</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($penghuni as $item)
                        <tr>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ $item->kos->nama_kos }}</td>
                            <td>{{ $item->pekerjaan }}</td>
                            <td>{{ $item->tanggal_masuk->format('d-m-Y') }}</td>
                            <td>{{ $item->tanggal_keluar?->format('d-m-Y') ?? '-' }}</td>
                            <td>{{ $item->status === 'active' ? 'Aktif' : 'Sudah Keluar' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-secondary">Tidak ada data penghuni.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
