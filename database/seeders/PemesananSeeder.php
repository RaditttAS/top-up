<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PemesananSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pemesanan')->insert([
            [
                'kode_pesanan' => 'ORD-2026-001',
                'pelanggan_id' => 1,
                'produk_topup_id' => 1,
                'user_id_game' => '123456789',
                'zone_id_game' => '1234',
                'jumlah' => 1,
                'harga_satuan' => 20000,
                'total_harga' => 20000,
                'status' => 'berhasil',
            ],
            [
                'kode_pesanan' => 'ORD-2026-002',
                'pelanggan_id' => 2,
                'produk_topup_id' => 2,
                'user_id_game' => '987654321',
                'zone_id_game' => '4321',
                'jumlah' => 2,
                'harga_satuan' => 39000,
                'total_harga' => 78000,
                'status' => 'menunggu_pembayaran',
            ],
        ]);
    }
}
