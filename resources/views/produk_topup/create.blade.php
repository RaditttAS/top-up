@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="card"><div class="card-body">
    <h1 class="h3 mb-3">Tambah Produk</h1>
    <form action="{{ route('produk-topup.store') }}" method="POST">
        @csrf
        @include('produk_topup._form')
        <button class="btn btn-primary" type="submit">Simpan</button>
        <a class="btn btn-outline-secondary" href="{{ route('produk-topup.index') }}">Batal</a>
    </form>
</div></div>
@endsection
