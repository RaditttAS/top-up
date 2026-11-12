@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Detail Produk</h1>
    <a class="btn btn-outline-secondary" href="{{ route('produk-topup.index') }}">Kembali</a>
</div>
<div class="card mb-4"><div class="card-body">
    <dl class="row mb-0">
        <dt class="col-sm-3">Kode Produk</dt><dd class="col-sm-9">{{ $produk->kode_produk }}</dd>
        <dt class="col-sm-3">Jumlah Diamond</dt><dd class="col-sm-9">{{ number_format($produk->jumlah_diamond, 0, ',', '.') }}</dd>
        <dt class="col-sm-3">Harga</dt><dd class="col-sm-9">Rp{{ number_format($produk->harga, 0, ',', '.') }}</dd>
    </dl>
</div></div>
<h2 class="h5">Pemesanan</h2>
<div class="card"><div class="table-responsive">
    <table class="table table-striped mb-0">
        <thead><tr><th>Kode</th><th>Pelanggan</th><th>Total</th><th>Status</th></tr></thead>
        <tbody>
        @forelse ($produk->pemesanan as $item)
            <tr>
                <td><a href="{{ route('pemesanan.show', $item) }}">{{ $item->kode_pesanan }}</a></td>
                <td>{{ $item->pelanggan->nama }}</td>
                <td>Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $item->status)) }}</td>
            </tr>
        @empty
            <tr><td class="text-center text-muted py-3" colspan="4">Belum ada pemesanan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
@endsection
