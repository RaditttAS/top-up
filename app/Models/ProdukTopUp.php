<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProdukTopUp extends Model
{
    protected $table = 'produk_topup';

    protected $fillable = [
        'kode_produk',
        'jumlah_diamond',
        'harga',
    ];

    public function pemesanan(): HasMany
    {
        return $this->hasMany(
            Pemesanan::class,
            'produk_topup_id'
        );
    }
}