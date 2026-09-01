@extends('layouts.app')

@section('title', 'Edit Kos')

@section('content')
    <div class="mb-4">
        <h1 class="h3">Edit Kos</h1>
        <p class="text-secondary mb-0">Perbarui informasi dasar kos Anda.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('pemilik-kos.kos.update', $kos) }}">
                @method('PUT')
                @include('pemilik-kos.kos._form')
                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('pemilik-kos.kos.show', $kos) }}" class="btn btn-outline-secondary">Batal</a>
                    <button class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
