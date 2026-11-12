<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukTopUpSeeder extends Seeder
{
    public function run(): void
    {

        DB::table('produk_topup')->insert([
            [
                'kode_produk' => 'DM86',
                'jumlah_diamond' => 86,
                'harga' => 20000,
            ],
            [
                'kode_produk' => 'DM172',
                'jumlah_diamond' => 172,
                'harga' => 39000,
            ],
        ]);
    }
}
