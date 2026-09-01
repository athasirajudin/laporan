@csrf

@if (isset($penghuni))
    @method('PUT')
@endif

<div class="row g-3">
    @if (!isset($penghuni))
        <div class="col-12">
            <label for="kos_id" class="form-label">Kos</label>
            <select id="kos_id" name="kos_id" class="form-select @error('kos_id') is-invalid @enderror" required>
                <option value="">Pilih kos</option>
                @foreach ($kosList as $kos)
                    <option value="{{ $kos->id }}" @selected((string) old('kos_id', request('kos_id')) === (string) $kos->id)>{{ $kos->nama_kos }}</option>
                @endforeach
            </select>
            @error('kos_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    @endif

    <div class="col-md-4">
        <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
        <select id="jenis_identitas" name="jenis_identitas" class="form-select @error('jenis_identitas') is-invalid @enderror" required>
            @foreach (['KTP', 'SIM'] as $jenis)
                <option value="{{ $jenis }}" @selected(old('jenis_identitas', $penghuni->jenis_identitas ?? '') === $jenis)>{{ $jenis }}</option>
            @endforeach
        </select>
        @error('jenis_identitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-8">
        <label for="nomor_identitas" class="form-label">Nomor Identitas</label>
        <input type="text" id="nomor_identitas" name="nomor_identitas" value="{{ old('nomor_identitas', $penghuni->nomor_identitas ?? '') }}" class="form-control @error('nomor_identitas') is-invalid @enderror" required maxlength="30">
        @error('nomor_identitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-8">
        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $penghuni->nama_lengkap ?? '') }}" class="form-control @error('nama_lengkap') is-invalid @enderror" required maxlength="150">
        @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label for="pekerjaan" class="form-label">Pekerjaan</label>
        <input type="text" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $penghuni->pekerjaan ?? '') }}" class="form-control @error('pekerjaan') is-invalid @enderror" required maxlength="100">
        @error('pekerjaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
        <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk', isset($penghuni) ? $penghuni->tanggal_masuk?->format('Y-m-d') : now()->format('Y-m-d')) }}" class="form-control @error('tanggal_masuk') is-invalid @enderror" max="{{ now()->format('Y-m-d') }}" required>
        @error('tanggal_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
