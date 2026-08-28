@extends('layouts.app')
@section('title', 'Detail Admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div><h1 class="h3 mb-1">Detail Admin</h1><p class="text-secondary mb-0">Informasi akun dan wilayah tanggung jawab.</p></div><a href="{{ route('super-admin.admin.edit', $admin) }}" class="btn btn-outline-primary">Edit</a></div>
<div class="row g-4">
<div class="col-md-6"><div class="card border-0 shadow-sm"><div class="card-body"><dl class="row mb-0"><dt class="col-sm-4">Nama</dt><dd class="col-sm-8">{{ $admin->name }}</dd><dt class="col-sm-4">Email</dt><dd class="col-sm-8">{{ $admin->email }}</dd><dt class="col-sm-4">Status</dt><dd class="col-sm-8">{{ $admin->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}</dd></dl></div></div></div>
<div class="col-md-6"><div class="card border-0 shadow-sm"><div class="card-body"><h2 class="h5">Wilayah</h2><p class="mb-1">RT {{ $admin->wilayah->rt }} / RW {{ $admin->wilayah->rw }}</p><p class="text-secondary mb-0">{{ $admin->wilayah->kelurahan }}, {{ $admin->wilayah->kecamatan }}, {{ $admin->wilayah->kabupaten_kota }}</p></div></div></div>
</div>
@endsection
