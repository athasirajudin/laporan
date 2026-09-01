@extends('layouts.app')

@section('title', 'Tambah Kos')

@section('content')
    <div class="mb-4">
        <h1 class="h3">Tambah Kos</h1>
        <p class="text-secondary mb-0">Daftarkan kos Anda untuk diverifikasi oleh Admin.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('pemilik-kos.kos.store') }}">
                @include('pemilik-kos.kos._form')
                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('pemilik-kos.kos.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button class="btn btn-primary">Simpan Kos</button>
                </div>
            </form>
        </div>
    </div>
@endsection
