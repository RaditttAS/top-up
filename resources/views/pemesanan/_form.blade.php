<div class="mb-3">
    <label class="form-label" for="kode_pesanan">Kode Pemesanan</label>
    <input class="form-control @error('kode_pesanan') is-invalid @enderror" id="kode_pesanan" name="kode_pesanan" value="{{ old('kode_pesanan', $pemesanan->kode_pesanan ?? '') }}" maxlength="30" required>
    @error('kode_pesanan')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label" for="pelanggan_id">Pelanggan</label>
    <select class="form-select @error('pelanggan_id') is-invalid @enderror" id="pelanggan_id" name="pelanggan_id" required>
        <option value="">Pilih pelanggan</option>
        @foreach ($pelanggan as $item)
            <option value="{{ $item->id }}" @selected(old('pelanggan_id', $pemesanan->pelanggan_id ?? '') == $item->id)>{{ $item->nama }} ({{ $item->email }})</option>
        @endforeach
    </select>
    @error('pelanggan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    @if ($pelanggan->isEmpty())<div class="form-text">Tambahkan pelanggan sebelum membuat pemesanan.</div>@endif
</div>
<div class="mb-3">
    <label class="form-label" for="produk_topup_id">Produk Top Up</label>
    <select class="form-select @error('produk_topup_id') is-invalid @enderror" id="produk_topup_id" name="produk_topup_id" required>
        <option value="">Pilih produk</option>
        @foreach ($produk as $item)
            <option value="{{ $item->id }}" @selected(old('produk_topup_id', $pemesanan->produk_topup_id ?? '') == $item->id)>
                {{ $item->kode_produk }} - {{ number_format($item->jumlah_diamond, 0, ',', '.') }} diamond (Rp{{ number_format($item->harga, 0, ',', '.') }})
            </option>
        @endforeach
    </select>
    @error('produk_topup_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    @if ($produk->isEmpty())<div class="form-text">Tambahkan produk sebelum membuat pemesanan.</div>@endif
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="user_id_game">ID</label>
        <input class="form-control @error('user_id_game') is-invalid @enderror" id="user_id_game" name="user_id_game" value="{{ old('user_id_game', $pemesanan->user_id_game ?? '') }}" maxlength="30" required>
        @error('user_id_game')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="zone_id_game">Server</label>
        <input class="form-control @error('zone_id_game') is-invalid @enderror" id="zone_id_game" name="zone_id_game" value="{{ old('zone_id_game', $pemesanan->zone_id_game ?? '') }}" maxlength="20" required>
        @error('zone_id_game')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<div class="mb-3">
    <label class="form-label" for="jumlah">Jumlah Paket</label>
    <input class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" type="number" min="1" max="100000" value="{{ old('jumlah', $pemesanan->jumlah ?? 1) }}" required>
    @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label" for="status">Status</label>
    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
        @foreach ($statuses as $status)
            <option value="{{ $status }}" @selected(old('status', $pemesanan->status ?? 'menunggu_pembayaran') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
        @endforeach
    </select>
    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
