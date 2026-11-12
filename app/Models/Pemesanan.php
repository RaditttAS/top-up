<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $fillable = [
        'kode_pesanan',
        'pelanggan_id',
        'produk_topup_id',
        'user_id_game',
        'zone_id_game',
        'jumlah',
        'harga_satuan',
        'total_harga',
        'status',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(
            Pelanggan::class,
            'pelanggan_id'
        );
    }

    public function produkTopUp(): BelongsTo
    {
        return $this->belongsTo(
            ProdukTopUp::class,
            'produk_topup_id'
        );
    }
}