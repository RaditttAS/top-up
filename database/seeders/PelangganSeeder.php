<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {

        DB::table('pelanggan')->insert([
            [
                'nama' => 'Andi Pratama',
                'email' => 'andi@example.com',
                'no_telepon' => '081234567890',
            ],
            [
                'nama' => 'Siti Aminah',
                'email' => 'siti@example.com',
                'no_telepon' => '081298765432',
            ],
        ]);
    }
}
