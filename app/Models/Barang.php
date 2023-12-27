<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_barang_id',
        'kode',
        'nama',
        'satuan',
        'harga_beli',
        'harga_jual',
        'stok',
        'expired',
        'is_active',
    ];
}
