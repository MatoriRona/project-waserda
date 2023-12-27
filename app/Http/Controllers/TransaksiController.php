<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\TransaksiKeranjang;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index(Request $request){
        return view('pages.transaksi.index');
    }

    public function storeCart(Request $request){
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        try {
            DB::beginTransaction();
            // cek apakah barang sudah ada
            $keranjang = TransaksiKeranjang::where('barang_id', $request->barang_id)
                ->where('user_id', auth()->user()->id)
                ->first(); 

            if($keranjang){
                $keranjang->update([
                    'qty' => $keranjang->qty + $request->qty,
                ]);
            }else{
                $keranjang = TransaksiKeranjang::create([
                    'user_id' => auth()->user()->id,
                    'barang_id' => $request->barang_id,
                    'qty' => $request->qty,
                ]);
            }

            $barang = Barang::where('id', $request->barang_id)->first();
  
            if($barang->stok < $keranjang->qty){
                throw new \Exception("Stok Barang $barang->nama tidak cukup. Stok tersisa $barang->stok.");
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambah data'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
                'errors' => [
                    $th->getMessage(),
                ],
            ], 500);
        }
    }

    public function deleteCart(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:transaksi_keranjangs,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        try {
            DB::beginTransaction();
            
            TransaksiKeranjang::where('id', $request->id)->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed.',
                'errors' => [
                    $th->getMessage(),
                ],
            ], 500);
        }        
    }

    public function removeCart(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        try {
            DB::beginTransaction();
            
            TransaksiKeranjang::where('user_id', $request->id)->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed.',
                'errors' => [
                    $th->getMessage(),
                ],
            ], 500);
        }        
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'tanggal' => 'required',
            'total' => 'required',
            'cash' => 'required',
            'kembalian' => 'required',
            'note' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            // buat nota
            $nota = $this->generateNota();

            // ambil data keranjang
            $keranjang = TransaksiKeranjang::where('user_id', $request->user_id)->get(); 

            //  simpan transaksi
            $transaksi = Transaksi::create([
                'user_id' => $request->user_id,
                'nota' => $nota,
                'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
                'diskon' => $request->diskon,
                'total' => to_int($request->total),
                'cash' => to_int($request->cash),
                'kembalian' => to_int($request->kembalian),
                'note' => $request->note,
            ]);

            //  simpan transaksi detail
            foreach ($keranjang as $key => $item) {
                $barang = Barang::where('id', $item->barang_id)->first();
               
                if($barang->stok < $item->qty){
                    throw new \Exception("Stok Barang $barang->nama tidak cukup. Stok tersisa $barang->stok.");
                }
                
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $barang->id,
                    'qty' => $item->qty,
                    'harga_beli' => $barang->harga_beli,
                    'harga_jual' => $barang->harga_jual,
                ]);

                // update stok barang nya
                $barang->update([
                    'stok' => ($barang->stok - $item->qty),
                ]);
            }

            //  hapus transaksi keranjang
            TransaksiKeranjang::where('user_id', $request->user_id)->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambah transaksi',
                'transaksi_id' => $transaksi->id,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
                'errors' => [
                    $th->getMessage(),
                ],
            ], 500);
        }
    }

    public function generateNota()
    {
        $today = date('Ymd'); // Mendapatkan tanggal saat ini sebagai format Ymd (misal: 20231106 untuk 6 November 2023)

        // Mengambil nomor transaksi terakhir dari database berdasarkan tanggal terakhir
        $lastTransaction = Transaksi::whereDate('tanggal', date('Y-m-d'))->orderBy('id', 'desc')->first();
        // dd($lastTransaction);/
        if ($lastTransaction) {
            $lastTransactionNumber = intval(substr($lastTransaction->nota, -5)); // Mengambil lima digit terakhir
        } else {
            $lastTransactionNumber = 0;
        }

        // Mengecek apakah tanggal terakhir sama dengan tanggal hari ini
        if ($lastTransaction && Carbon::parse($lastTransaction->tanggal)->format('Ymd') == $today) {
            $newTransactionNumber = $today . str_pad($lastTransactionNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            // Jika tanggal berbeda, kita mulai dari nomor pertama pada tanggal baru
            $newTransactionNumber = $today . '00001';
        }
        // Lakukan sesuatu dengan nomor transaksi yang dihasilkan
        return $newTransactionNumber;
    }

    public function view(Request $request){
        $users = User::whereIn('role', ['kasir', 'admin'])->get();

        return view('pages.transaksi.view', [
            'users' => $users,
        ]);
    }

    public function print(Request $request){
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


        return view('pages.transaksi.print', [
            'success' => true,
            'transaksi' => $transaksi,
            'transaksi_detail' => $transaksiDetail,
        ]);
    }


}
