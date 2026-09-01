@extends('layouts.app')

@section('title', 'Tambah Penghuni')

@section('content')
    <div class="mb-4">
        <h1 class="h3">Tambah Penghuni</h1>
        <p class="text-secondary mb-0">Setelah disimpan, penghuni otomatis berstatus aktif.</p>
    </div>

    @if ($kosList->isEmpty())
        <div class="alert alert-warning">Belum ada kos aktif yang dapat menerima penghuni baru. Pastikan kos sudah diverifikasi Admin.</div>
        <a href="{{ route('pemilik-kos.kos.index') }}" class="btn btn-outline-secondary">Kembali ke Kos Saya</a>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('pemilik-kos.penghuni.store') }}">
                    @include('pemilik-kos.penghuni._form')
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('pemilik-kos.penghuni.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button class="btn btn-primary">Simpan Penghuni</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
