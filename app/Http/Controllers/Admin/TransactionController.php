<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Customer;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['customer', 'shippingMethod', 'details', 'approvedBy'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id_transaksi', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%")
                    ->orWhere('resi_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $transactions = $query->paginate(20);
        $shippingMethods = ShippingMethod::where('is_active', 1)->get();

        return view('admin.pages.transactions', compact('transactions', 'shippingMethods'));
    }

    public function show($id)
    {
        try {
            $transaction = Transaksi::with([
                'customer',
                'shippingMethod',
                'details.produk',
                'details.size',
                'details.color',
                'approvedBy',
                'paymentLogs'
            ])->findOrFail($id);

            // Format data untuk modal
            $data = [
                'id_transaksi' => $transaction->id_transaksi,
                'transaction_id' => $transaction->transaction_id,
                'status' => $transaction->status,
                'payment_status' => $transaction->payment_status,
                'metode_pembayaran' => $transaction->metode_pembayaran,
                'total_amount' => $transaction->total_amount,
                'subtotal' => $transaction->subtotal,
                'discount_amount' => $transaction->discount_amount,
                'shipping_cost' => $transaction->shipping_cost,
                'resi_number' => $transaction->resi_number,
                'payment_proof' => $transaction->payment_proof,
                'payment_proof_uploaded_at' => $transaction->payment_proof_uploaded_at,
                'paid_at' => $transaction->paid_at,
                'created_at' => $transaction->created_at,
                'catatan' => $transaction->catatan,

                // Customer info
                'customer' => [
                    'id_customers' => $transaction->customer->id_customers ?? null,
                    'nama_lengkap' => $transaction->customer->nama_lengkap ?? '-',
                    'email' => $transaction->customer->email ?? '-',
                    'no_telp' => $transaction->customer->no_telp ?? '-',
                ],

                // Shipping info - dari tabel transaksi langsung
                'shipping_name' => $transaction->shipping_name,
                'shipping_phone' => $transaction->shipping_phone,
                'shipping_address' => $transaction->shipping_address,
                'shipping_village_name' => $transaction->shipping_village_name,
                'shipping_district_name' => $transaction->shipping_district_name,
                'shipping_regency_name' => $transaction->shipping_regency_name,
                'shipping_province_name' => $transaction->shipping_province_name,
                'shipping_postal_code' => $transaction->shipping_postal_code,

                // Shipping method
                'shipping_method' => [
                    'id' => $transaction->shippingMethod->id ?? null,
                    'name' => $transaction->shippingMethod->name ?? '-',
                ],

                // Order items
                'details' => $transaction->details->map(function ($detail) {
                    return [
                        'id' => $detail->id_detail,
                        'product_name' => $detail->produk->name ?? '-',
                        'variant_name' => ($detail->size ? 'Size: ' . $detail->size->size : '') .
                            ($detail->color ? ' | Color: ' . $detail->color->name : ''),
                        'size' => $detail->size ? ['id' => $detail->size->id, 'size' => $detail->size->size] : null,
                        'color' => $detail->color ? ['id' => $detail->color->id, 'name' => $detail->color->name] : null,
                        'harga' => $detail->harga,
                        'qty' => $detail->qty,
                        'diskon' => $detail->diskon ?? 0,
                        'subtotal' => ($detail->harga * $detail->qty) - ($detail->diskon ?? 0),
                    ];
                })->toArray(),

                // Approved by
                'approved_by_name' => $transaction->approvedBy->nama_lengkap ?? null,
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        try {
            $transaction = Transaksi::findOrFail($id);

            // Only admin/owner can update
            $admin = Auth::guard('admin')->user();
            if (!in_array($admin->role, ['admin', 'owner'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action'
                ], 403);
            }

            $oldStatus = $transaction->status;
            $transaction->status = $request->status;

            // Auto approve if processing
            if ($request->status == 'processing' && !$transaction->approved_by) {
                $transaction->approved_by = $admin->id_admin;
            }

            $transaction->save();

            // TODO: Send notification to customer

            return response()->json([
                'success' => true,
                'message' => 'Transaction status updated successfully',
                'old_status' => $oldStatus,
                'new_status' => $transaction->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded'
        ]);

        try {
            $transaction = Transaksi::findOrFail($id);

            $oldPaymentStatus = $transaction->payment_status;
            $transaction->payment_status = $request->payment_status;

            if ($request->payment_status == 'paid' && !$transaction->paid_at) {
                $transaction->paid_at = now();
            }

            $transaction->save();

            return response()->json([
                'success' => true,
                'message' => 'Payment status updated successfully',
                'old_status' => $oldPaymentStatus,
                'new_status' => $transaction->payment_status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update payment status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateResi(Request $request, $id)
    {
        $request->validate([
            'resi_number' => 'required|string|max:100'
        ]);

        try {
            $transaction = Transaksi::findOrFail($id);
            $transaction->resi_number = $request->resi_number;

            // Auto change status to shipped
            if ($transaction->status == 'processing') {
                $transaction->status = 'shipped';
            }

            $transaction->save();

            // TODO: Send notification to customer with resi number

            return response()->json([
                'success' => true,
                'message' => 'Resi number updated successfully',
                'resi_number' => $transaction->resi_number,
                'status' => $transaction->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update resi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verifyPayment(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'reject_reason' => 'nullable|string|max:255' // UBAH dari required_if jadi nullable
        ]);

        try {
            $transaction = Transaksi::with('details.produk')->findOrFail($id);

            // Only admin/owner can verify
            $admin = Auth::guard('admin')->user();
            if (!in_array($admin->role, ['admin', 'owner'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action'
                ], 403);
            }

            // Check if payment proof exists
            if (!$transaction->payment_proof) {
                return response()->json([
                    'success' => false,
                    'message' => 'No payment proof uploaded yet'
                ], 400);
            }

            if ($request->action === 'approve') {
                $transaction->update([
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                    'status' => 'processing',
                    'approved_by' => $admin->id_admin
                ]);

                $message = 'Payment approved successfully';
            } else {
                // Reject
                $rejectReason = $request->reject_reason ?: 'No reason provided';

                $transaction->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled',
                    'catatan' => ($transaction->catatan ? $transaction->catatan . "\n\n" : '') .
                        "Payment rejected: " . $rejectReason
                ]);

                // Return stock
                foreach ($transaction->details as $detail) {
                    if ($detail->produk) {
                        $detail->produk->increment('quantity', $detail->qty);
                    }
                }

                $message = 'Payment rejected and stock returned';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'payment_status' => $transaction->payment_status,
                'status' => $transaction->status
            ]);

        } catch (\Exception $e) {
            \Log::error('Payment verification error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment verification: ' . $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $transaction = Transaksi::findOrFail($id);

            // Only allow delete if cancelled or very old pending
            if (!in_array($transaction->status, ['cancelled'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Can only delete cancelled transactions'
                ], 403);
            }

            $transaction->delete();

            return response()->json([
                'success' => true,
                'message' => 'Transaction deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete transaction: ' . $e->getMessage()
            ], 500);
        }
    }

    public function export(Request $request)
    {
        try {
            // Get filters from request
            $query = Transaksi::with(['customer', 'details.produk'])
                ->orderBy('created_at', 'desc');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('payment_status')) {
                $query->where('payment_status', $request->payment_status);
            }

            $transactions = $query->get();

            // Create CSV
            $filename = 'transactions_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');

            // Set headers for download
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            // CSV Headers
            fputcsv($handle, [
                'Order ID',
                'Transaction ID',
                'Customer Name',
                'Customer Email',
                'Phone',
                'Total Amount',
                'Payment Method',
                'Payment Status',
                'Order Status',
                'Resi Number',
                'Order Date'
            ]);

            // Data rows
            foreach ($transactions as $transaction) {
                fputcsv($handle, [
                    str_pad($transaction->id_transaksi, 6, '0', STR_PAD_LEFT),
                    $transaction->transaction_id,
                    $transaction->customer->nama_lengkap ?? 'N/A',
                    $transaction->customer->email ?? 'N/A',
                    $transaction->customer->no_telp ?? 'N/A',
                    number_format($transaction->total_amount, 0, ',', '.'),
                    strtoupper(str_replace('_', ' ', $transaction->metode_pembayaran)),
                    ucfirst($transaction->payment_status),
                    ucfirst($transaction->status),
                    $transaction->resi_number ?? 'Not available',
                    $transaction->created_at->format('d M Y H:i')
                ]);
            }

            fclose($handle);
            exit;

        } catch (\Exception $e) {
            \Log::error('Export error: ' . $e->getMessage());

            return back()->with('error', 'Failed to export: ' . $e->getMessage());
        }
    }


    public function statistics(Request $request)
    {
        try {
            $stats = [
                'total' => Transaksi::count(),
                'pending' => Transaksi::where('status', 'pending')->count(),
                'processing' => Transaksi::where('status', 'processing')->count(),
                'shipped' => Transaksi::where('status', 'shipped')->count(),
                'completed' => Transaksi::where('status', 'completed')->count(),
                'cancelled' => Transaksi::where('status', 'cancelled')->count(),
                'total_revenue' => Transaksi::where('payment_status', 'paid')->sum('total_amount'),
                'pending_payment' => Transaksi::where('payment_status', 'pending')->sum('total_amount'),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get statistics: ' . $e->getMessage()
            ], 500);
        }
    }
}
