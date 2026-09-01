@csrf

<div class="row g-3">
    <div class="col-12">
        <label for="nama_kos" class="form-label">Nama Kos</label>
        <input type="text" id="nama_kos" name="nama_kos" value="{{ old('nama_kos', $kos->nama_kos ?? '') }}" class="form-control @error('nama_kos') is-invalid @enderror" required maxlength="150">
        @error('nama_kos')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label for="alamat" class="form-label">Alamat Lengkap</label>
        <textarea id="alamat" name="alamat" rows="4" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat', $kos->alamat ?? '') }}</textarea>
        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label for="wilayah_id" class="form-label">Wilayah RT/RW</label>
        <select id="wilayah_id" name="wilayah_id" class="form-select @error('wilayah_id') is-invalid @enderror" required>
            <option value="">Pilih wilayah</option>
            @foreach ($wilayah as $item)
                <option value="{{ $item->id }}" @selected((string) old('wilayah_id', $kos->wilayah_id ?? '') === (string) $item->id)>
                    RT {{ $item->rt }} / RW {{ $item->rw }} — {{ $item->kelurahan }}, {{ $item->kecamatan }}, {{ $item->kabupaten_kota }}
                </option>
            @endforeach
        </select>
        @error('wilayah_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
