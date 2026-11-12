
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();

            $table->string('kode_pesanan', 30)->unique();

            $table->foreignId('pelanggan_id')
                ->constrained('pelanggan')
                ->restrictOnDelete();

            $table->foreignId('produk_topup_id')
                ->constrained('produk_topup')
                ->restrictOnDelete();

            $table->string('user_id_game', 30);
            $table->string('zone_id_game', 20);

            $table->unsignedInteger('jumlah')->default(1);
            $table->unsignedBigInteger('harga_satuan');
            $table->unsignedBigInteger('total_harga');

            $table->enum('status', [
                'menunggu_pembayaran',
                'diproses',
                'berhasil',
                'gagal',
                'dibatalkan',
            ])->default('menunggu_pembayaran');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};