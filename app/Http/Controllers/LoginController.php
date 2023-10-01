<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        // Validasi data yang diterima dari formulir login
        $credentials = $request->validate([
            'npk' => 'required|string',
            'password' => 'required|string',
        ]);

        // Lakukan proses otentikasi
        if (Auth::attempt($credentials)) {
            // Otentikasi berhasil
            return redirect("/dashboard");
        }

        // Otentikasi gagal
        return redirect("/login")->with('error', 'Invalid login credentials');
    }
}
