<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Informasi;

class C_Informasi extends Controller
{
    public function ShowDataInformasi()
    {
        $informasi = Informasi::all();
        $isAdmin = Auth::check() && Auth::user()->role === 'admin';
        
        return view('master.V_Informasi', compact('informasi', 'isAdmin'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'informasi' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('informasi', 'public');
        }

        Informasi::create($validated);

        return redirect()->route('informasi.index')->with('success', 'Informasi berhasil ditambahkan.');
    }

    public function detail($id)
    {
        $informasi = Informasi::findOrFail($id);
        return response()->json($informasi);
    }

    public function update(Request $request, $id)
    {
        $informasi = Informasi::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'informasi' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($informasi->foto) {
                Storage::disk('public')->delete($informasi->foto);
            }
            $validated['foto'] = $request->file('foto')->store('informasi', 'public');
        }

        $informasi->update($validated);

        return redirect()->route('informasi.index')->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $informasi = Informasi::findOrFail($id);
        if ($informasi->foto) {
            Storage::disk('public')->delete($informasi->foto);
        }
        $informasi->delete();
        return response()->json(['success' => true]);
    }
}