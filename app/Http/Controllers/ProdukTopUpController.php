<?php

namespace App\Http\Controllers;

use App\Models\ProdukTopUp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProdukTopUpController extends Controller
{
    public function index(): View
    {
        $produk = ProdukTopUp::withCount('pemesanan')->latest()->get();

        return view('produk_topup.index', compact('produk'));
    }

    public function create(): View
    {
        return view('produk_topup.create');
    }

    public function show(ProdukTopUp $produk_topup): View
    {
        $produk_topup->load('pemesanan.pelanggan');

        return view('produk_topup.show', ['produk' => $produk_topup]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_produk' => ['required', 'string', 'max:20', 'unique:produk_topup,kode_produk'],
            'jumlah_diamond' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'harga' => ['required', 'integer', 'min:1', 'max:9000000000000'],
        ]);

        ProdukTopUp::create($validated);

        return redirect()->route('produk-topup.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(ProdukTopUp $produk_topup): View
    {
        return view('produk_topup.edit', ['produk' => $produk_topup]);
    }

    public function update(Request $request, ProdukTopUp $produk_topup): RedirectResponse
    {
        $validated = $request->validate([
            'kode_produk' => ['required', 'string', 'max:20', Rule::unique('produk_topup', 'kode_produk')->ignore($produk_topup->id)],
            'jumlah_diamond' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'harga' => ['required', 'integer', 'min:1', 'max:9000000000000'],
        ]);

        $produk_topup->update($validated);

        return redirect()->route('produk-topup.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(ProdukTopUp $produk_topup): RedirectResponse
    {
        if ($produk_topup->pemesanan()->exists()) {
            return back()->with('error', 'Produk tidak dapat dihapus karena masih digunakan dalam pemesanan.');
        }

        $produk_topup->delete();

        return redirect()->route('produk-topup.index')->with('success', 'Produk berhasil dihapus.');
    }
}
