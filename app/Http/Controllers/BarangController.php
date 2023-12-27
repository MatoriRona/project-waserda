<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JenisBarang;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $jenisBarang = JenisBarang::all();
        return view('pages.barang.index', [
            'jenis_barang' => $jenisBarang,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'kode' => 'required|numeric|unique:barangs,kode',
            'nama' => 'required',
            'satuan' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
            'expired' => 'required',
            'is_active' => 'required',
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
            
            Barang::create([
                'jenis_barang_id' => $request->jenis_barang_id,
                'kode' => $request->kode,
                'nama' => $request->nama,
                'satuan' => $request->satuan,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'stok' => $request->stok,
                'expired' => $request->expired,
                'is_active' => $request->is_active,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambah data'
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
    
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'kode' => ['required', 'numeric', Rule::unique('barangs')->ignore($request->barang_id)],
            'nama' => 'required',
            'satuan' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
            'expired' => 'required',
            'is_active' => 'required',
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

            $barang = Barang::where('id', $request->barang_id)->first();
            
            $barang->update([
                'jenis_barang_id' => $request->jenis_barang_id,
                'kode' => $request->kode,
                'nama' => $request->nama,
                'satuan' => $request->satuan,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'stok' => $request->stok,
                'expired' => $request->expired,
                'is_active' => $request->is_active,
            ]);
            
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengupdate data'
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

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
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

            $barang = TransaksiDetail::where('barang_id', $request->barang_id)->count();

            if($barang > 0){
                throw new \Exception("Barang ini telah pernah melakukan transaksi, barang tidak bisa dihapus, silahkan nonaktifkan");
            }
            
            Barang::where('id', $request->barang_id)->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data'
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
}
