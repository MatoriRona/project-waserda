<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barang_id',
        'stok_lama', // stok sekarang yg tersedia
        'stok_keluar', // stok yang dikeluarkan /dibuang
        'tanggal',
        'note',
    ];
}