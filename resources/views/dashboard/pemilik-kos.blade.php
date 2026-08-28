@extends('layouts.app')

@section('title', 'Dashboard Pemilik Kos')

@section('content')
    <div class="mb-4">
        <p class="text-uppercase small fw-semibold text-secondary mb-1">Dashboard</p>
        <h1 class="h3 mb-1">Selamat datang, {{ auth()->user()->name }}</h1>
        <p class="text-secondary mb-0">Kelola data kos dan penghuni Anda dari halaman ini.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h2 class="h5">Pemilik Kos</h2>
            <p class="mb-0 text-secondary">Modul data kos dan penghuni akan tersedia pada phase berikutnya.</p>
        </div>
    </div>
@endsection
