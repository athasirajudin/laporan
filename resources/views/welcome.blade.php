@extends('layouts.guest')

@section('title', 'Beranda')

@section('content')
    <section class="hero-panel rounded-4 p-4 p-md-5 text-white shadow-sm">
        <div class="col-lg-8">
            <p class="mb-2 fw-semibold text-uppercase small">Sistem Pendataan Kos</p>
            <h1 class="display-6 fw-bold">Pendataan kos dan penghuni yang terstruktur.</h1>
            <p class="lead mb-0">
                Fondasi aplikasi telah disiapkan. Fitur autentikasi dan pengelolaan data akan tersedia
                pada phase berikutnya.
            </p>
        </div>
    </section>

    <section class="row g-4 mt-1">
        <div class="col-md-4">
            <article class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h5">Wilayah</h2>
                    <p class="mb-0 text-secondary">Data wilayah akan menjadi dasar cakupan akses Admin.</p>
                </div>
            </article>
        </div>
        <div class="col-md-4">
            <article class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h5">Kos</h2>
                    <p class="mb-0 text-secondary">Kos dapat didaftarkan dan diverifikasi sesuai alur sistem.</p>
                </div>
            </article>
        </div>
        <div class="col-md-4">
            <article class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h5">Penghuni</h2>
                    <p class="mb-0 text-secondary">Riwayat penghuni akan dikelola tanpa menghapus data keluar.</p>
                </div>
            </article>
        </div>
    </section>
@endsection
