<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTagihanRequest;
use App\Models\Mahasiswa;
use App\Models\Tagihan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Throwable;

class PaymentController extends Controller
{
    public function tagihan(): View
    {
        return view('payment', [
            'data' => Mahasiswa::query()->orderBy('nama')->get(),
            'listTagihan' => Tagihan::query()
                ->with('mahasiswa')
                ->latest()
                ->get(),
            'midtransClientKey' => config('midtrans.clientKey'),
        ]);
    }

    public function simpan(CreateTagihanRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Tagihan::create([
            'nim' => $validated['student_id'],
            'periode' => $validated['semester'],
            'total_tagihan' => $validated['amount'],
            'status_bayar' => 'Belum Lunas',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Tagihan berhasil dibuat.');
    }

    public function pay(int $billId): RedirectResponse
    {
        return redirect()
            ->route('tagihan.index')
            ->with('info', 'Pilih tombol Bayar pada tagihan yang ingin dibayar.');
    }

    public function bayar(int $id): RedirectResponse
    {
        $tagihan = Tagihan::query()->with('mahasiswa')->findOrFail($id);

        if ($tagihan->status_bayar === 'Lunas') {
            return redirect()->back()->with('info', 'Tagihan ini sudah lunas.');
        }

        if (! $this->hasMidtransKeys()) {
            return redirect()->back()->with('error', 'MIDTRANS_SERVER_KEY dan MIDTRANS_CLIENT_KEY belum diisi di file .env.');
        }

        $this->configureMidtrans();

        $orderId = 'PAY-'.$tagihan->id.'-'.time();
        $amount = (int) $tagihan->total_tagihan;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $tagihan->mahasiswa?->nama ?? 'Mahasiswa',
                'email' => 'mahasiswa'.$tagihan->nim.'@example.test',
            ],
            'item_details' => [
                [
                    'id' => 'TAGIHAN-'.$tagihan->id,
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => 'Tagihan Periode '.$tagihan->periode,
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            $tagihan->update([
                'order_id' => $orderId,
                'snap_token' => $snapToken,
                'status_bayar' => 'Pending',
            ]);

            return redirect()
                ->back()
                ->with('success', 'Token pembayaran berhasil dibuat.')
                ->with('snapToken', $snapToken)
                ->with('paymentTagihanId', $tagihan->id);
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal membuat transaksi Midtrans: '.$e->getMessage());
        }
    }

    public function callback(Request $request): JsonResponse
    {
        $serverKey = config('midtrans.serverKey');

        if (! $serverKey) {
            return response()->json(['message' => 'Midtrans server key is not configured'], 500);
        }

        $signature = hash(
            'sha512',
            $request->input('order_id').
            $request->input('status_code').
            $request->input('gross_amount').
            $serverKey
        );

        if (! hash_equals($signature, (string) $request->input('signature_key'))) {
            return response()->json(['message' => 'Invalid Signature'], 403);
        }

        $tagihan = Tagihan::query()
            ->where('order_id', $request->input('order_id'))
            ->first();

        if (! $tagihan) {
            return response()->json(['message' => 'Tagihan not found'], 404);
        }

        $this->syncTagihanStatus($tagihan, (string) $request->input('transaction_status'));

        return response()->json(['message' => 'Callback Success']);
    }

    public function cekStatus(int $id): RedirectResponse
    {
        $tagihan = Tagihan::query()->findOrFail($id);

        if (! $tagihan->order_id) {
            return redirect()
                ->back()
                ->with('info', 'Tagihan belum memiliki order ID Midtrans. Klik Bayar terlebih dahulu.');
        }

        if (! $this->hasMidtransKeys()) {
            return redirect()
                ->back()
                ->with('error', 'MIDTRANS_SERVER_KEY dan MIDTRANS_CLIENT_KEY belum diisi di file .env.');
        }

        $this->configureMidtrans();

        try {
            $status = Transaction::status($tagihan->order_id);
            $transactionStatus = (string) ($status->transaction_status ?? '');
            $this->syncTagihanStatus($tagihan, $transactionStatus);

            return redirect()
                ->back()
                ->with('success', 'Status pembayaran saat ini: '.$tagihan->fresh()->status_bayar.'.');
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengecek status Midtrans: '.$e->getMessage());
        }
    }

    /*
|--------------------------------------------------------------------------
| FITUR SIKEU
|--------------------------------------------------------------------------
*/

/**
 * Halaman Detail Tagihan
 */
public function detail(int $id): View
{
    $tagihan = Tagihan::with('mahasiswa')->findOrFail($id);

    return view('detail-tagihan', [
        'tagihan' => $tagihan,
    ]);
}

/**
 * Halaman Invoice
 */
public function invoice(int $id): View
{
    $tagihan = Tagihan::with('mahasiswa')->findOrFail($id);

    return view('invoice', [
        'tagihan' => $tagihan,
    ]);
}

/**
 * Cetak Invoice PDF
 */
public function cetak(int $id)
{
    $tagihan = Tagihan::with('mahasiswa')->findOrFail($id);

    $pdf = Pdf::loadView('invoice-pdf', [
        'tagihan' => $tagihan,
    ]);

    return $pdf->download('Invoice-'.$tagihan->id.'.pdf');
}

/**
 * Riwayat Pembayaran
 */
public function riwayat(): View
{
    $listTagihan = Tagihan::query()
        ->with('mahasiswa')
        ->where('status_bayar', 'Lunas')
        ->latest()
        ->paginate(10);

    return view('riwayat', [
        'listTagihan' => $listTagihan,
    ]);
}

/**
 * Form Edit Tagihan
 */
public function edit(int $id): View
{
    $tagihan = Tagihan::findOrFail($id);

    return view('edit-tagihan', [
        'tagihan' => $tagihan,
        'data' => Mahasiswa::orderBy('nama')->get(),
    ]);
}

/**
 * Update Tagihan
 */
public function update(Request $request, int $id): RedirectResponse
{
    $request->validate([
    'student_id' => 'required|exists:mahasiswa,id',
    'semester' => 'required|string|max:100',
    'amount' => 'required|numeric|min:1000',
]);

    $tagihan = Tagihan::findOrFail($id);

    $tagihan->update([
        'nim' => $request->student_id,
        'periode' => $request->semester,
        'total_tagihan' => $request->amount,
    ]);

    return redirect()
        ->route('tagihan.index')
        ->with('success', 'Tagihan berhasil diperbarui.');
}

/**
 * Hapus Tagihan
 */
public function destroy(int $id): RedirectResponse
{
    $tagihan = Tagihan::findOrFail($id);

    $tagihan->delete();

    return redirect()
        ->route('tagihan.index')
        ->with('success', 'Tagihan berhasil dihapus.');
}
    /*
    |--------------------------------------------------------------------------
    | PRIVATE FUNCTION
    |--------------------------------------------------------------------------
    */

    private function configureMidtrans(): void
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = (bool) config('midtrans.isProduction');
        Config::$isSanitized = (bool) config('midtrans.isSanitized');
        Config::$is3ds = (bool) config('midtrans.is3ds');
    }

    private function hasMidtransKeys(): bool
    {
        return (bool) config('midtrans.serverKey') && (bool) config('midtrans.clientKey');
    }

    private function syncTagihanStatus(Tagihan $tagihan, string $transactionStatus): void
    {
        $data = match ($transactionStatus) {
            'settlement', 'capture' => [
                'status_bayar' => 'Lunas',
                'paid_at' => Carbon::now(),
            ],
            'pending' => [
                'status_bayar' => 'Pending',
            ],
            'deny', 'expire', 'cancel', 'failure' => [
                'status_bayar' => 'Gagal',
            ],
            default => [],
        };

        if ($data !== []) {
            $tagihan->update($data);
        }
    }
}