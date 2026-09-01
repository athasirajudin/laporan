@extends('layouts.app')

@section('title', 'Edit Penghuni')

@section('content')
    <div class="mb-4">
        <h1 class="h3">Edit Penghuni</h1>
        <p class="text-secondary mb-0">Perbarui data penghuni. Status dikelola melalui proses keluar.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('pemilik-kos.penghuni.update', $penghuni) }}">
                @include('pemilik-kos.penghuni._form')
                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('pemilik-kos.penghuni.show', $penghuni) }}" class="btn btn-outline-secondary">Batal</a>
                    <button class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
