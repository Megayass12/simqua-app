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

            // Upload files
            $kkPath = $request->file('kartu_keluarga')->store('uploads/kartu_keluarga', 'public');
            $aktaPath = $request->file('akta_kelahiran')->store('uploads/akta_kelahiran', 'public');

            // Get pendaftaran record
            $pendaftaran = Pendaftaran::where('kode', $request->kode)->first();

            if (!$pendaftaran) {
                throw new \Exception('Data pendaftaran tidak ditemukan');
            }

            // Generate order ID
            $orderId = 'DAFUL-' . $pendaftaran->kode . '-' . time();
            $pendaftaran->update([
                'kode_pembayaran' => $orderId,
            ]);

            // Update pendaftaran dengan file dan kode pembayaran
            $updateResult = $pendaftaran->update([
                'file_kk' => $kkPath,
                'file_akta' => $aktaPath,
                'kode_pembayaran' => $orderId,
                'status_pembayaran' => 'Belum Dibayar'
            ]);

            if (!$updateResult) {
                throw new \Exception('Gagal menyimpan data ke database');
            }

            // Siapkan parameter untuk Snap
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => 500000,
                ],
                'customer_details' => [
                    'first_name' => $pendaftaran->nama,
                    'email' => $pendaftaran->email ?? auth()->user()->email,
                    'phone' => $pendaftaran->no_hp ?? '',
                ],
                'item_details' => [
                    [
                        'id' => 'DAFTAR-ULANG',
                        'price' => 500000,
                        'quantity' => 1,
                        'name' => 'Biaya Daftar Ulang ' . $pendaftaran->nama
                    ]
                ]
            ];

            // Generate Snap Token
            $snapToken = Snap::getSnapToken($params);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'message' => 'Data berhasil disimpan dan token pembayaran berhasil dibuat'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memproses: ' . $e->getMessage()
            ], 500);
        }
    }

    public function confirmPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:pendaftaran,kode_pembayaran'
        ]);

        try {
            $pendaftaran = Pendaftaran::where('kode_pembayaran', $request->order_id)->first();

            if (!$pendaftaran) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data pembayaran tidak ditemukan'
                ], 404);
            }

            $pendaftaran->update([
                'status_pembayaran' => 'Lunas'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Status pembayaran berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengupdate pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verifikasiIndex()
    {
        $data = Pendaftaran::where('status', 'Disetujui')
            ->whereNotNull('file_kk')
            ->whereNotNull('file_akta')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.V_VerifDaful', compact('data'));
    }

    public function updateStatusPembayaran(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Belum Dibayar,Lunas'
        ]);

        DB::beginTransaction();
        try {
            $pendaftaran = Pendaftaran::findOrFail($id);

            $pendaftaran->update([
                'status_pembayaran' => $request->status
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Status berhasil diupdate",
                'data' => [
                    'status_pembayaran' => $pendaftaran->status_pembayaran,
                    'kode_pembayaran' => $pendaftaran->kode_pembayaran
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate status: ' . $e->getMessage()
            ], 500);
        }
    }
}
