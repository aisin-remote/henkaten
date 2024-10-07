<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ThrottlesLogins;
    
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
        if ($this->hasTooManyLoginAttempts($request)) {
            // If too many attempts, send the lockout response
            return $this->sendLockoutResponse($request);
        }   

        // Lakukan proses otentikasi
        if (Auth::attempt($credentials)) {
            // Reset the login attempts since authentication succeeded
            $this->clearLoginAttempts($request);

            if(json_decode(auth()->user()->origin_id)){
                if(count(json_decode(auth()->user()->origin_id)) >= 2){
                    return redirect()->intended("/portal");
                }
            }

            // Otentikasi berhasil
            return redirect()->intended("/dashboard");
        }

        // Increment login attempts since authentication failed
        $this->incrementLoginAttempts($request);

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
