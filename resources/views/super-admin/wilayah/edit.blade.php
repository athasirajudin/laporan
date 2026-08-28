@extends('layouts.app')
@section('title', 'Edit Wilayah')
@section('content')
<div class="mb-4"><h1 class="h3 mb-1">Edit Wilayah</h1><p class="text-secondary mb-0">Perbarui informasi wilayah.</p></div>
<form method="POST" action="{{ route('super-admin.wilayah.update', $wilayah) }}" class="card border-0 shadow-sm"><div class="card-body">@method('PUT') @include('super-admin.wilayah._form')</div><div class="card-footer bg-white d-flex gap-2"><a href="{{ route('super-admin.wilayah.index') }}" class="btn btn-outline-secondary">Batal</a><button class="btn btn-primary">Simpan Perubahan</button></div></form>
@endsection
