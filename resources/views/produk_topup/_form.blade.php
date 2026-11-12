<div class="mb-3">
    <label class="form-label" for="kode_produk">Kode Produk</label>
    <input class="form-control @error('kode_produk') is-invalid @enderror" id="kode_produk" name="kode_produk" value="{{ old('kode_produk', $produk->kode_produk ?? '') }}" maxlength="20" required>
    @error('kode_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label" for="jumlah_diamond">Jumlah Diamond</label>
    <input class="form-control @error('jumlah_diamond') is-invalid @enderror" id="jumlah_diamond" name="jumlah_diamond" type="number" min="1" value="{{ old('jumlah_diamond', $produk->jumlah_diamond ?? '') }}" required>
    @error('jumlah_diamond')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label" for="harga">Harga (Rp)</label>
    <input class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" type="number" min="1" max="9000000000000" value="{{ old('harga', $produk->harga ?? '') }}" required>
    @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
