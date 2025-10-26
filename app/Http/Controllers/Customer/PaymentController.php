<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    // ✅ TAMBAH METHOD INI: Halaman upload
    public function showUploadPage($id)
    {
        $transaction = Transaksi::with([
            'customer',
            'shippingMethod',
            'details.produk.images',
            'details.size',
            'details.color'
        ])->where('id_transaksi', $id)
            ->where('id_customers', Auth::guard('customer')->id())
            ->firstOrFail();

        // Kalau udah upload, redirect ke success page
        if ($transaction->payment_proof) {
            return redirect()->route('customer.checkout.success', $id);
        }

        return view('customer.pages.payment-upload', compact('transaction'));
    }

    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $transaction = Transaksi::where('id_transaksi', $id)
            ->where('id_customers', Auth::guard('customer')->id())
            ->firstOrFail();

        if ($transaction->payment_status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Payment proof can only be uploaded for pending payments'
            ], 400);
        }

        try {
            // Delete old proof if exists
            if ($transaction->payment_proof) {
                Storage::disk('public')->delete($transaction->payment_proof);
            }

            // Upload new proof
            $file = $request->file('payment_proof');
            $filename = 'payment-' . $transaction->transaction_id . '-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payment-proof', $filename, 'public');

            // Update transaction
            $transaction->update([
                'payment_proof' => $path,
                'payment_proof_uploaded_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment proof uploaded successfully',
                'redirect_url' => route('customer.checkout.success', $id)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload: ' . $e->getMessage()
            ], 500);
        }
    }
}
