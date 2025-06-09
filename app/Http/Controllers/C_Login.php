<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class C_Login extends Controller
{
    public function masuk()
    {
        return view('auth.V_Login');
    }

    public function cekData(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email belum terisi!',
            'password.required' => 'Password belum terisi!',
        ]);

        $credentials = [
        'email' => $request->email,
        'password' => $request->password
    ];

     // Coba login
        if (Auth::attempt($credentials)) {
            // Regenerate session untuk mencegah session fixation
            $request->session()->regenerate();

            // Redirect ke halaman dashboard dengan peran user
            $user = Auth::user(); // Ambil user yang sedang login

            if ($user->role === 'admin') {
                return redirect()->route('admin.pengajuan')->with('success', 'Selamat datang, Admin!');
            } elseif ($user->role === 'calon_santri') {
                return redirect()->route('V_Dashboard')->with('success', 'Selamat datang di Dashboard Calon Santri!');
            }

            // Jika peran tidak dikenali
            Auth::logout();
            return redirect()->route('login')->with('failed', 'Peran pengguna tidak valid!');

            // Redirect ke halaman dashboard
            return redirect()->route('V_Dashboard');
        }

        // Jika gagal login, kembali ke halaman login dengan pesan error
        return redirect()->route('login')->with('failed', 'Email atau Password Salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

}
