@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Data Pelanggan</h1>
    <a class="btn btn-primary" href="{{ route('pelanggan.create') }}">Tambah Pelanggan</a>
</div>
<div class="card"><div class="table-responsive">
    <table class="table table-striped table-hover mb-0">
        <thead><tr><th>Nama</th><th>Email</th><th>Telepon</th><th>Jumlah Pesanan</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse ($pelanggan as $item)
            <tr>
                <td>{{ $item->nama }}</td><td>{{ $item->email }}</td><td>{{ $item->no_telepon }}</td>
                <td>{{ $item->pemesanan_count }}</td>
                <td class="text-nowrap">
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('pelanggan.show', $item) }}">Detail</a>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('pelanggan.edit', $item) }}">Edit</a>
                    <form class="d-inline" action="{{ route('pelanggan.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus pelanggan ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td class="text-center text-muted py-4" colspan="5">Belum ada data pelanggan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
@endsection
