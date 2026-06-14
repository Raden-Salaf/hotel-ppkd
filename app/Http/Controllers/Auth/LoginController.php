<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    //tampilkan halaman login
    public function showLogin ()
    {
        if (Auth::check()){
            return redirect()->route('admin.dashboard');
        }
        return view ('auth.login');
    }

    // Proces login

    public function login(Request $request)
    {
        // langkah 1, validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'min:6',
        ]);

        // langkah 2, cek apakah user aktif

        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && !$user->is_active)
        {
            return back ()-> withErrors([
                'email' => 'Akun kamu nonaktif, hubungi super admin segera.', 
            ])-> withInput();
        }

        // langkah 3, coba login
        if(Auth::attempt($credentials, $request->boolean('remember'))){
            $request->session()->regenerate(); //cegah session fixation attack

            Alert::success('Success','Login Berhasil');
            return redirect()->intended(route('admin.dashboard'));
        }

        // langkah 4, kalau gagal

        return back ()->withErrors([
            'email'=> 'Email atau password salah!'
            ])->withInput($request->only('email'));
        }
        
        public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        Alert::success('Success','Logout Berhasil');
        return redirect()->route('login');
    }
}
