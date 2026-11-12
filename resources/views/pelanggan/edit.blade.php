@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="card"><div class="card-body">
    <h1 class="h3 mb-3">Edit Pelanggan</h1>
    <form action="{{ route('pelanggan.update', $pelanggan) }}" method="POST">
        @csrf @method('PUT')
        @include('pelanggan._form')
        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
        <a class="btn btn-outline-secondary" href="{{ route('pelanggan.index') }}">Batal</a>
    </form>
</div></div>
@endsection
