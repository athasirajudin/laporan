@extends('layouts.app')

@section('title', 'Dashboard Pemilik Kos')

@section('content')
    <div class="mb-4">
        <p class="text-uppercase small fw-semibold text-secondary mb-1">Dashboard</p>
        <h1 class="h3 mb-1">Selamat datang, {{ auth()->user()->name }}</h1>
        <p class="text-secondary mb-0">Kelola data kos dan penghuni Anda dari sini.</p>
    </div>

    <div class="row g-3 mb-4">
        @foreach ([
            ['label' => 'Total Kos Saya', 'value' => $totalKos],
            ['label' => 'Kos Aktif', 'value' => $kosAktif],
            ['label' => 'Penghuni Aktif', 'value' => $penghuniAktif],
            ['label' => 'Riwayat Penghuni', 'value' => $riwayatPenghuni],
        ] as $stat)
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="small text-secondary mb-2">{{ $stat['label'] }}</p>
                        <div class="display-6 fw-semibold">{{ $stat['value'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body d-flex flex-wrap gap-2">
            <a href="{{ route('pemilik-kos.kos.create') }}" class="btn btn-primary">+ Tambah Kos</a>
            <a href="{{ route('pemilik-kos.penghuni.create') }}" class="btn btn-outline-primary">+ Tambah Penghuni</a>
            <a href="{{ route('pemilik-kos.penghuni.index') }}" class="btn btn-outline-secondary">Lihat Penghuni Aktif</a>
        </div>
    </div>
@endsection
