@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="mb-4">
        <p class="text-uppercase small fw-semibold text-secondary mb-1">Dashboard</p>
        <h1 class="h3 mb-1">Selamat datang, {{ auth()->user()->name }}</h1>
        <p class="text-secondary mb-0">Ringkasan wilayah yang menjadi tanggung jawab Anda.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h2 class="h5">Admin Wilayah</h2>
            <p class="mb-0 text-secondary">Data kos dan penghuni pada wilayah Anda akan tersedia setelah modul monitoring dibangun.</p>
        </div>
    </div>
@endsection
