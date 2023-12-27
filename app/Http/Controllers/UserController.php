<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.users.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nohp' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'role' => 'required',
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
            
            User::create([
                'name' => $request->name,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'password'  => Hash::make($request->password),
                'role' => $request->role,
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

    public function selfUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nohp' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->id())],
            'password' => 'nullable',
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

            $user = User::where('id', auth()->id())->first();

            $user->update([
                'name' => $request->name,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'password' => ($request->password) ? Hash::make($request->password) : $user->password,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengupdate akun'
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
            'user_id' => 'required|exists:users,id',
            'name' => 'required',
            'nohp' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($request->user_id)],
            'password' => 'nullable',
            'role' => 'required',
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

            $user = User::where('id', $request->user_id)->first();
            
            $user->update([
                'name' => $request->name,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'role' => $request->role,
            ]);
            
            if($request->password){
                $user->update([
                    'password'  => Hash::make($request->password),
                ]);
            }

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
            'user_id' => 'required|exists:users,id',
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
            
            $user = Transaksi::where('user_id', $request->user_id)->count();

            if($user > 0){
                throw new \Exception("User ini telah pernah melakukan transaksi, user tidak bisa dihapus.");
            }

            User::where('id', $request->user_id)->delete();

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
