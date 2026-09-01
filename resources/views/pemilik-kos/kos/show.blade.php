@extends('layouts.app')

@section('title', 'Detail Kos')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4 gap-3 flex-wrap">
        <div>
            <p class="text-uppercase small fw-semibold text-secondary mb-1">Kos Saya</p>
            <h1 class="h3 mb-1">{{ $kos->nama_kos }}</h1>
            @php($statusLabel = ['pending' => 'Menunggu Verifikasi', 'active' => 'Aktif', 'inactive' => 'Tidak Aktif', 'rejected' => 'Ditolak'][$kos->status] ?? $kos->status)
            <span class="badge text-bg-{{ $kos->status === 'active' ? 'success' : ($kos->status === 'pending' ? 'warning' : 'secondary') }}">{{ $statusLabel }}</span>
        </div>
        <a href="{{ route('pemilik-kos.kos.edit', $kos) }}" class="btn btn-outline-primary">Edit Kos</a>
    </div>

    @if ($kos->status === 'pending')
        <div class="alert alert-warning">Kos ini masih menunggu verifikasi Admin. Penghuni baru belum dapat ditambahkan sampai kos berstatus aktif.</div>
    @elseif ($kos->status === 'rejected')
        <div class="alert alert-secondary">Pendaftaran kos ini ditolak. Periksa kembali data kos sebelum menghubungi Admin.</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Informasi Kos</h2>
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Alamat</dt><dd class="col-sm-8">{{ $kos->alamat }}</dd>
                        <dt class="col-sm-4">Wilayah</dt><dd class="col-sm-8">RT {{ $kos->wilayah?->rt }} / RW {{ $kos->wilayah?->rw }} — {{ $kos->wilayah?->kelurahan }}, {{ $kos->wilayah?->kecamatan }}</dd>
                        <dt class="col-sm-4">Dibuat</dt><dd class="col-sm-8">{{ $kos->created_at?->format('d M Y') }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="small text-secondary mb-1">Penghuni</p>
                        <div class="h4 mb-0">{{ $kos->penghuni->where('status', 'active')->count() }} aktif</div>
                    </div>
                    @if ($kos->status === 'active')
                        <a href="{{ route('pemilik-kos.penghuni.create', ['kos_id' => $kos->id]) }}" class="btn btn-primary">+ Tambah Penghuni</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4">
                    <h2 class="h5">Daftar Penghuni</h2>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light"><tr><th>Nama</th><th>Pekerjaan</th><th>Masuk</th><th>Status</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($kos->penghuni as $penghuni)
                                <tr>
                                    <td>{{ $penghuni->nama_lengkap }}</td>
                                    <td>{{ $penghuni->pekerjaan }}</td>
                                    <td>{{ $penghuni->tanggal_masuk?->format('d M Y') }}</td>
                                    <td><span class="badge text-bg-{{ $penghuni->status === 'active' ? 'success' : 'secondary' }}">{{ $penghuni->status === 'active' ? 'Aktif' : 'Sudah Keluar' }}</span></td>
                                    <td><a href="{{ route('pemilik-kos.penghuni.show', $penghuni) }}" class="btn btn-sm btn-outline-secondary">Detail</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4 text-secondary">Belum ada penghuni.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
