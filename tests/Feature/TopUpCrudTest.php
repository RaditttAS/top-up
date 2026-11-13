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

    public function test_order_form_and_crud_pages_are_available(): void
    {
        $this->get('/')->assertRedirect(route('home'));
        $this->get(route('home'))->assertOk();
        $this->get(route('pemesanan.index'))->assertOk();
        $this->get(route('pelanggan.index'))->assertOk();
        $this->get(route('produk-topup.index'))->assertOk();
    }

    public function test_customer_and_order_can_be_created_from_order_form(): void
    {
        $produk = ProdukTopUp::create([
            'kode_produk' => 'DM99',
            'jumlah_diamond' => 99,
            'harga' => 30000,
        ]);

        $this->post(route('pemesanan.place'), [
            'nama' => 'Budi',
            'email' => 'budi@example.com',
            'no_telepon' => '081234567890',
            'produk_topup_id' => $produk->id,
            'user_id_game' => 'user-budi',
            'zone_id_game' => '1',
            'jumlah' => 2,
        ])->assertRedirect(route('home'));

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
            ->post(route('pemesanan.place'), [
                'nama' => 'Sinta',
                'email' => 'sinta@example.com',
                'no_telepon' => '081234567891',
                'produk_topup_id' => $produk->id,
                'user_id_game' => '123456',
                'zone_id_game' => '123',
                'jumlah' => 1,
            ])
                ->assertRedirect(route('home'));

        $this->from(route('pemesanan.index'))
            ->post(route('pemesanan.place'), [
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

    public function test_customer_product_and_order_crud_routes_work(): void
    {
        $this->post(route('pelanggan.store'), [
            'nama' => 'Budi',
            'email' => 'budi@example.com',
            'no_telepon' => '081234567890',
        ])->assertRedirect(route('pelanggan.index'));

        $pelanggan = Pelanggan::where('email', 'budi@example.com')->firstOrFail();
        $this->get(route('pelanggan.create'))->assertOk();
        $this->get(route('pelanggan.show', $pelanggan))->assertOk();
        $this->get(route('pelanggan.edit', $pelanggan))->assertOk();
        $this->put(route('pelanggan.update', $pelanggan), [
            'nama' => 'Budi Updated',
            'email' => 'budi@example.com',
            'no_telepon' => '081234567891',
        ])->assertRedirect(route('pelanggan.index'));

        $this->post(route('produk-topup.store'), [
            'kode_produk' => 'DM99',
            'jumlah_diamond' => 99,
            'harga' => 30000,
        ])->assertRedirect(route('produk-topup.index'));

        $produk = ProdukTopUp::where('kode_produk', 'DM99')->firstOrFail();
        $this->get(route('produk-topup.create'))->assertOk();
        $this->get(route('produk-topup.show', $produk))->assertOk();
        $this->get(route('produk-topup.edit', $produk))->assertOk();
        $this->put(route('produk-topup.update', $produk), [
            'kode_produk' => 'DM99',
            'jumlah_diamond' => 100,
            'harga' => 31000,
        ])->assertRedirect(route('produk-topup.index'));

        $this->post(route('pemesanan.store'), [
            'kode_pesanan' => 'ORD-CRUD-001',
            'pelanggan_id' => $pelanggan->id,
            'produk_topup_id' => $produk->id,
            'user_id_game' => 'user-budi',
            'zone_id_game' => '1',
            'jumlah' => 2,
            'status' => 'menunggu_pembayaran',
        ])->assertRedirect(route('pemesanan.index'));

        $pemesanan = Pemesanan::where('kode_pesanan', 'ORD-CRUD-001')->firstOrFail();
        $this->get(route('pemesanan.create'))->assertOk();
        $this->get(route('pemesanan.show', $pemesanan))->assertOk();
        $this->get(route('pemesanan.edit', $pemesanan))->assertOk();
        $this->put(route('pemesanan.update', $pemesanan), [
            'kode_pesanan' => 'ORD-CRUD-001',
            'pelanggan_id' => $pelanggan->id,
            'produk_topup_id' => $produk->id,
            'user_id_game' => 'user-budi',
            'zone_id_game' => '1',
            'jumlah' => 3,
            'status' => 'diproses',
        ])->assertRedirect(route('pemesanan.index'));

        $this->assertDatabaseHas('pemesanan', [
            'id' => $pemesanan->id,
            'total_harga' => 93000,
            'status' => 'diproses',
        ]);

        $this->delete(route('pemesanan.destroy', $pemesanan))
            ->assertRedirect(route('pemesanan.index'));
        $this->delete(route('pelanggan.destroy', $pelanggan))
            ->assertRedirect(route('pelanggan.index'));
        $this->delete(route('produk-topup.destroy', $produk))
            ->assertRedirect(route('produk-topup.index'));
    }
}
