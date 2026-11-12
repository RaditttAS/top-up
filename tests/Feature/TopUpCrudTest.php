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

    public function test_all_resource_pages_can_be_displayed(): void
    {
        $this->get(route('pelanggan.index'))->assertOk();
        $this->get(route('pelanggan.create'))->assertOk();
        $this->get(route('produk-topup.index'))->assertOk();
        $this->get(route('produk-topup.create'))->assertOk();
        $this->get(route('pemesanan.index'))->assertOk();
        $this->get(route('pemesanan.create'))->assertOk();
    }

    public function test_customer_product_and_order_can_be_created_updated_and_deleted(): void
    {
        $this->post(route('pelanggan.store'), [
            'nama' => 'Andi',
            'email' => 'andi@example.com',
            'no_telepon' => '081234567890',
        ])->assertRedirect(route('pelanggan.index'));
        $pelanggan = Pelanggan::where('email', 'andi@example.com')->firstOrFail();

        $this->post(route('produk-topup.store'), [
            'kode_produk' => 'DM86',
            'jumlah_diamond' => 86,
            'harga' => 20000,
        ])->assertRedirect(route('produk-topup.index'));
        $produk = ProdukTopUp::where('kode_produk', 'DM86')->firstOrFail();

        $this->put(route('pelanggan.update', $pelanggan), [
            'nama' => 'Andi Baru',
            'email' => 'andi@example.com',
            'no_telepon' => '081234567890',
        ])->assertRedirect(route('pelanggan.index'));
        $this->assertSame('Andi Baru', $pelanggan->fresh()->nama);
        $this->get(route('pelanggan.edit', $pelanggan))->assertOk();

        $this->put(route('produk-topup.update', $produk), [
            'kode_produk' => 'DM86',
            'jumlah_diamond' => 100,
            'harga' => 25000,
        ])->assertRedirect(route('produk-topup.index'));
        $this->assertSame(100, $produk->fresh()->jumlah_diamond);
        $this->get(route('produk-topup.edit', $produk))->assertOk();

        $this->post(route('pemesanan.store'), [
            'kode_pesanan' => 'ORD-001',
            'pelanggan_id' => $pelanggan->id,
            'produk_topup_id' => $produk->id,
            'user_id_game' => '123456',
            'zone_id_game' => '123',
            'jumlah' => 2,
            'status' => 'menunggu_pembayaran',
        ])->assertRedirect(route('pemesanan.index'));
        $pemesanan = Pemesanan::where('kode_pesanan', 'ORD-001')->firstOrFail();
        $this->assertSame(50000, $pemesanan->total_harga);
        $this->get(route('pemesanan.edit', $pemesanan))->assertOk();

        $this->get(route('pelanggan.show', $pelanggan))->assertOk();
        $this->get(route('produk-topup.show', $produk))->assertOk();
        $this->get(route('pemesanan.show', $pemesanan))->assertOk();

        $this->put(route('pemesanan.update', $pemesanan), [
            'kode_pesanan' => 'ORD-001',
            'pelanggan_id' => $pelanggan->id,
            'produk_topup_id' => $produk->id,
            'user_id_game' => '123456',
            'zone_id_game' => '123',
            'jumlah' => 3,
            'status' => 'berhasil',
        ])->assertRedirect(route('pemesanan.index'));
        $this->assertSame(75000, $pemesanan->fresh()->total_harga);

        $this->delete(route('pemesanan.destroy', $pemesanan))
            ->assertRedirect(route('pemesanan.index'));
        $this->assertDatabaseMissing('pemesanan', ['id' => $pemesanan->id]);

        $this->delete(route('produk-topup.destroy', $produk))
            ->assertRedirect(route('produk-topup.index'));
        $this->delete(route('pelanggan.destroy', $pelanggan))
            ->assertRedirect(route('pelanggan.index'));
        $this->assertDatabaseMissing('produk_topup', ['id' => $produk->id]);
        $this->assertDatabaseMissing('pelanggan', ['id' => $pelanggan->id]);
    }

    public function test_unique_and_required_relationship_fields_are_validated(): void
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

        $this->from(route('pelanggan.create'))
            ->post(route('pelanggan.store'), [
                'nama' => '',
                'email' => 'bukan-email',
                'no_telepon' => 'abc',
            ])
            ->assertSessionHasErrors(['nama', 'email', 'no_telepon']);

        $this->from(route('pelanggan.create'))
            ->post(route('pelanggan.store'), [
                'nama' => 'Orang Lain',
                'email' => 'andi@example.com',
                'no_telepon' => '081234567891',
            ])
            ->assertSessionHasErrors('email');

        $this->from(route('produk-topup.create'))
            ->post(route('produk-topup.store'), [
                'kode_produk' => 'DM86',
                'jumlah_diamond' => 86,
                'harga' => 20000,
            ])
            ->assertSessionHasErrors('kode_produk');

        $this->from(route('produk-topup.create'))
            ->post(route('produk-topup.store'), [
                'kode_produk' => 'DM100',
                'jumlah_diamond' => 0,
                'harga' => 0,
            ])
            ->assertSessionHasErrors(['jumlah_diamond', 'harga']);

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
        $this->from(route('pemesanan.create'))
            ->post(route('pemesanan.store'), [
                'kode_pesanan' => 'ORD-EXISTING',
                'pelanggan_id' => $pelanggan->id,
                'produk_topup_id' => $produk->id,
                'user_id_game' => '123456',
                'zone_id_game' => '123',
                'jumlah' => 1,
                'status' => 'diproses',
            ])
            ->assertSessionHasErrors('kode_pesanan');

        $this->from(route('pemesanan.create'))
            ->post(route('pemesanan.store'), [
                'kode_pesanan' => 'ORD-INVALID',
                'pelanggan_id' => 999,
                'produk_topup_id' => 999,
                'user_id_game' => '123456',
                'zone_id_game' => '123',
                'jumlah' => 1,
                'status' => 'tidak_valid',
            ])
            ->assertSessionHasErrors(['pelanggan_id', 'produk_topup_id', 'status']);
    }

    public function test_customer_and_product_in_use_cannot_be_deleted(): void
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
            'kode_pesanan' => 'ORD-001',
            'pelanggan_id' => $pelanggan->id,
            'produk_topup_id' => $produk->id,
            'user_id_game' => '123456',
            'zone_id_game' => '123',
            'jumlah' => 1,
            'harga_satuan' => $produk->harga,
            'total_harga' => $produk->harga,
            'status' => 'berhasil',
        ]);

        $this->delete(route('pelanggan.destroy', $pelanggan))
            ->assertSessionHas('error');
        $this->delete(route('produk-topup.destroy', $produk))
            ->assertSessionHas('error');
    }
}
