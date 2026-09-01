@extends('layouts.app')

@section('title', 'Penghuni Aktif')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
        <div>
            <p class="text-uppercase small fw-semibold text-secondary mb-1">Pemilik Kos</p>
            <h1 class="h3 mb-1">Penghuni Aktif</h1>
            <p class="text-secondary mb-0">Daftar penghuni yang masih tinggal di kos Anda.</p>
        </div>
        <a href="{{ route('pemilik-kos.penghuni.create') }}" class="btn btn-primary">+ Tambah Penghuni</a>
    </div>

    <form method="GET" class="card border-0 shadow-sm mb-4">
        <div class="card-body row g-3 align-items-end">
            <div class="col-md-6"><label class="form-label" for="search">Cari nama / nomor identitas</label><input id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari..."></div>
            <div class="col-md-4"><label class="form-label" for="kos_id">Kos</label><select id="kos_id" name="kos_id" class="form-select"><option value="">Semua kos</option>@foreach ($kosList as $item)<option value="{{ $item->id }}" @selected((string) request('kos_id') === (string) $item->id)>{{ $item->nama_kos }}</option>@endforeach</select></div>
            <div class="col-md-2"><button class="btn btn-outline-secondary w-100">Filter</button></div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive"><table class="table align-middle mb-0"><thead class="table-light"><tr><th>Nama</th><th>Identitas</th><th>Pekerjaan</th><th>Kos</th><th>Tanggal Masuk</th><th>Aksi</th></tr></thead><tbody>
            @forelse ($penghuni as $item)
                <tr><td class="fw-semibold">{{ $item->nama_lengkap }}</td><td>{{ $item->jenis_identitas }} · <span class="text-secondary">{{ Str::mask($item->nomor_identitas, '*', max(0, strlen($item->nomor_identitas) - 4), 4) }}</span></td><td>{{ $item->pekerjaan }}</td><td>{{ $item->kos?->nama_kos }}</td><td>{{ $item->tanggal_masuk?->format('d M Y') }}</td><td><a href="{{ route('pemilik-kos.penghuni.show', $item) }}" class="btn btn-sm btn-outline-secondary">Detail</a> <a href="{{ route('pemilik-kos.penghuni.edit', $item) }}" class="btn btn-sm btn-outline-primary">Edit</a></td></tr>
            @empty
                <tr><td colspan="6" class="text-center py-5 text-secondary">Belum ada penghuni aktif.</td></tr>
            @endforelse
        </tbody></table></div>
        @if ($penghuni->hasPages())<div class="card-body border-top">{{ $penghuni->links() }}</div>@endif
    </div>
@endsection
