<?php

namespace Tests\Feature;

use App\Models\Pelanggan;
use App\Models\Pemesanan;
use App\Models\ProdukTopUp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TopUpCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_single_page_order_form_is_available(): void
    {
        $this->get(route('pemesanan.index'))->assertOk();
        $this->get(route('pemesanan.single'))->assertOk();
    }

    public function test_customer_and_order_can_be_created_from_single_page(): void
    {
        $produk = ProdukTopUp::create([
            'kode_produk' => 'DM99',
            'jumlah_diamond' => 99,
            'harga' => 30000,
        ]);

        $this->post(route('pemesanan.single.store'), [
            'nama' => 'Budi',
            'email' => 'budi@example.com',
            'no_telepon' => '081234567890',
            'produk_topup_id' => $produk->id,
            'user_id_game' => 'user-budi',
            'zone_id_game' => '1',
            'jumlah' => 2,
        ])->assertRedirect(route('pemesanan.index'));

        $pelanggan = Pelanggan::where('email', 'budi@example.com')->firstOrFail();
        $this->assertSame('Budi', $pelanggan->nama);
        $this->assertDatabaseHas('pemesanan', [
            'pelanggan_id' => $pelanggan->id,
            'total_harga' => 60000,
        ]);
        $this->assertDatabaseHas('pemesanan', [
            'pelanggan_id' => $pelanggan->id,
            'status' => 'menunggu_pembayaran',
        ]);
    }

    public function test_order_validation_rules_are_applied(): void
    {
        $pelanggan = Pelanggan::create([
            'nama' => 'Andi',
            'email' => 'andi@example.com',
            'no_telepon' => '081234567890',
        ]);
        $produk = ProdukTopUp::create([
            'kode_produk' => 'DM86',
            'jumlah_diamond' => 86,
            'harga' => 20000,
        ]);

        Pemesanan::create([
            'kode_pesanan' => 'ORD-EXISTING',
            'pelanggan_id' => $pelanggan->id,
            'produk_topup_id' => $produk->id,
            'user_id_game' => '123456',
            'zone_id_game' => '123',
            'jumlah' => 1,
            'harga_satuan' => $produk->harga,
            'total_harga' => $produk->harga,
            'status' => 'menunggu_pembayaran',
        ]);

        $this->from(route('pemesanan.index'))
            ->post(route('pemesanan.store'), [
                'nama' => 'Sinta',
                'email' => 'sinta@example.com',
                'no_telepon' => '081234567891',
                'produk_topup_id' => $produk->id,
                'user_id_game' => '123456',
                'zone_id_game' => '123',
                'jumlah' => 1,
            ])
            ->assertRedirect(route('pemesanan.index'));

        $this->from(route('pemesanan.index'))
            ->post(route('pemesanan.store'), [
                'nama' => 'Sinta',
                'email' => 'sinta@example.com',
                'no_telepon' => '081234567891',
                'produk_topup_id' => 999,
                'user_id_game' => '123456',
                'zone_id_game' => '123',
                'jumlah' => 0,
            ])
            ->assertSessionHasErrors(['produk_topup_id', 'jumlah']);
    }
}
