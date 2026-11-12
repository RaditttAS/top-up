@extends('layouts.app')

@section('title', 'Edit Pemesanan')

@section('content')
<div class="card"><div class="card-body">
    <h1 class="h3 mb-3">Edit Pemesanan</h1>
    <form action="{{ route('pemesanan.update', $pemesanan) }}" method="POST">
        @csrf @method('PUT')
        @include('pemesanan._form')
        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
        <a class="btn btn-outline-secondary" href="{{ route('pemesanan.index') }}">Batal</a>
    </form>
</div></div>
@endsection
