@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('content')
<div class="mb-4">
    <p class="text-uppercase small fw-semibold text-secondary mb-1">Dashboard Super Admin</p>
    <h1 class="h3 mb-1">Selamat datang, {{ auth()->user()->name }}</h1>
    <p class="text-secondary mb-0">Ringkasan data seluruh sistem pendataan kos.</p>
</div>

<div class="row g-3 mb-4">
    @foreach([
        ['label' => 'Total Admin', 'value' => $totalAdmin],
        ['label' => 'Pemilik Kos', 'value' => $totalPemilikKos],
        ['label' => 'Wilayah', 'value' => $totalWilayah],
        ['label' => 'Total Kos', 'value' => $totalKos],
        ['label' => 'Kos Pending', 'value' => $kosPending],
        ['label' => 'Kos Aktif', 'value' => $kosAktif],
        ['label' => 'Total Penghuni', 'value' => $totalPenghuni],
        ['label' => 'Penghuni Aktif', 'value' => $penghuniAktif],
    ] as $stat)
    <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><p class="text-secondary small mb-1">{{ $stat['label'] }}</p><p class="display-6 mb-0 fw-semibold">{{ $stat['value'] }}</p></div></div></div>
    @endforeach
</div>

<div class="row g-4">
    <div class="col-md-4"><a href="{{ route('super-admin.admin.index') }}" class="card border-0 shadow-sm h-100 text-decoration-none text-body"><div class="card-body"><h2 class="h5">Manajemen Admin</h2><p class="text-secondary mb-0">Buat, ubah, dan nonaktifkan akun Admin.</p></div></a></div>
    <div class="col-md-4"><a href="{{ route('super-admin.wilayah.index') }}" class="card border-0 shadow-sm h-100 text-decoration-none text-body"><div class="card-body"><h2 class="h5">Data Wilayah</h2><p class="text-secondary mb-0">Kelola wilayah RT/RW yang digunakan sistem.</p></div></a></div>
    <div class="col-md-4"><a href="{{ route('super-admin.kos.index') }}" class="card border-0 shadow-sm h-100 text-decoration-none text-body"><div class="card-body"><h2 class="h5">Semua Kos</h2><p class="text-secondary mb-0">Pantau kos dan lakukan verifikasi pendaftaran.</p></div></a></div>
</div>
@endsection
