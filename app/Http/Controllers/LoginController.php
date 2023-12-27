<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        return view('login', [
            'title' => 'Home Page'
        ]);
    }

    public function login(Request $request)
    {
        if(Auth::attempt($request->only('email', 'password'))){
            return redirect()
                ->route('dashboard')
                ->with('message', 'Selamat Datang');
        }

        return redirect()
            ->route('login')
            ->with('message', 'Email atau Password Salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return view('login', [
            'title' => 'Home Page'
        ]);
    }


}
