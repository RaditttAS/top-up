
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_topup', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk', 20)->unique();
            $table->unsignedInteger('jumlah_diamond');
            $table->unsignedBigInteger('harga');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_topup');
    }
};