@extends('layouts.app')

@section('title', 'Detail Kos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $kos->nama_kos }}</h1>
            <p class="text-secondary mb-0">Detail kos dan data penghuni pada wilayah Anda.</p>
        </div>
        <a href="{{ route('admin.kos.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6"><div class="text-secondary small">Pemilik</div><div class="fw-semibold">{{ $kos->user->name }}</div></div>
                <div class="col-md-6"><div class="text-secondary small">Status</div><div class="fw-semibold">{{ ucfirst($kos->status) }}</div></div>
                <div class="col-md-6"><div class="text-secondary small">Wilayah</div><div>{{ $kos->wilayah->rt }}/{{ $kos->wilayah->rw }} — {{ $kos->wilayah->kelurahan }}</div></div>
                <div class="col-md-6"><div class="text-secondary small">Alamat</div><div>{{ $kos->alamat }}</div></div>
            </div>
        </div>
    </div>

    @if($kos->status === 'pending')
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex flex-wrap gap-2 align-items-center">
                <strong>Verifikasi Kos</strong>
                <form method="POST" action="{{ route('admin.kos.verify', $kos) }}" class="ms-md-auto">
                    @csrf @method('PATCH')
                    <button class="btn btn-success">Setujui Kos</button>
                </form>
                <form method="POST" action="{{ route('admin.kos.reject', $kos) }}">
                    @csrf @method('PATCH')
                    <button class="btn btn-outline-danger">Tolak Kos</button>
                </form>
            </div>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white"><strong>Penghuni Aktif ({{ $penghuniAktif->count() }})</strong></div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>Nama</th><th>Pekerjaan</th><th>Tanggal Masuk</th></tr></thead>
                <tbody>
                    @forelse($penghuniAktif as $item)
                        <tr><td>{{ $item->nama_lengkap }}</td><td>{{ $item->pekerjaan }}</td><td>{{ $item->tanggal_masuk->format('d-m-Y') }}</td></tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-4 text-secondary">Belum ada penghuni aktif.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white"><strong>Riwayat Penghuni ({{ $riwayatPenghuni->count() }})</strong></div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>Nama</th><th>Masuk</th><th>Keluar</th><th>Keterangan</th></tr></thead>
                <tbody>
                    @forelse($riwayatPenghuni as $item)
                        <tr><td>{{ $item->nama_lengkap }}</td><td>{{ $item->tanggal_masuk->format('d-m-Y') }}</td><td>{{ $item->tanggal_keluar?->format('d-m-Y') ?? '-' }}</td><td>{{ $item->keterangan ?: '-' }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4 text-secondary">Belum ada riwayat penghuni.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
