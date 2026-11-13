<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProdukTopUpController;

Route::redirect('/', '/skinku');
Route::get('/skinku', [PemesananController::class, 'orderForm'])->name('home');
Route::post('pesan', [PemesananController::class, 'placeOrder'])->name('pemesanan.place');

Route::resource('pemesanan', PemesananController::class);
Route::resource('pelanggan', PelangganController::class);
Route::resource('produk-topup', ProdukTopUpController::class);
