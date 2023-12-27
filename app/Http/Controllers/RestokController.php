<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Restok;
use App\Models\Suplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RestokController extends Controller
{
    public function index(Request $request)
    {
        $barang = Barang::all();
        $supliers = Suplier::all();
        $users = User::whereIn('role', ['kasir', 'admin'])->get();

        return view('pages.stok.stok-masuk', [
            'barang' => $barang,
            'supliers' => $supliers,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'suplier_id' => 'required',
            'barang_id' => 'required',
            'harga_beli_lama' => 'required|numeric',
            'harga_beli_baru' => 'required|numeric',
            'harga_jual_lama' => 'required|numeric',
            'harga_jual_baru' => 'required|numeric',
            'stok_lama' => 'required|numeric',
            'stok_baru' => 'required|numeric',
            'tanggal' => 'required',
            'expired' => 'nullable',
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

            Restok::create([
                'user_id' => auth()->id(),
                'suplier_id' => $request->suplier_id,
                'barang_id' => $request->barang_id,
                'harga_beli_lama' => $request->harga_beli_lama,
                'harga_beli_baru' => $request->harga_beli_baru,
                'harga_jual_lama' => $request->harga_jual_lama,
                'harga_jual_baru' => $request->harga_jual_baru,
                'stok_lama' => $request->stok_lama,
                'stok_baru' => $request->stok_baru,
                'tanggal' => $request->tanggal,
                'note' => $request->note,
            ]);
            
            $barang = Barang::where('id', $request->barang_id)->first();

            $barang->update([
                'harga_beli' => $request->harga_beli_baru,
                'harga_jual' => $request->harga_jual_baru,
                'stok' => ($barang->stok + $request->stok_baru),
                'expired' => ($request->expired) ? $request->expired : null,
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
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'nama' => 'required',
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

            $jenisBarang = JenisBarang::where('id', $request->jenis_barang_id)->first();
            
            $jenisBarang->update([
                'nama' => $request->nama,
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
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
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
            
            JenisBarang::where('id', $request->jenis_barang_id)->delete();

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
}
