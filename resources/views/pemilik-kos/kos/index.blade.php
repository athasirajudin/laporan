@extends('layouts.app')

@section('title', 'Kos Saya')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
        <div>
            <p class="text-uppercase small fw-semibold text-secondary mb-1">Pemilik Kos</p>
            <h1 class="h3 mb-1">Kos Saya</h1>
            <p class="text-secondary mb-0">Daftar seluruh kos yang Anda kelola.</p>
        </div>
        <a href="{{ route('pemilik-kos.kos.create') }}" class="btn btn-primary">+ Tambah Kos</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Kos</th>
                        <th>Wilayah</th>
                        <th>Penghuni Aktif</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kos as $item)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $item->nama_kos }}</div>
                                <div class="small text-secondary">{{ $item->alamat }}</div>
                            </td>
                            <td>{{ $item->wilayah?->rt }}/{{ $item->wilayah?->rw }} · {{ $item->wilayah?->kelurahan }}</td>
                            <td>{{ $item->penghuni_aktif_count }}</td>
                            <td>
                                @php($statusLabel = ['pending' => 'Menunggu Verifikasi', 'active' => 'Aktif', 'inactive' => 'Tidak Aktif', 'rejected' => 'Ditolak'][$item->status] ?? $item->status)
                                <span class="badge text-bg-{{ $item->status === 'active' ? 'success' : ($item->status === 'pending' ? 'warning' : 'secondary') }}">{{ $statusLabel }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('pemilik-kos.kos.show', $item) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                                <a href="{{ route('pemilik-kos.kos.edit', $item) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-5 text-secondary">Belum ada kos. Tambahkan kos pertama Anda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($kos->hasPages())
            <div class="card-body border-top">{{ $kos->links() }}</div>
        @endif
    </div>
@endsection
