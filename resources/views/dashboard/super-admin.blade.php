@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('content')
    <div class="mb-4">
        <p class="text-uppercase small fw-semibold text-secondary mb-1">Dashboard</p>
        <h1 class="h3 mb-1">Selamat datang, {{ auth()->user()->name }}</h1>
        <p class="text-secondary mb-0">Ringkasan sistem untuk Super Admin.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h2 class="h5">Super Admin</h2>
            <p class="mb-0 text-secondary">Modul manajemen wilayah, pengguna, kos, penghuni, dan laporan akan tersedia pada phase berikutnya.</p>
        </div>
    </div>
@endsection
