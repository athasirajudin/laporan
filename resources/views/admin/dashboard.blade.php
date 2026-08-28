@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="mb-4">
        <p class="text-uppercase small fw-semibold text-secondary mb-1">Dashboard Admin</p>
        <h1 class="h3 mb-1">Selamat datang, {{ auth()->user()->name }}</h1>
        <p class="text-secondary mb-0">Monitoring data kos dan penghuni di wilayah Anda.</p>
    </div>

    <div class="row g-3 mb-4">
        @foreach([
            ['label' => 'Total Kos', 'value' => $totalKos],
            ['label' => 'Kos Pending', 'value' => $kosPending],
            ['label' => 'Kos Aktif', 'value' => $kosAktif],
            ['label' => 'Total Penghuni', 'value' => $totalPenghuni],
            ['label' => 'Penghuni Aktif', 'value' => $penghuniAktif],
            ['label' => 'Sudah Keluar', 'value' => $penghuniKeluar],
        ] as $stat)
            <div class="col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-secondary small">{{ $stat['label'] }}</div>
                        <div class="fs-3 fw-semibold mt-1">{{ $stat['value'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.kos.index') }}" class="btn btn-primary">Lihat Data Kos</a>
        <a href="{{ route('admin.penghuni.index') }}" class="btn btn-outline-primary">Lihat Data Penghuni</a>
        <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary">Buka Laporan</a>
    </div>
@endsection
