@extends('layouts.app')

@section('title', 'Laporan Sistem')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <p class="text-uppercase small fw-semibold text-secondary mb-1">Super Admin</p>
            <h1 class="h3 mb-1">Laporan Sistem</h1>
            <p class="text-secondary mb-0">Ringkasan data kos dan penghuni dari seluruh wilayah.</p>
        </div>
        <button type="button" class="btn btn-outline-secondary print-hide" onclick="window.print()">Cetak</button>
    </div>

    <form method="GET" class="card border-0 shadow-sm mb-4 print-hide">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="wilayah_id" class="form-label">Wilayah</label>
                    <select id="wilayah_id" name="wilayah_id" class="form-select">
                        <option value="">Semua Wilayah</option>
                        @foreach ($wilayah as $item)
                            <option value="{{ $item->id }}" @selected((string) request('wilayah_id') === (string) $item->id)>
                                RT {{ $item->rt }}/RW {{ $item->rw }} — {{ $item->kelurahan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="kos_id" class="form-label">Kos</label>
                    <select id="kos_id" name="kos_id" class="form-select">
                        <option value="">Semua Kos</option>
                        @foreach ($kosList as $item)
                            <option value="{{ $item->id }}" @selected((string) request('kos_id') === (string) $item->id)>{{ $item->nama_kos }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status_kos" class="form-label">Status Kos</label>
                    <select id="status_kos" name="status_kos" class="form-select">
                        <option value="">Semua</option>
                        <option value="pending" @selected(request('status_kos') === 'pending')>Pending</option>
                        <option value="active" @selected(request('status_kos') === 'active')>Aktif</option>
                        <option value="inactive" @selected(request('status_kos') === 'inactive')>Tidak Aktif</option>
                        <option value="rejected" @selected(request('status_kos') === 'rejected')>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status_penghuni" class="form-label">Status Penghuni</label>
                    <select id="status_penghuni" name="status_penghuni" class="form-select">
                        <option value="">Semua</option>
                        <option value="active" @selected(request('status_penghuni') === 'active')>Aktif</option>
                        <option value="inactive" @selected(request('status_penghuni') === 'inactive')>Sudah Keluar</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label for="tanggal_mulai" class="form-label">Mulai</label>
                    <input id="tanggal_mulai" name="tanggal_mulai" type="date" class="form-control" value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="col-md-1">
                    <label for="tanggal_selesai" class="form-label">Selesai</label>
                    <input id="tanggal_selesai" name="tanggal_selesai" type="date" class="form-control" value="{{ request('tanggal_selesai') }}">
                </div>
            </div>
            <div class="d-flex gap-2 mt-3">
                <button class="btn btn-primary">Terapkan Filter</button>
                <a href="{{ route('super-admin.laporan.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </form>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-secondary small">Kos</div><div class="fs-3 fw-semibold">{{ $kos->count() }}</div></div></div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-secondary small">Penghuni</div><div class="fs-3 fw-semibold">{{ $penghuni->count() }}</div></div></div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-secondary small">Penghuni Aktif</div><div class="fs-3 fw-semibold">{{ $penghuni->where('status', 'active')->count() }}</div></div></div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-secondary small">Sudah Keluar</div><div class="fs-3 fw-semibold">{{ $penghuni->where('status', 'inactive')->count() }}</div></div></div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body border-bottom">
            <h2 class="h5 mb-1">Daftar Kos</h2>
            <p class="mb-0 text-secondary">{{ $kos->count() }} kos sesuai filter.</p>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr><th>Nama Kos</th><th>Pemilik</th><th>Wilayah</th><th>Penghuni</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse ($kos as $item)
                        <tr>
                            <td>{{ $item->nama_kos }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>RT {{ $item->wilayah->rt }}/RW {{ $item->wilayah->rw }}</td>
                            <td>{{ $item->penghuni_count }}</td>
                            <td>{{ match ($item->status) { 'pending' => 'Menunggu Verifikasi', 'active' => 'Aktif', 'inactive' => 'Tidak Aktif', 'rejected' => 'Ditolak', default => ucfirst($item->status) } }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4 text-secondary">Tidak ada data kos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body border-bottom">
            <h2 class="h5 mb-1">Data Penghuni</h2>
            <p class="mb-0 text-secondary">Data berdasarkan tanggal masuk pada filter yang dipilih.</p>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr><th>Nama</th><th>Kos</th><th>Wilayah</th><th>Pekerjaan</th><th>Masuk</th><th>Keluar</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse ($penghuni as $item)
                        <tr>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ $item->kos->nama_kos }}</td>
                            <td>RT {{ $item->kos->wilayah->rt }}/RW {{ $item->kos->wilayah->rw }}</td>
                            <td>{{ $item->pekerjaan }}</td>
                            <td>{{ $item->tanggal_masuk?->format('d-m-Y') }}</td>
                            <td>{{ $item->tanggal_keluar?->format('d-m-Y') ?? '-' }}</td>
                            <td>{{ $item->status === 'active' ? 'Aktif' : 'Sudah Keluar' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-4 text-secondary">Tidak ada data penghuni.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
