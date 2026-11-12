<div class="mb-3">
    <label class="form-label" for="nama">Nama</label>
    <input class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $pelanggan->nama ?? '') }}" maxlength="100" required>
    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label" for="email">Email</label>
    <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email', $pelanggan->email ?? '') }}" maxlength="255" required>
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label" for="no_telepon">Nomor Telepon</label>
    <input class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $pelanggan->no_telepon ?? '') }}" maxlength="20" required>
    @error('no_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
