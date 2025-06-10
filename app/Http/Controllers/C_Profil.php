<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class C_Profil extends Controller
{
    public function profil()
    {
        return view('master.V_Profil');
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $inputFields = ['email', 'password'];

        $filledAny = false;
        foreach ($inputFields as $field) {
            if ($request->filled($field)) {
                $filledAny = true;
                break;
            }
        }

        if (!$filledAny) {
            return redirect()->back()->withErrors(['form' => 'Tidak ada field yang diisi!'])->withInput();
        }

        $rules = [
            'password' => 'nullable|string|min:8|max:10',
        ];

        if (!$user->isAdmin()) {
            $rules['email'] = 'nullable|string|max:255|unique:users,email,' . $user->id;
        }

        $messages = [
            'email.unique' => 'Email sudah digunakan!',
            'password.min' => 'Password minimal 8 karakter!',
            'password.max' => 'Password maksimal 10 karakter!',
        ];

        $validated = $request->validate($rules, $messages);

        if (isset($validated['email']) && !$user->isAdmin()) {
            $user->email = $validated['email'];
        }


        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
