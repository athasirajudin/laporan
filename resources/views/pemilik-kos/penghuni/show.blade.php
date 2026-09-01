@extends('layouts.app')

@section('title', 'Detail Penghuni')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4 gap-3 flex-wrap">
        <div>
            <p class="text-uppercase small fw-semibold text-secondary mb-1">Penghuni</p>
            <h1 class="h3 mb-1">{{ $penghuni->nama_lengkap }}</h1>
            <span class="badge text-bg-{{ $penghuni->status === 'active' ? 'success' : 'secondary' }}">{{ $penghuni->status === 'active' ? 'Aktif' : 'Sudah Keluar' }}</span>
        </div>
        @if ($penghuni->status === 'active')
            <div class="d-flex gap-2">
                <a href="{{ route('pemilik-kos.penghuni.edit', $penghuni) }}" class="btn btn-outline-primary">Edit</a>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#keluarModal">Tandai Sudah Keluar</button>
            </div>
        @endif
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-md-3">Kos</dt><dd class="col-md-9">{{ $penghuni->kos?->nama_kos }}</dd>
                <dt class="col-md-3">Jenis Identitas</dt><dd class="col-md-9">{{ $penghuni->jenis_identitas }}</dd>
                <dt class="col-md-3">Nomor Identitas</dt><dd class="col-md-9">{{ $penghuni->nomor_identitas }}</dd>
                <dt class="col-md-3">Nama Lengkap</dt><dd class="col-md-9">{{ $penghuni->nama_lengkap }}</dd>
                <dt class="col-md-3">Pekerjaan</dt><dd class="col-md-9">{{ $penghuni->pekerjaan }}</dd>
                <dt class="col-md-3">Tanggal Masuk</dt><dd class="col-md-9">{{ $penghuni->tanggal_masuk?->format('d M Y') }}</dd>
                <dt class="col-md-3">Tanggal Keluar</dt><dd class="col-md-9">{{ $penghuni->tanggal_keluar?->format('d M Y') ?: '-' }}</dd>
                <dt class="col-md-3">Keterangan</dt><dd class="col-md-9">{{ $penghuni->keterangan ?: '-' }}</dd>
            </dl>
        </div>
    </div>

    @if ($penghuni->status === 'active')
        <div class="modal fade" id="keluarModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('pemilik-kos.penghuni.keluar', $penghuni) }}">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header"><h2 class="modal-title fs-5">Tandai Sudah Keluar</h2><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
                        <div class="modal-body">
                            <p class="text-secondary">{{ $penghuni->nama_lengkap }} akan dipindahkan ke riwayat penghuni.</p>
                            <div class="mb-3"><label for="tanggal_keluar" class="form-label">Tanggal Keluar</label><input type="date" id="tanggal_keluar" name="tanggal_keluar" value="{{ now()->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}" min="{{ $penghuni->tanggal_masuk?->format('Y-m-d') }}" class="form-control" required></div>
                            <div><label for="keterangan" class="form-label">Keterangan <span class="text-secondary">(opsional)</span></label><textarea id="keterangan" name="keterangan" rows="3" maxlength="1000" class="form-control" placeholder="Contoh: pindah tempat tinggal"></textarea></div>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button class="btn btn-danger">Konfirmasi Keluar</button></div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
