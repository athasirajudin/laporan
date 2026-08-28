@csrf
<div class="row g-3">
@foreach(['rt'=>'RT','rw'=>'RW','kelurahan'=>'Kelurahan/Desa','kecamatan'=>'Kecamatan','kabupaten_kota'=>'Kabupaten/Kota','provinsi'=>'Provinsi','kode_pos'=>'Kode Pos'] as $field => $label)
<div class="col-md-{{ in_array($field, ['kelurahan','kecamatan','kabupaten_kota','provinsi']) ? '6' : '3' }}"><label class="form-label">{{ $label }}</label><input name="{{ $field }}" value="{{ old($field, $wilayah->$field ?? '') }}" class="form-control @error($field) is-invalid @enderror" {{ $field !== 'kode_pos' ? 'required' : '' }}>@error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
@endforeach
</div>
