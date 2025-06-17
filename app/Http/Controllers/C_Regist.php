<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class C_Regist extends Controller
{
    public function daftar()
    {
        return view("auth.V_Regist");
    }

    public function daftarUser (Request $request)
    {
        $rules = [
            'email' => [
                'required',
                'email',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9]+@gmail\.com$/',
            ],
            'password' => 'required|string|min:8|max:10|confirmed',
        ];

        $messages = [
            'email.required' => 'Email belum terisi!',
            'email.email' => 'Format email tidak valid!',
            'email.regex' => 'Email harus berakhiran @gmail.com!',
            'email.unique' => 'Email sudah digunakan!',
            'password.required' => 'Password belum terisi!',
            'password.min' => 'Password minimal 8 karakter!',
            'password.max' => 'Password maksimal 10 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak sesuai!',
        ];

        $validated = $request->validate($rules, $messages);

        User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect('/register')->with('success', 'Silakan Login');
    }
}
