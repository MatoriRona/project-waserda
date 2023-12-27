<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StokOut;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StokOutController extends Controller
{
    public function index(Request $request)
    {
        $barang = Barang::all();
        $users = User::whereIn('role', ['kasir', 'admin'])->get();

        return view('pages.stok.stok-keluar', [
            'barang' => $barang,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required',
            'stok_lama' => 'required|numeric',
            'stok_keluar' => 'required|numeric',
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

            StokOut::create([
                'user_id' => auth()->id(),
                'barang_id' => $request->barang_id,
                'stok_lama' => $request->stok_lama,
                'stok_keluar' => $request->stok_keluar,
                'tanggal' => $request->tanggal,
                'note' => $request->note,
            ]);
            
            $barang = Barang::where('id', $request->barang_id)->first();

            $barang->update([
                'stok' => ($barang->stok - $request->stok_keluar),
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
}
