@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="card"><div class="card-body">
    <h1 class="h3 mb-3">Edit Produk</h1>
    <form action="{{ route('produk-topup.update', $produk) }}" method="POST">
        @csrf @method('PUT')
        @include('produk_topup._form')
        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
        <a class="btn btn-outline-secondary" href="{{ route('produk-topup.index') }}">Batal</a>
    </form>
</div></div>
@endsection
