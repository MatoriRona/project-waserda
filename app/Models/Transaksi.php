<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nota',
        'tanggal',
        'diskon',
        'total',
        'cash',
        'kembalian',
        'note'
    ];

    protected $appends = [
        'keuntungan',
    ];

    public function transaksiDetail(): HasMany
    {
        return $this->HasMany(TransaksiDetail::class);
    }

    public function getKeuntunganAttribute()
    {
        $total = 0;
        foreach ($this->transaksiDetail as $item) {
            $total = ($item->harga_jual - $item->harga_beli) * $item->qty;
        }
        return $total;
    }
    
    public function scopeBulanIni($query)
    {
        $firstDayOfMonth = now()->firstOfMonth()->format('Y-m-d');
        $lastDayOfMonth = now()->lastOfMonth()->format('Y-m-d');

        return $query->whereBetween('tanggal', [$firstDayOfMonth, $lastDayOfMonth]);
    }

}