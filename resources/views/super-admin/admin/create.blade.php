@extends('layouts.app')
@section('title', 'Tambah Admin')
@section('content')
<div class="mb-4"><h1 class="h3 mb-1">Tambah Admin</h1><p class="text-secondary mb-0">Buat akun Admin dan tentukan wilayah tanggung jawabnya.</p></div>
<form method="POST" action="{{ route('super-admin.admin.store') }}" class="card border-0 shadow-sm"><div class="card-body">@include('super-admin.admin._form')</div><div class="card-footer bg-white d-flex gap-2"><a href="{{ route('super-admin.admin.index') }}" class="btn btn-outline-secondary">Batal</a><button class="btn btn-primary">Simpan</button></div></form>
@endsection
