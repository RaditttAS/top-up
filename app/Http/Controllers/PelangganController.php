<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PelangganController extends Controller
{
    public function index(): View
    {
        $pelanggan = Pelanggan::withCount('pemesanan')->latest()->get();

        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create(): View
    {
        return view('pelanggan.create');
    }

    public function show(Pelanggan $pelanggan): View
    {
        $pelanggan->load('pemesanan.produkTopUp');

        return view('pelanggan.show', compact('pelanggan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:pelanggan,email'],
            'no_telepon' => ['required', 'string', 'max:20', 'regex:/^[0-9+().\-\s]+$/'],
        ]);

        Pelanggan::create($validated);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit(Pelanggan $pelanggan): View
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('pelanggan', 'email')->ignore($pelanggan->id)],
            'no_telepon' => ['required', 'string', 'max:20', 'regex:/^[0-9+().\-\s]+$/'],
        ]);

        $pelanggan->update($validated);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy(Pelanggan $pelanggan): RedirectResponse
    {
        if ($pelanggan->pemesanan()->exists()) {
            return back()->with('error', 'Pelanggan tidak dapat dihapus karena masih memiliki pemesanan.');
        }

        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
