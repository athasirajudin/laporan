@extends('layouts.app')

@section('title', 'Detail Penghuni')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $penghuni->nama_lengkap }}</h1>
            <p class="text-secondary mb-0">Detail data penghuni pada wilayah Anda.</p>
        </div>
        <a href="{{ route('admin.penghuni.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6"><div class="text-secondary small">Jenis Identitas</div><div class="fw-semibold">{{ $penghuni->jenis_identitas }}</div></div>
                <div class="col-md-6"><div class="text-secondary small">Nomor Identitas</div><div class="fw-semibold">{{ $penghuni->nomor_identitas }}</div></div>
                <div class="col-md-6"><div class="text-secondary small">Nama Lengkap</div><div>{{ $penghuni->nama_lengkap }}</div></div>
                <div class="col-md-6"><div class="text-secondary small">Pekerjaan</div><div>{{ $penghuni->pekerjaan }}</div></div>
                <div class="col-md-6"><div class="text-secondary small">Kos</div><div>{{ $penghuni->kos->nama_kos }}</div></div>
                <div class="col-md-6"><div class="text-secondary small">Pemilik</div><div>{{ $penghuni->kos->user->name }}</div></div>
                <div class="col-md-6"><div class="text-secondary small">Tanggal Masuk</div><div>{{ $penghuni->tanggal_masuk->format('d-m-Y') }}</div></div>
                <div class="col-md-6"><div class="text-secondary small">Status</div><div><span class="badge text-bg-{{ $penghuni->status === 'active' ? 'success' : 'secondary' }}">{{ $penghuni->status === 'active' ? 'Aktif' : 'Sudah Keluar' }}</span></div></div>
                @if($penghuni->tanggal_keluar)
                    <div class="col-md-6"><div class="text-secondary small">Tanggal Keluar</div><div>{{ $penghuni->tanggal_keluar->format('d-m-Y') }}</div></div>
                    <div class="col-md-6"><div class="text-secondary small">Keterangan</div><div>{{ $penghuni->keterangan ?: '-' }}</div></div>
                @endif
            </div>
        </div>
    </div>
@endsection
