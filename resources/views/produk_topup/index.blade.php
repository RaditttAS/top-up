@extends('layouts.app')

@section('title', 'Data Produk Top Up')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Data Produk Top Up</h1>
    <a class="btn btn-primary" href="{{ route('produk-topup.create') }}">Tambah Produk</a>
</div>
<div class="card"><div class="table-responsive">
    <table class="table table-striped table-hover mb-0">
        <thead><tr><th>Kode Produk</th><th>Jumlah Diamond</th><th>Harga</th><th>Jumlah Pesanan</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse ($produk as $item)
            <tr>
                <td>{{ $item->kode_produk }}</td>
                <td>{{ number_format($item->jumlah_diamond, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                <td>{{ $item->pemesanan_count }}</td>
                <td class="text-nowrap">
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('produk-topup.show', $item) }}">Detail</a>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('produk-topup.edit', $item) }}">Edit</a>
                    <form class="d-inline" action="{{ route('produk-topup.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td class="text-center text-muted py-4" colspan="5">Belum ada data produk.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
@endsection
