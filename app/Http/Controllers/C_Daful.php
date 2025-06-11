<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;

class C_Daful extends Controller
{
    /**
     * Menampilkan halaman riwayat daftar ulang.
     */
    public function index()
    {
        $user = auth()->user();
        $data = Pendaftaran::where('status', 'Disetujui')
        ->where('user_id', $user->id)
        ->get();

        return view('user.V_DaftarUlang', compact('data'));
    }

    /**
     * Menyimpan data daftar ulang.
     */
    public function simpanDaftarUlang(Request $request)
    {
        // Validasi input file dan kode pendaftaran
        $request->validate([
            'kode' => 'required|exists:pendaftaran,kode',
            'kartu_keluarga' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'akta_kelahiran' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Simpan file yang diunggah
        $kkPath = $request->file('kartu_keluarga')->store('uploads/kartu_keluarga', 'public');
        $aktaPath = $request->file('akta_kelahiran')->store('uploads/akta_kelahiran', 'public');

        // Update data pendaftaran di database
        $pendaftaran = Pendaftaran::where('kode', $request->kode)->first();
        $pendaftaran->update([
            'status' => 'Disetujui',
            'file_kk' => $kkPath,
            'file_akta' => $aktaPath,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('daftarUlang.index')->with('success', 'Daftar ulang berhasil disimpan!');
    }
}
