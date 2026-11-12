<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';

    protected $fillable = [
        'nama',
        'email',
        'no_telepon',
    ];

    public function pemesanan(): HasMany
    {
        return $this->hasMany(
            Pemesanan::class,
            'pelanggan_id'
        );
    }
}