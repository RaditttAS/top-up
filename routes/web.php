<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProdukTopUpController;

Route::get('/', function () {
    return redirect()->route('pemesanan.index');
});

Route::resource('pelanggan', PelangganController::class);
Route::resource('produk-topup', ProdukTopUpController::class)->parameters([
    'produk-topup' => 'produk_topup',
]);
Route::resource('pemesanan', PemesananController::class);