<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pemesanan;
use App\Models\ProdukTopUp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PemesananController extends Controller
{
    private const STATUSES = [
        'menunggu_pembayaran',
        'diproses',
        'berhasil',
        'gagal',
        'dibatalkan',
    ];

    public function index(): View
    {
        $pemesanan = Pemesanan::with(['pelanggan', 'produkTopUp'])->latest()->get();

        return view('pemesanan.index', compact('pemesanan'));
    }

    public function create(): View
    {
        return view('pemesanan.create', $this->formData());
    }

    public function show(Pemesanan $pemesanan): View
    {
        $pemesanan->load(['pelanggan', 'produkTopUp']);

        return view('pemesanan.show', compact('pemesanan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateOrder($request);
        $produk = ProdukTopUp::findOrFail($validated['produk_topup_id']);
        $validated['harga_satuan'] = $produk->harga;
        $validated['total_harga'] = $produk->harga * $validated['jumlah'];

        Pemesanan::create($validated);

        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil ditambahkan.');
    }

    public function edit(Pemesanan $pemesanan): View
    {
        return view('pemesanan.edit', array_merge(
            $this->formData(),
            compact('pemesanan')
        ));
    }

    public function update(Request $request, Pemesanan $pemesanan): RedirectResponse
    {
        $validated = $this->validateOrder($request, $pemesanan);
        $produk = ProdukTopUp::findOrFail($validated['produk_topup_id']);
        $validated['harga_satuan'] = $produk->harga;
        $validated['total_harga'] = $produk->harga * $validated['jumlah'];

        $pemesanan->update($validated);

        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil diperbarui.');
    }

    public function destroy(Pemesanan $pemesanan): RedirectResponse
    {
        $pemesanan->delete();

        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil dihapus.');
    }

    private function formData(): array
    {
        return [
            'pelanggan' => Pelanggan::orderBy('nama')->get(),
            'produk' => ProdukTopUp::orderBy('jumlah_diamond')->get(),
            'statuses' => self::STATUSES,
        ];
    }

    private function validateOrder(Request $request, ?Pemesanan $pemesanan = null): array
    {
        return $request->validate([
            'kode_pesanan' => [
                'required',
                'string',
                'max:30',
                Rule::unique('pemesanan', 'kode_pesanan')->ignore($pemesanan?->id),
            ],
            'pelanggan_id' => ['required', 'integer', 'exists:pelanggan,id'],
            'produk_topup_id' => ['required', 'integer', 'exists:produk_topup,id'],
            'user_id_game' => ['required', 'string', 'max:30'],
            'zone_id_game' => ['required', 'string', 'max:20'],
            'jumlah' => ['required', 'integer', 'min:1', 'max:100000'],
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);
    }
}
