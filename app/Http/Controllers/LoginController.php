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

    public function authenticate(Request $request)
    {
        // Validasi data yang diterima dari formulir login
        $credentials = $request->validate([
            'npk' => 'required|string',
            'password' => 'required|string',
        ]);

        // Lakukan proses otentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Otentikasi berhasil
            return redirect()->intended("/dashboard");
        }

        // Otentikasi gagal
        return redirect("/login")->with('error', 'Invalid login credentials');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.index');
    }
}
