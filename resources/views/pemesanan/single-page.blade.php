@extends('layouts.app')

@section('title', 'Pesan Top Up')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h3 mb-1">Pesan Top Up</h1>
        <p class="text-muted mb-0">Isi data pelanggan dan produk dalam satu halaman.</p>
    </div>
    <a class="btn btn-outline-secondary" href="{{ route('pemesanan.index') }}">Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('pemesanan.single.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="border rounded p-3 h-100 bg-light-subtle">
                        <h2 class="h5 mb-3">Data Pelanggan</h2>

                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Pelanggan</label>
                            <input class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" maxlength="100" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" maxlength="255" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3 mb-0">
                            <label class="form-label" for="no_telepon">Nomor Telepon</label>
                            <input class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" maxlength="20" required>
                            @error('no_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="border rounded p-3 h-100 bg-light-subtle">
                        <h2 class="h5 mb-3">Produk Top Up</h2>

                        <div class="mb-3">
                            <label class="form-label" for="kode_pesanan">Kode Pemesanan</label>
                            <input class="form-control @error('kode_pesanan') is-invalid @enderror" id="kode_pesanan" name="kode_pesanan" value="{{ old('kode_pesanan') }}" maxlength="30" required>
                            @error('kode_pesanan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="produk_topup_id">Produk</label>
                            <select class="form-select @error('produk_topup_id') is-invalid @enderror" id="produk_topup_id" name="produk_topup_id" required>
                                <option value="">Pilih produk</option>
                                @foreach ($produk as $item)
                                    <option value="{{ $item->id }}" @selected(old('produk_topup_id') == $item->id)>
                                        {{ $item->kode_produk }} - {{ number_format($item->jumlah_diamond, 0, ',', '.') }} diamond (Rp{{ number_format($item->harga, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('produk_topup_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @if ($produk->isEmpty())<div class="form-text">Tambahkan produk terlebih dahulu sebelum membuat pesanan.</div>@endif
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="user_id_game">ID</label>
                                <input class="form-control @error('user_id_game') is-invalid @enderror" id="user_id_game" name="user_id_game" value="{{ old('user_id_game') }}" maxlength="30" required>
                                @error('user_id_game')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="zone_id_game">Server</label>
                                <input class="form-control @error('zone_id_game') is-invalid @enderror" id="zone_id_game" name="zone_id_game" value="{{ old('zone_id_game') }}" maxlength="20" required>
                                @error('zone_id_game')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="jumlah">Jumlah Paket</label>
                                <input class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" type="number" min="1" max="100000" value="{{ old('jumlah', 1) }}" required>
                                @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="status">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" @selected(old('status', 'menunggu_pembayaran') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                                    @endforeach
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <button class="btn btn-primary" type="submit" @disabled($produk->isEmpty())>Simpan Pesanan</button>
                <a class="btn btn-outline-secondary" href="{{ route('pemesanan.index') }}">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
