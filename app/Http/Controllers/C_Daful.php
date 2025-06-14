<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;

class C_Daful extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function index()
    {
        $user = auth()->user();
        $data = Pendaftaran::where('status', 'Disetujui')
                ->where('user_id', $user->id)
                ->get();

        return view('user.V_DaftarUlang', compact('data'));
    }

    public function simpanDaftarUlang(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $request->validate([
                'kode' => 'required|exists:pendaftaran,kode',
                'kartu_keluarga' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
                'akta_kelahiran' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            $kkPath = $request->file('kartu_keluarga')->store('uploads/kartu_keluarga', 'public');
            $aktaPath = $request->file('akta_kelahiran')->store('uploads/akta_kelahiran', 'public');

            $pendaftaran = Pendaftaran::where('kode', $request->kode)->first();
            
            $orderId = 'DAFUL-'.$pendaftaran->kode.'-'.time();
            
            $pendaftaran->update([
                'file_kk' => $kkPath,
                'file_akta' => $aktaPath,
                'kode_pembayaran' => $orderId,
                'status_pembayaran' => 'pending'
            ]);
            
            // Siapkan parameter untuk Snap
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => 500000,
                ],
                'customer_details' => [
                    'first_name' => $pendaftaran->nama,
                    'email' => $pendaftaran->email,
                    'phone' => $pendaftaran->no_hp ?? '',
                ],
                'item_details' => [
                    [
                        'id' => 'DAFTAR-ULANG',
                        'price' => 500000,
                        'quantity' => 1,
                        'name' => 'Biaya Daftar Ulang '.$pendaftaran->nama
                    ]
                ]
            ];

            // Generate Snap Token
            $snapToken = Snap::getSnapToken($params);

            DB::commit();

            // Kembalikan response dengan Snap Token
            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'order_id' => $orderId
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memproses: '.$e->getMessage()
            ], 500);
        }
    }

    // Fungsi untuk update status setelah pembayaran (dipanggil manual dari frontend)
    public function confirmPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:pendaftaran,kode_pembayaran'
        ]);

        $pendaftaran = Pendaftaran::where('kode_pembayaran', $request->order_id)->first();
        $pendaftaran->update([
            'status_pembayaran' => 'success',
            'status' => 'Disetujui'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status pembayaran berhasil diupdate'
        ]);
    }
}