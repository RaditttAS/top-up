<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProdukTopUpController;

Route::get('/', function () {
    return redirect()->route('pemesanan.index');
});

Route::get('pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');
Route::post('pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
Route::get('pemesanan/single-page', [PemesananController::class, 'singlePage'])->name('pemesanan.single');
Route::post('pemesanan/single-page', [PemesananController::class, 'singlePageStore'])->name('pemesanan.single.store');

// CRUD hanya dipusatkan pada tabel pemesanan.
// Pengelolaan pelanggan dan produk dilakukan melalui form pada halaman pemesanan.
