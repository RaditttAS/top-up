@extends('layouts.app')

@section('title', 'Tambah Pemesanan')

@section('content')
<div class="card"><div class="card-body">
    <h1 class="h3 mb-3">Tambah Pemesanan</h1>
    <form action="{{ route('pemesanan.store') }}" method="POST">
        @csrf
        @include('pemesanan._form')
        <button class="btn btn-primary" type="submit" @disabled($pelanggan->isEmpty() || $produk->isEmpty())>Simpan</button>
        <a class="btn btn-outline-secondary" href="{{ route('pemesanan.index') }}">Batal</a>
    </form>
</div></div>
@endsection
