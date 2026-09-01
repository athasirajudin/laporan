@extends('layouts.app')

@section('title', 'Riwayat Penghuni')

@section('content')
    <div class="mb-4">
        <p class="text-uppercase small fw-semibold text-secondary mb-1">Pemilik Kos</p>
        <h1 class="h3 mb-1">Riwayat Penghuni</h1>
        <p class="text-secondary mb-0">Penghuni yang sudah keluar tetap tersimpan sebagai histori.</p>
    </div>

    <form method="GET" class="card border-0 shadow-sm mb-4">
        <div class="card-body row g-3 align-items-end">
            <div class="col-md-6"><label class="form-label" for="search">Cari nama / nomor identitas</label><input id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari..."></div>
            <div class="col-md-4"><label class="form-label" for="kos_id">Kos</label><select id="kos_id" name="kos_id" class="form-select"><option value="">Semua kos</option>@foreach ($kosList as $item)<option value="{{ $item->id }}" @selected((string) request('kos_id') === (string) $item->id)>{{ $item->nama_kos }}</option>@endforeach</select></div>
            <div class="col-md-2"><button class="btn btn-outline-secondary w-100">Filter</button></div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive"><table class="table align-middle mb-0"><thead class="table-light"><tr><th>Nama</th><th>Kos</th><th>Pekerjaan</th><th>Masuk</th><th>Keluar</th><th>Keterangan</th><th>Aksi</th></tr></thead><tbody>
            @forelse ($penghuni as $item)
                <tr><td class="fw-semibold">{{ $item->nama_lengkap }}</td><td>{{ $item->kos?->nama_kos }}</td><td>{{ $item->pekerjaan }}</td><td>{{ $item->tanggal_masuk?->format('d M Y') }}</td><td>{{ $item->tanggal_keluar?->format('d M Y') }}</td><td>{{ $item->keterangan ?: '-' }}</td><td><a href="{{ route('pemilik-kos.penghuni.show', $item) }}" class="btn btn-sm btn-outline-secondary">Detail</a></td></tr>
            @empty
                <tr><td colspan="7" class="text-center py-5 text-secondary">Belum ada riwayat penghuni.</td></tr>
            @endforelse
        </tbody></table></div>
        @if ($penghuni->hasPages())<div class="card-body border-top">{{ $penghuni->links() }}</div>@endif
    </div>
@endsection
