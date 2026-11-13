<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pemesanan;
use App\Models\ProdukTopUp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil dibuat.');
    }

    public function edit(Pemesanan $pemesanan): View
    {
        return view('pemesanan.edit', array_merge(
            $this->formData(),
            compact('pemesanan')
        ));
    }

    public function orderForm(): View
    {
        return view('pemesanan.order', [
            'produk' => ProdukTopUp::orderBy('jumlah_diamond')->get(),
        ]);
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'no_telepon' => ['required', 'string', 'max:20', 'regex:/^[0-9+().\-\s]+$/'],
            'produk_topup_id' => ['required', 'integer', 'exists:produk_topup,id'],
            'user_id_game' => ['required', 'string', 'max:30'],
            'zone_id_game' => ['required', 'string', 'max:20'],
            'jumlah' => ['required', 'integer', 'min:1', 'max:100000'],
        ]);

        $produk = ProdukTopUp::findOrFail($validated['produk_topup_id']);

        $pelanggan = Pelanggan::firstOrCreate(
            ['email' => $validated['email']],
            [
                'nama' => $validated['nama'],
                'no_telepon' => $validated['no_telepon'],
            ]
        );

        $pelanggan->update([
            'nama' => $validated['nama'],
            'no_telepon' => $validated['no_telepon'],
        ]);

        do {
            $orderCode = 'ORD-' . strtoupper(Str::random(8));
        } while (Pemesanan::where('kode_pesanan', $orderCode)->exists());

        Pemesanan::create([
            'kode_pesanan' => $orderCode,
            'pelanggan_id' => $pelanggan->id,
            'produk_topup_id' => $validated['produk_topup_id'],
            'user_id_game' => $validated['user_id_game'],
            'zone_id_game' => $validated['zone_id_game'],
            'jumlah' => $validated['jumlah'],
            'harga_satuan' => $produk->harga,
            'total_harga' => $produk->harga * $validated['jumlah'],
            'status' => 'menunggu_pembayaran',
        ]);

        return redirect()->route('home')->with('success', 'Pemesanan berhasil dibuat.');
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
