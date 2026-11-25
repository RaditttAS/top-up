<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdukTopUpRequest;
use App\Http\Requests\UpdateProdukTopUpRequest;
use App\Models\ProdukTopUp;
use Illuminate\Http\RedirectResponse;
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

    public function store(StoreProdukTopUpRequest $request): RedirectResponse
    {
        ProdukTopUp::create($request->validated());

        return redirect()->route('produk-topup.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(ProdukTopUp $produk_topup): View
    {
        return view('produk_topup.edit', ['produk' => $produk_topup]);
    }

    public function update(UpdateProdukTopUpRequest $request, ProdukTopUp $produk_topup): RedirectResponse
    {
        $produk_topup->update($request->validated());

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
