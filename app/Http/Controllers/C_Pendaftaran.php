<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class C_Pendaftaran extends Controller
{
    public function pendaftaran()
    {
        $data = Pendaftaran::with('user')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        $hasActiveSubmission = Pendaftaran::where('user_id', auth()->id())
            ->whereIn('status', ['Proses', 'Disetujui', 'Ditolak'])
            ->exists();
        return view('user.V_Pendaftaran', compact('data', 'hasActiveSubmission'));
    }


    public function show($id)
    {
        $pendaftaran = Pendaftaran::with('user')->get();

        return response()->json([
            'status' => 'success',
            'data' => $pendaftaran,
        ]);
    }


    // pov admin
    public function adminPendaftaran(Request $request)
    {
        $query = Pendaftaran::with('user');

        if ($request->has('status') && in_array($request->status, ['Proses', 'Disetujui', 'Ditolak'])) {
            $query->where('status', $request->status);
        }

        $data = $query->orderByDesc('created_at')->get();

        return view('admin.V_Verifikasi', compact('data'));
    }

    public function simpan(Request $request)
    {
        $existing = Pendaftaran::where('user_id', Auth::id())
            ->where('status', 'Proses')
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Anda hanya dapat membuat satu pendaftaran dengan status Proses.');
        }

        $rules = [
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|max:11|unique:pendaftaran,nisn',
            'tempat' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:13'
        ];

        $messages = [
            'nama.required' => 'Nama belum diisi!',
            'nama.max' => 'Nama terlalu panjang (maks 255 karakter).',
            'no_hp.max' => 'No.Hp Salah satu orang tua saja'
        ];

        $validated = $request->validate($rules, $messages);

        // Generate kode: PSB-0001, PSB-0002, dst
        $last = \App\Models\Pendaftaran::latest('id')->first();
        $nextNumber = $last ? $last->id + 1 : 1;
        $kode = 'PSB-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        Pendaftaran::create([
            'user_id' => Auth::id(),
            'nama' => $validated['nama'],
            'nisn' => $validated['nisn'],
            'tempat' => $validated['tempat'],
            'tanggal' => $validated['tanggal'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['no_hp'],
            'kode' => $kode,
            'status' => 'Proses'
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil!');
    }

    public function ubahStatus(Request $request, $id, $status)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        // Validasi jika status final tidak bisa diubah lagi
        if (in_array($pendaftaran->status, ['Disetujui', 'Ditolak'])) {
            return redirect()->back()->with('error', 'Status final tidak dapat diubah.');
        }

        $pendaftaran->status = $status;
        $pendaftaran->save();

        return redirect()->back()->with('success', "Status berhasil diubah ke {$status}.");


        // $pendaftaran = Pendaftaran::findOrFail($id);

        // if ($pendaftaran->status !== 'Proses') {
        // return redirect()->back()->with('error', 'Status sudah diverifikasi dan tidak dapat diubah lagi.');
        // }

        // $pendaftaran->status = $status;
        // $pendaftaran->save();

        // return redirect()->back()->with('success', "Status berhasil diubah {$status}.");
    }
}
