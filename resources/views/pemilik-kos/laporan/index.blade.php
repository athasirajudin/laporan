@extends('layouts.app')

@section('title', 'Laporan Kos')

@section('content')
    <div class="mb-4">
        <p class="text-uppercase small fw-semibold text-secondary mb-1">Pemilik Kos</p>
        <h1 class="h3 mb-1">Laporan</h1>
        <p class="text-secondary mb-0">Lihat data penghuni aktif dan riwayat untuk kos Anda.</p>
    </div>

    <form method="GET" class="card border-0 shadow-sm mb-4">
        <div class="card-body row g-3 align-items-end">
            <div class="col-md-10"><label for="kos_id" class="form-label">Pilih Kos</label><select id="kos_id" name="kos_id" class="form-select"><option value="">Pilih kos</option>@foreach ($kosList as $item)<option value="{{ $item->id }}" @selected((string) request('kos_id') === (string) $item->id)>{{ $item->nama_kos }}</option>@endforeach</select></div>
            <div class="col-md-2"><button class="btn btn-outline-primary w-100">Tampilkan</button></div>
        </div>
    </form>

    @if ($kos)
        <div class="card border-0 shadow-sm" id="laporan">
            <div class="card-body border-bottom">
                <h2 class="h4 mb-1">{{ $kos->nama_kos }}</h2>
                <p class="mb-0 text-secondary">{{ $kos->alamat }} · RT {{ $kos->wilayah?->rt }}/RW {{ $kos->wilayah?->rw }}</p>
            </div>
            <div class="card-body">
                <h3 class="h5">Penghuni Aktif</h3>
                <div class="table-responsive mb-4"><table class="table align-middle"><thead class="table-light"><tr><th>Nama</th><th>Identitas</th><th>Pekerjaan</th><th>Tanggal Masuk</th></tr></thead><tbody>
                    @forelse ($kos->penghuni->where('status', 'active') as $item)
                        <tr><td>{{ $item->nama_lengkap }}</td><td>{{ $item->jenis_identitas }}</td><td>{{ $item->pekerjaan }}</td><td>{{ $item->tanggal_masuk?->format('d M Y') }}</td></tr>
                    @empty<tr><td colspan="4" class="text-center text-secondary py-3">Tidak ada penghuni aktif.</td></tr>@endforelse
                </tbody></table></div>

                <h3 class="h5">Riwayat Penghuni</h3>
                <div class="table-responsive"><table class="table align-middle"><thead class="table-light"><tr><th>Nama</th><th>Tanggal Masuk</th><th>Tanggal Keluar</th><th>Keterangan</th></tr></thead><tbody>
                    @forelse ($kos->penghuni->where('status', 'inactive') as $item)
                        <tr><td>{{ $item->nama_lengkap }}</td><td>{{ $item->tanggal_masuk?->format('d M Y') }}</td><td>{{ $item->tanggal_keluar?->format('d M Y') }}</td><td>{{ $item->keterangan ?: '-' }}</td></tr>
                    @empty<tr><td colspan="4" class="text-center text-secondary py-3">Belum ada riwayat penghuni.</td></tr>@endforelse
                </tbody></table></div>
            </div>
        </div>
    @endif
@endsection
