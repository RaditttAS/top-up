@extends('layouts.app')

@section('title', 'Pemesanan Top Up')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-body p-4">
        <form action="{{ route('pemesanan.store') }}" method="POST">
            @csrf

            <div class="border rounded p-4 mb-4 bg-light-subtle">
                <h2 class="h5 mb-3">1. Identitas Game</h2>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="user_id_game">ID</label>
                        <input class="form-control @error('user_id_game') is-invalid @enderror" id="user_id_game" name="user_id_game" value="{{ old('user_id_game') }}" maxlength="30" required>
                        @error('user_id_game')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="zone_id_game">Server</label>
                        <input class="form-control @error('zone_id_game') is-invalid @enderror" id="zone_id_game" name="zone_id_game" value="{{ old('zone_id_game') }}" maxlength="20" required>
                        @error('zone_id_game')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="border rounded p-4 mb-4 bg-light-subtle">
                <h2 class="h5 mb-3">2. Pilih Produk Top Up</h2>
                @if ($produk->isEmpty())
                    <div class="form-text">Belum ada produk top up yang tersedia.</div>
                @else
                    <div class="row g-3">
                        @foreach ($produk as $item)
                            <div class="col-md-6 col-xl-4">
                                <label class="card h-100 border @error('produk_topup_id') border-danger @else border-secondary-subtle @enderror" style="cursor: pointer;">
                                    <div class="card-body p-3">
                                        <input class="form-check-input me-2" type="radio" name="produk_topup_id" value="{{ $item->id }}" @checked(old('produk_topup_id') == $item->id) required>
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge bg-primary-subtle text-primary-emphasis">{{ $item->kode_produk }}</span>
                                            <span class="small text-muted">{{ number_format($item->jumlah_diamond, 0, ',', '.') }} diamond</span>
                                        </div>
                                        <h3 class="h6 mb-2">{{ number_format($item->jumlah_diamond, 0, ',', '.') }} Diamond</h3>
                                        <p class="fw-semibold text-dark mb-0">Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endif
                @error('produk_topup_id')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
            </div>

            <div class="border rounded p-4 mb-4 bg-light-subtle">
                <h2 class="h5 mb-3">3. Masukkan Jumlah Pembelian</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2">
                            <input class="form-control flex-grow-1 @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" type="text" inputmode="numeric" pattern="[0-9]+" maxlength="6" value="{{ old('jumlah', 1) }}" required>
                            <button class="btn btn-outline-secondary flex-shrink-0" style="width: 40px; height: 38px;" type="button" id="jumlah-kurang" aria-label="Kurangi jumlah">-</button>
                            <button class="btn btn-outline-secondary flex-shrink-0" style="width: 40px; height: 38px;" type="button" id="jumlah-tambah" aria-label="Tambah jumlah">+</button>
                        </div>
                        @error('jumlah')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="border rounded p-4 bg-light-subtle">
                <h2 class="h5 mb-3">4. Identitas Pelanggan</h2>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label" for="nama">Nama Pelanggan</label>
                        <input class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" maxlength="100" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" maxlength="255" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="no_telepon">Nomor Telepon</label>
                        <input class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" maxlength="20" required>
                        @error('no_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary btn-lg w-100" type="submit" @disabled($produk->isEmpty())>Buat Pesanan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const quantityInput = document.getElementById('jumlah');

    function changeQuantity(amount) {
        const value = Number.parseInt(quantityInput.value, 10);
        const current = Number.isFinite(value) ? value : (amount > 0 ? 0 : 1);
        quantityInput.value = Math.min(100000, Math.max(1, current + amount));
    }

    document.getElementById('jumlah-kurang').addEventListener('click', () => changeQuantity(-1));
    document.getElementById('jumlah-tambah').addEventListener('click', () => changeQuantity(1));
</script>
@endsection