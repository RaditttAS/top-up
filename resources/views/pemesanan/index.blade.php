@extends('layouts.app')

@section('title', 'Data Pemesanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Data Pemesanan</h1>
    <a class="btn btn-primary" href="{{ route('pemesanan.create') }}">Tambah Pemesanan</a>
</div>
<div class="card"><div class="table-responsive">
    <table class="table table-striped table-hover mb-0">
        <thead><tr><th>Kode</th><th>Pelanggan</th><th>Produk</th><th>Jumlah</th><th>Total</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse ($pemesanan as $item)
            <tr>
                <td>{{ $item->kode_pesanan }}</td>
                <td>{{ $item->pelanggan->nama }}</td>
                <td>{{ $item->produkTopUp->kode_produk }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $item->status)) }}</td>
                <td class="text-nowrap">
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('pemesanan.show', $item) }}">Detail</a>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('pemesanan.edit', $item) }}">Edit</a>
                    <form class="d-inline" action="{{ route('pemesanan.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus pemesanan ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td class="text-center text-muted py-4" colspan="7">Belum ada data pemesanan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
@endsection
