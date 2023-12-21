<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Origin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('pages.auth.register',[
            'origins' => Origin::all(),
        ]);
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari formulir pendaftaran
        $request->validate([
            'name' => 'required|string|max:255',
            'npk' => 'required|string|max:255|unique:users', // Pastikan npk adalah unik dalam tabel users
            'role' => 'required|string|max:255',
            'origin_id' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed', // 'confirmed' memastikan cocok dengan konfirmasi password
            'password_confirmation' => 'required|string|min:6|same:password',
        ]);

        // Simpan data ke database
        $user = new User();
        $user->id = Str::uuid(); // Generate UUID sebagai ID
        $user->name = $request->input('name');
        $user->role = $request->input('role');
        $user->origin_id = $request->input('origin_id');
        $user->npk = $request->input('npk');
        $user->password = bcrypt($request->input('password')); // Mengenkripsi password
        $user->save();

        // Redirect ke halaman login atau sesuaikan dengan halaman yang Anda inginkan
        return redirect("/login")->with('success', 'Registration successful. You can now login.');
    }
}
