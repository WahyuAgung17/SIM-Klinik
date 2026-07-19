<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Exception;

class TagihanController extends Controller
{
    // 1. Menampilkan Halaman Dashboard (Dinamis Berdasarkan Data Klinik)
    public function dashboard()
    {
        // Menghitung total pendapatan uang masuk dari tagihan yang lunas
        $totalPendapatan = Tagihan::where('status_pembayaran', 'Berhasil Dibayar')->sum('total_tagihan');
        
        // Menghitung jumlah transaksi berdasarkan status bayar
        $lunas = Tagihan::where('status_pembayaran', 'Berhasil Dibayar')->count();
        $belumLunas = Tagihan::whereIn('status_pembayaran', ['Belum Dibayar', 'Menunggu Pembayaran'])->count();
        
        // Menghitung jumlah total pasien yang terdaftar di basis data
        $totalPasien = \App\Models\Pasien::count();

        return view('dashboard', compact('totalPendapatan', 'lunas', 'belumLunas', 'totalPasien'));
    }

    // 2. Menampilkan Halaman Daftar Tagihan
    public function index()
    {
        // Mengambil semua data tagihan beserta relasi kunjungan dan pasien
        $listTagihan = Tagihan::with('kunjungan.pasien')->orderBy('created_at', 'desc')->get();
        
        // Mengambil daftar kunjungan yang belum memiliki tagihan
        $dataKunjungan = \App\Models\Kunjungan::with('pasien')->get(); 

        return view('payment', compact('listTagihan', 'dataKunjungan'));
    }

    // 3. Menyimpan Tagihan Baru
    public function simpan(Request $request)
    {
        $request->validate([
            'kunjungan_id' => 'required',
            'amount' => 'required|numeric'
        ]);

        Tagihan::create([
            'no_tagihan' => 'TRX-' . strtoupper(uniqid()),
            'kunjungan_id' => $request->kunjungan_id,
            'total_tagihan' => $request->amount,
            'status_pembayaran' => 'Belum Dibayar',
            'tanggal_tagihan' => now(),
        ]);

        return redirect()->back()->with('success', 'Tagihan berhasil dibuat!');
    }

    // 4. Meminta Token Pembayaran ke API Midtrans
    public function bayar($id)
    {
        $tagihan = Tagihan::findOrFail($id);

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = 'PAY-' . $tagihan->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $tagihan->total_tagihan,
            ],
            'customer_details' => [
                'first_name' => $tagihan->kunjungan->pasien->nama_pasien ?? 'Pasien Klinik',
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            $tagihan->update([
                'midtrans_order_id' => $orderId,
                'snap_token' => $snapToken
            ]);

            return redirect()->back()->with('snapToken', $snapToken);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Midtrans Error: ' . $e->getMessage());
        }
    }

    // 5. Notifikasi/Callback respon Midtrans
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.serverKey');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            $tagihan = Tagihan::where('midtrans_order_id', $request->order_id)->first();
            
            if ($tagihan) {
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $tagihan->update(['status_pembayaran' => 'Berhasil Dibayar', 'tanggal_bayar' => now()]);
                } elseif ($request->transaction_status == 'pending') {
                    $tagihan->update(['status_pembayaran' => 'Menunggu Pembayaran']);
                } elseif (in_array($request->transaction_status, ['deny', 'cancel', 'expire'])) {
                    $tagihan->update(['status_pembayaran' => ($request->transaction_status == 'expire' ? 'Kadaluarsa' : 'Gagal')]);
                }
            }
        }
        return response()->json(['message' => 'Callback berhasil diproses']);
    }

    // 6. Cetak Bukti Invoice ke PDF (Memicu window.print)
    public function cetakInvoice($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        return view('invoice-pdf', compact('tagihan'));
    }
    
    // 7. Cek Status Pembayaran Manual via API Midtrans
    public function cekStatus(string $id)
    {
        $tagihan = Tagihan::findOrFail($id);

        if (!$tagihan->midtrans_order_id) {
            return redirect()->back()->with('error', 'Transaksi ini belum pernah dikirim ke Midtrans.');
        }

        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');

        try {
            $status = (object) \Midtrans\Transaction::status($tagihan->midtrans_order_id);
            if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                $tagihan->update([
                    'status_pembayaran' => 'Berhasil Dibayar',
                    'tanggal_bayar' => now(),
                    'metode_pembayaran' => $status->payment_type ?? 'Midtrans'
                ]);
                return redirect()->back()->with('success', 'Pembayaran Terverifikasi! Status berhasil diperbarui menjadi Berhasil Dibayar.');
            } elseif ($status->transaction_status == 'pending') {
                $tagihan->update(['status_pembayaran' => 'Menunggu Pembayaran']);
                return redirect()->back()->with('info', 'Transaksi masih pending. Pasien belum menyelesaikan pembayaran.');
            } elseif (in_array($status->transaction_status, ['deny', 'cancel', 'expire'])) {
                $statusBaru = ($status->transaction_status == 'expire') ? 'Kadaluarsa' : 'Gagal';
                $tagihan->update(['status_pembayaran' => $statusBaru]);
                return redirect()->back()->with('error', 'Transaksi ' . $statusBaru . ' di Midtrans.');
            }

            return redirect()->back()->with('info', 'Status saat ini: ' . $status->transaction_status);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengecek status ke Midtrans: ' . $e->getMessage());
        }
    }

    // 8. Halaman Riwayat Pembayaran (Arsip Data Lunas)
    public function riwayat()
    {
        $listTagihan = Tagihan::with('kunjungan.pasien')
            ->where('status_pembayaran', 'Berhasil Dibayar')
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        return view('riwayat', compact('listTagihan'));
    }

    // 9. Halaman Detail Transaksi Pasien (Tempat Melakukan Aksi Bayar/Cek Status)
    public function detail($id)
    {
        $tagihan = Tagihan::with('kunjungan.pasien')->findOrFail($id);
        return view('detail-tagihan', compact('tagihan'));
    }

    // 10. Halaman Tampilan Invoice Klinik (Disertai Fitur QR Code)
    public function lihatInvoice($id)
    {
        $tagihan = Tagihan::with('kunjungan.pasien')->findOrFail($id);
        return view('invoice-klinik', compact('tagihan'));
    }
}