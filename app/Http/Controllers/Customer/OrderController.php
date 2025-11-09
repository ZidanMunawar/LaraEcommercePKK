<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class OrderController extends Controller
{
    /**
     * Menampilkan halaman orders customer
     */
    public function index()
    {
        $customerId = Auth::guard('customer')->id();

        $orders = Transaksi::with(['details.produk.images', 'details.size', 'details.color'])
            ->where('id_customers', $customerId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.pages.orders', compact('orders'));
    }

    /**
     * Menampilkan detail order
     */
    public function show($id)
    {
        $customerId = Auth::guard('customer')->id();

        $order = Transaksi::with([
            'details.produk.images',
            'details.size',
            'details.color',
            'customer'
        ])
            ->where('id_customers', $customerId)
            ->where('id_transaksi', $id)
            ->firstOrFail();

        return view('customer.pages.order-detail', compact('order'));
    }

    /**
     * Cancel order
     */
    public function cancel(Request $request, $id)
    {
        $customerId = Auth::guard('customer')->id();

        $order = Transaksi::where('id_customers', $customerId)
            ->where('id_transaksi', $id)
            ->firstOrFail();

        // Hanya bisa cancel order yang masih pending/unpaid
        if (!in_array($order->payment_status, ['pending', 'unpaid'])) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa membatalkan order dengan status ' . $order->payment_status
            ], 400);
        }

        $order->update([
            'payment_status' => 'cancelled',
            'cancelled_at' => now(),
            'cancel_reason' => $request->reason
        ]);

        // Kembalikan stok produk
        foreach ($order->details as $detail) {
            $product = $detail->produk;
            $product->increment('quantity', $detail->qty);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil dibatalkan'
        ]);
    }

    /**
     * Upload payment proof dari order detail
     */
    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $customerId = Auth::guard('customer')->id();

        $order = Transaksi::where('id_customers', $customerId)
            ->where('id_transaksi', $id)
            ->firstOrFail();

        // Upload file tanpa hapus yang lama (simplified)
        if ($request->hasFile('payment_proof')) {
            $filePath = $request->file('payment_proof')->store('payment-proofs', 'public');

            $order->update([
                'payment_proof' => $filePath,
                'payment_proof_uploaded_at' => now()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bukti pembayaran berhasil diupload'
        ]);
    }

    /**
     * Generate PDF Invoice
     */
    public function downloadInvoice($id)
    {
        $customerId = Auth::guard('customer')->id();

        $order = Transaksi::with([
            'details.produk',
            'details.size',
            'details.color',
            'customer'
        ])
            ->where('id_customers', $customerId)
            ->where('id_transaksi', $id)
            ->firstOrFail();

        $pdf = Pdf::loadView('customer.pdf.invoice', compact('order'));

        return $pdf->download('invoice-' . $order->Transaksi_id . '.pdf');
    }

    /**
     * Filter orders by status
     */
    public function filter(Request $request)
    {
        $customerId = Auth::guard('customer')->id();
        $status = $request->get('status');

        $query = Transaksi::with(['details.produk.images'])
            ->where('id_customers', $customerId);

        if ($status && $status !== 'all') {
            $query->where('payment_status', $status);
        }

        $orders = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        // Return view langsung (tidak partial)
        return view('customer.pages.orders', compact('orders'));
    }
}
