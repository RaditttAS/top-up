@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')
<div class="card"><div class="card-body">
    <h1 class="h3 mb-3">Tambah Pelanggan</h1>
    <form action="{{ route('pelanggan.store') }}" method="POST">
        @csrf
        @include('pelanggan._form')
        <button class="btn btn-primary" type="submit">Simpan</button>
        <a class="btn btn-outline-secondary" href="{{ route('pelanggan.index') }}">Batal</a>
    </form>
</div></div>
@endsection
