<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\TransaksiKeranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{
    public function barang(Request $request)
    {
        $barang = Barang::query()->where('is_active', true);
        if ($request->has('barang_id')) {
            return response()->json([
                'success' => true,
                'barang' => $barang->where('id', $request->barang_id)->first()
            ]);
        }

        if ($request->has('kode')) {
            return response()->json([
                'success' => true,
                'barang' => $barang->where('kode', 'LIKE', '%' . $request->kode . '%')->get()
            ]);
        }
        
        if ($request->has('nama')) {
            return response()->json([
                'success' => true,
                'barang' => $barang->where('nama', 'LIKE', '%' . $request->nama . '%')->get()
            ]);
        }

        return response()->json([
            'success' => true,
            'barang' => $barang->get(),
        ]);
    }

    public function keranjang(Request $request)
    {
        $keranjang = TransaksiKeranjang::selectRaw("
            transaksi_keranjangs.*,
            barangs.kode,
            barangs.nama,
            barangs.satuan,
            barangs.harga_jual
        ")->join('barangs', 'barangs.id', 'transaksi_keranjangs.barang_id')
        ->where('user_id', $request->user_id)
        ->get();

        return response()->json([
            'success' => true,
            'keranjang' => $keranjang,
        ]);
    }
    
    public function transaksi(Request $request)
    {
        $transaksi = Transaksi::selectRaw("
                transaksis.*,
                users.name as kasir
            ")
            ->join('users', 'users.id', 'transaksis.user_id')
            ->where('transaksis.id', $request->id)
            ->first();

        $transaksiDetail = TransaksiDetail::selectRaw("
                transaksi_details.*,
                barangs.kode,
                barangs.nama,
                barangs.satuan
            ")
            ->join('barangs', 'barangs.id', 'transaksi_details.barang_id')
            ->where('transaksi_details.transaksi_id', $request->id)
            ->get();

        return response()->json([
            'success' => true,
            'transaksi' => $transaksi,
            'transaksi_detail' => $transaksiDetail,
        ]);
    }

}

