<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Informasi; // <-- ini WAJIB ADA
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class KatalogController extends Controller
{
    public function ShowDataKatalog()
    {
        if (Auth::user()->role_id === 1) {
            $katalogs = DB::table('katalog')->get();
            return view('AdminPenjualan.Katalog.HalamanKatalog', compact('katalogs'));
        } else {
                $katalogs = Katalog::where('stok', '>', 0)->get();
            return view('Customer.Katalog.HalamanKatalog', compact('katalogs'));
        }
        // return view('AdminPenjualan.Katalog.index', compact('katalog'));
    }

    public function ShowFormTambahKatalog()
    {
        return view('AdminPenjualan.Katalog.FormTambahKatalog');
    }

    public function KlikSimpan(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'foto' => 'required|image|max:2048',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('katalog', 'public');
        }

        Katalog::create($validated);

        return redirect()->route('admin.katalog.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function ShowFormUbahKatalog($id)
    {
        $katalog = Katalog::findOrFail($id);
        return view('AdminPenjualan.Katalog.FormUbahKatalog', compact('katalog'));
    }

    public function KlikUbah(Request $request, $id)
    {
        $katalog = Katalog::findOrFail($id);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'foto' => 'nullable|image|max:2048',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($request->hasFile('foto')) {
            if ($katalog->foto) {
                Storage::disk('public')->delete($katalog->foto);
            }
            $validated['foto'] = $request->file('foto')->store('katalog', 'public');
        }

        $katalog->update($validated);

        return redirect()->route('admin.katalog.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy($id)
    {
        $katalog = Katalog::findOrFail($id);
        if ($katalog->foto) {
            Storage::disk('public')->delete($katalog->foto);
        }
        $katalog->delete();
        return response()->json(['success' => true]);
    }

    public function detail($id)
    {
        $katalog = Katalog::findOrFail($id);
        return response()->json($katalog);
    }
}