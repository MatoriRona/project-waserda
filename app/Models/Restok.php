<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restok extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'suplier_id',
        'barang_id',
        'harga_beli_lama',
        'harga_beli_baru',
        'harga_jual_lama',
        'harga_jual_baru',
        'stok_lama',
        'stok_baru', // maksud stok_baru adalah jumlah penambahan, bukan total sekarang
        'tanggal',
        'note',
    ];
}
