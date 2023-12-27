<?php

namespace App\Http\Controllers;

use App\Models\Restok;
use App\Models\Suplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SuplierController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.suplier.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nohp' => 'required',
            'alamat' => 'required',
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
            
            Suplier::create([
                'nama' => $request->nama,
                'nohp' => $request->nohp,
                'alamat' => $request->alamat,
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
            'suplier_id' => 'required|exists:supliers,id',
            'nama' => 'required',
            'nohp' => 'required',
            'alamat' => 'required',
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

            $suplier = Suplier::where('id', $request->suplier_id)->first();
            
            $suplier->update([
                'nama' => $request->nama,
                'nohp' => $request->nohp,
                'alamat' => $request->alamat,
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
            'suplier_id' => 'required|exists:supliers,id',
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
            
            $suplier = Restok::where('suplier_id', $request->suplier_id)->count();

            if($suplier > 0){
                throw new \Exception("Suplier ini telah pernah melakukan transaksi, suplier tidak bisa dihapus.");
            }

            Suplier::where('id', $request->suplier_id)->delete();

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
