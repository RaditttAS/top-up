@extends('layouts.app')

@section('title', 'Detail Pemesanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Detail Pemesanan</h1>
    <a class="btn btn-outline-secondary" href="{{ route('pemesanan.index') }}">Kembali</a>
</div>
<div class="card"><div class="card-body">
    <dl class="row mb-0">
        <dt class="col-sm-3">Kode Pemesanan</dt><dd class="col-sm-9">{{ $pemesanan->kode_pesanan }}</dd>
        <dt class="col-sm-3">Pelanggan</dt><dd class="col-sm-9">{{ $pemesanan->pelanggan->nama }} ({{ $pemesanan->pelanggan->email }})</dd>
        <dt class="col-sm-3">Produk</dt><dd class="col-sm-9">{{ $pemesanan->produkTopUp->kode_produk }} - {{ number_format($pemesanan->produkTopUp->jumlah_diamond, 0, ',', '.') }} diamond</dd>
        <dt class="col-sm-3">User ID Game</dt><dd class="col-sm-9">{{ $pemesanan->user_id_game }}</dd>
        <dt class="col-sm-3">Zone ID Game</dt><dd class="col-sm-9">{{ $pemesanan->zone_id_game }}</dd>
        <dt class="col-sm-3">Jumlah</dt><dd class="col-sm-9">{{ $pemesanan->jumlah }}</dd>
        <dt class="col-sm-3">Harga Satuan</dt><dd class="col-sm-9">Rp{{ number_format($pemesanan->harga_satuan, 0, ',', '.') }}</dd>
        <dt class="col-sm-3">Total Harga</dt><dd class="col-sm-9">Rp{{ number_format($pemesanan->total_harga, 0, ',', '.') }}</dd>
        <dt class="col-sm-3">Status</dt><dd class="col-sm-9">{{ ucfirst(str_replace('_', ' ', $pemesanan->status)) }}</dd>
    </dl>
</div></div>
@endsection
