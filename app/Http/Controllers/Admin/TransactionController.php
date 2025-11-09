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
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Menampilkan halaman daftar transaksi
     */
    public function index(Request $request)
    {
        // Query transaksi dengan relasi
        $query = Transaksi::with(['customer', 'shippingMethod', 'details', 'approvedBy'])
            ->orderBy('created_at', 'desc');

        // Filter status pesanan
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter status pembayaran
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search (ID, nama, email, resi)
        if ($request->filled('search')) {
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

        $transactions = $query->paginate(20)->withQueryString();
        $shippingMethods = ShippingMethod::where('is_active', 1)->get();

        return view('admin.pages.transactions', compact('transactions', 'shippingMethods'));
    }

    /**
     * Menampilkan detail transaksi (untuk modal)
     */
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

            // Format data untuk frontend
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

                // Info customer
                'customer' => [
                    'id_customers' => $transaction->customer->id_customers ?? null,
                    'nama_lengkap' => $transaction->customer->nama_lengkap ?? '-',
                    'email' => $transaction->customer->email ?? '-',
                    'no_telp' => $transaction->customer->no_telp ?? '-',
                ],

                // Info pengiriman (dari tabel transaksi)
                'shipping_name' => $transaction->shipping_name,
                'shipping_phone' => $transaction->shipping_phone,
                'shipping_address' => $transaction->shipping_address,
                'shipping_village_name' => $transaction->shipping_village_name,
                'shipping_district_name' => $transaction->shipping_district_name,
                'shipping_regency_name' => $transaction->shipping_regency_name,
                'shipping_province_name' => $transaction->shipping_province_name,
                'shipping_postal_code' => $transaction->shipping_postal_code,

                // Metode pengiriman
                'shipping_method' => [
                    'id' => $transaction->shippingMethod->id ?? null,
                    'name' => $transaction->shippingMethod->name ?? '-',
                ],

                // Item pesanan - PERBAIKAN: Hitung diskon dengan benar
                'details' => $transaction->details->map(function ($detail) {
                    $harga = floatval($detail->harga);
                    $qty = intval($detail->qty);
                    $diskon = floatval($detail->diskon ?? 0);

                    // Hitung subtotal dengan diskon yang benar
                    $subtotal = ($harga * $qty) - $diskon;

                    return [
                        'id' => $detail->id_detail,
                        'product_name' => $detail->produk->name ?? '-',
                        'variant_name' => ($detail->size ? 'Size: ' . $detail->size->size : '') .
                            ($detail->color ? ' | Color: ' . $detail->color->name : ''),
                        'size' => $detail->size ? ['id' => $detail->size->id, 'size' => $detail->size->size] : null,
                        'color' => $detail->color ? ['id' => $detail->color->id, 'name' => $detail->color->name] : null,
                        'harga' => $harga,
                        'qty' => $qty,
                        'diskon' => $diskon,
                        'subtotal' => $subtotal,
                    ];
                })->toArray(),

                // Disetujui oleh - TAMBAH INFO ADMIN YANG APPROVE
                'approved_by_name' => $transaction->approvedBy->nama_lengkap ?? null,
                'approved_by_role' => $transaction->approvedBy->role ?? null,
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update status pesanan - PERBAIKAN: AUTO RESTOCK ON CANCEL
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        try {
            DB::beginTransaction();

            $transaction = Transaksi::with('details.produk')->findOrFail($id);
            $admin = Auth::guard('admin')->user();

            // PERBAIKAN: Petugas juga boleh update status
            if (!in_array($admin->role, ['admin', 'owner', 'petugas'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk melakukan tindakan ini'
                ], 403);
            }

            $oldStatus = $transaction->status;
            $newStatus = $request->status;

            // ==========================================
            // LOGIKA AUTO RESTOCK & UPDATE STOK
            // ==========================================

            // Jika status berubah dari SELAIN cancelled MENJADI cancelled
            if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
                // KEMBALIKAN STOK - Transaksi dibatalkan
                $this->restockProducts($transaction);
                $message = 'Status pesanan berhasil dibatalkan dan stok produk dikembalikan!';

                // Tambah catatan pembatalan
                $transaction->catatan = ($transaction->catatan ? $transaction->catatan . "\n\n" : '') .
                    "Pesanan dibatalkan oleh " . $admin->nama_lengkap . " pada " . now()->format('d/m/Y H:i') .
                    ". Stok produk telah dikembalikan.";
            }
            // Jika status berubah dari cancelled MENJADI SELAIN cancelled
            elseif ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                // KURANGI STOK LAGI - Transaksi diaktifkan kembali
                $this->deductStock($transaction);
                $message = 'Status pesanan berhasil diaktifkan dan stok produk dikurangi!';

                // Tambah catatan aktivasi
                $transaction->catatan = ($transaction->catatan ? $transaction->catatan . "\n\n" : '') .
                    "Pesanan diaktifkan kembali oleh " . $admin->nama_lengkap . " pada " . now()->format('d/m/Y H:i') .
                    ". Stok produk telah dikurangi.";
            }
            // Jika status berubah tapi bukan cancelled
            else {
                $message = 'Status pesanan berhasil diperbarui!';
            }

            $transaction->status = $newStatus;

            // Auto approve jika status jadi "processing" dan belum ada yang approve
            if ($newStatus == 'processing' && !$transaction->approved_by) {
                $transaction->approved_by = $admin->id_admin;

                // Tambah catatan approval
                $transaction->catatan = ($transaction->catatan ? $transaction->catatan . "\n\n" : '') .
                    "Pesanan disetujui oleh " . $admin->nama_lengkap . " pada " . now()->format('d/m/Y H:i');
            }

            $transaction->save();

            DB::commit();

            // Log activity
            \Log::info("Status transaksi {$transaction->id_transaksi} diubah dari {$oldStatus} ke {$newStatus} oleh {$admin->nama_lengkap}");

            return response()->json([
                'success' => true,
                'message' => $message,
                'old_status' => $oldStatus,
                'new_status' => $transaction->status,
                'approved_by' => $transaction->approvedBy->nama_lengkap ?? null
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error update status transaksi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Kembalikan stok produk ketika transaksi dibatalkan
     */
    private function restockProducts($transaction)
    {
        foreach ($transaction->details as $detail) {
            if ($detail->produk) {
                $produk = $detail->produk;
                $oldStock = $produk->quantity;
                $produk->quantity += $detail->qty; // Tambah stok kembali
                $produk->save();

                \Log::info("Stok dikembalikan: Produk {$produk->name} ({$produk->id_produk}) dari {$oldStock} menjadi {$produk->quantity} (+{$detail->qty}) - Transaksi {$transaction->id_transaksi}");
            }
        }
    }

    /**
     * Kurangi stok produk ketika transaksi diaktifkan kembali dari cancelled
     */
    private function deductStock($transaction)
    {
        foreach ($transaction->details as $detail) {
            if ($detail->produk) {
                $produk = $detail->produk;
                $oldStock = $produk->quantity;

                // Cek apakah stok cukup
                if ($produk->quantity < $detail->qty) {
                    throw new \Exception("Stok produk {$produk->name} tidak cukup. Stok tersedia: {$produk->quantity}, dibutuhkan: {$detail->qty}");
                }

                $produk->quantity -= $detail->qty; // Kurangi stok
                $produk->save();

                \Log::info("Stok dikurangi: Produk {$produk->name} ({$produk->id_produk}) dari {$oldStock} menjadi {$produk->quantity} (-{$detail->qty}) - Transaksi {$transaction->id_transaksi}");
            }
        }
    }

    /**
     * Update status pembayaran - PERBAIKAN: AUTO RESTOCK ON FAILED/REFUNDED
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded'
        ]);

        try {
            DB::beginTransaction();

            $transaction = Transaksi::with('details.produk')->findOrFail($id);
            $admin = Auth::guard('admin')->user();

            // PERBAIKAN: Petugas juga boleh update payment status
            if (!in_array($admin->role, ['admin', 'owner', 'petugas'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk melakukan tindakan ini'
                ], 403);
            }

            $oldPaymentStatus = $transaction->payment_status;
            $newPaymentStatus = $request->payment_status;

            // ==========================================
            // LOGIKA AUTO RESTOCK BERDASARKAN PAYMENT STATUS
            // ==========================================

            // Jika payment status berubah menjadi failed/refunded dari status lain
            if (
                in_array($newPaymentStatus, ['failed', 'refunded']) &&
                !in_array($oldPaymentStatus, ['failed', 'refunded'])
            ) {

                // Auto cancel transaksi dan kembalikan stok
                $transaction->status = 'cancelled';
                $this->restockProducts($transaction);

                // Tambah catatan
                $transaction->catatan = ($transaction->catatan ? $transaction->catatan . "\n\n" : '') .
                    "Pembayaran diubah ke {$newPaymentStatus} oleh " . $admin->nama_lengkap . " pada " . now()->format('d/m/Y H:i') .
                    ". Status pesanan otomatis dibatalkan dan stok dikembalikan.";

                $message = 'Status pembayaran diubah ke ' . $newPaymentStatus . ' dan stok produk dikembalikan!';
            }
            // Jika payment status berubah dari failed/refunded menjadi paid
            elseif (
                in_array($oldPaymentStatus, ['failed', 'refunded']) &&
                $newPaymentStatus === 'paid'
            ) {

                // Kurangi stok kembali
                $this->deductStock($transaction);
                $transaction->status = 'processing';

                // Tambah catatan
                $transaction->catatan = ($transaction->catatan ? $transaction->catatan . "\n\n" : '') .
                    "Pembayaran disetujui oleh " . $admin->nama_lengkap . " pada " . now()->format('d/m/Y H:i') .
                    ". Status pesanan diaktifkan dan stok dikurangi.";

                $message = 'Status pembayaran berhasil diperbarui dan stok produk dikurangi!';
            } else {
                $message = 'Status pembayaran berhasil diperbarui!';

                // Tambah catatan untuk perubahan biasa
                if ($oldPaymentStatus !== $newPaymentStatus) {
                    $transaction->catatan = ($transaction->catatan ? $transaction->catatan . "\n\n" : '') .
                        "Status pembayaran diubah dari {$oldPaymentStatus} ke {$newPaymentStatus} oleh " . $admin->nama_lengkap . " pada " . now()->format('d/m/Y H:i');
                }
            }

            $transaction->payment_status = $newPaymentStatus;

            // Set waktu lunas
            if ($newPaymentStatus == 'paid' && !$transaction->paid_at) {
                $transaction->paid_at = now();
            }

            $transaction->save();

            DB::commit();

            // Log activity
            \Log::info("Payment status transaksi {$transaction->id_transaksi} diubah dari {$oldPaymentStatus} ke {$newPaymentStatus} oleh {$admin->nama_lengkap}");

            return response()->json([
                'success' => true,
                'message' => $message,
                'old_status' => $oldPaymentStatus,
                'new_status' => $transaction->payment_status,
                'order_status' => $transaction->status
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error update payment status: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update nomor resi - PERBAIKAN: ALLOW PETUGAS
     */
    public function updateResi(Request $request, $id)
    {
        $request->validate([
            'resi_number' => 'required|string|max:100'
        ]);

        try {
            DB::beginTransaction();

            $transaction = Transaksi::findOrFail($id);
            $admin = Auth::guard('admin')->user();

            // PERBAIKAN: Petugas juga boleh update resi
            if (!in_array($admin->role, ['admin', 'owner', 'petugas'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk melakukan tindakan ini'
                ], 403);
            }

            $oldResi = $transaction->resi_number;
            $transaction->resi_number = $request->resi_number;

            // Auto change status ke "shipped" jika dari processing
            if ($transaction->status == 'processing') {
                $transaction->status = 'shipped';

                // Tambah catatan
                $transaction->catatan = ($transaction->catatan ? $transaction->catatan . "\n\n" : '') .
                    "Pesanan dikirim dengan resi: {$request->resi_number} oleh " . $admin->nama_lengkap . " pada " . now()->format('d/m/Y H:i');
            } else {
                // Tambah catatan update resi saja
                $transaction->catatan = ($transaction->catatan ? $transaction->catatan . "\n\n" : '') .
                    "No. resi diupdate dari '{$oldResi}' ke '{$request->resi_number}' oleh " . $admin->nama_lengkap . " pada " . now()->format('d/m/Y H:i');
            }

            $transaction->save();

            DB::commit();

            // Log activity
            \Log::info("Resi transaksi {$transaction->id_transaksi} diupdate: {$oldResi} -> {$request->resi_number} oleh {$admin->nama_lengkap}");

            return response()->json([
                'success' => true,
                'message' => 'Nomor resi berhasil ditambahkan!',
                'resi_number' => $transaction->resi_number,
                'status' => $transaction->status
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error update resi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan resi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verifikasi pembayaran - PERBAIKAN: AUTO RESTOCK ON REJECT
     */
    public function verifyPayment(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'reject_reason' => 'nullable|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            $transaction = Transaksi::with('details.produk')->findOrFail($id);
            $admin = Auth::guard('admin')->user();

            // PERBAIKAN: Petugas juga boleh verifikasi pembayaran
            if (!in_array($admin->role, ['admin', 'owner', 'petugas'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses'
                ], 403);
            }

            // Cek bukti pembayaran
            if (!$transaction->payment_proof) {
                return response()->json([
                    'success' => false,
                    'message' => 'Belum ada bukti pembayaran yang diupload'
                ], 400);
            }

            if ($request->action === 'approve') {
                // APPROVE: Set paid + processing
                $transaction->update([
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                    'status' => 'processing',
                    'approved_by' => $admin->id_admin
                ]);

                // Tambah catatan approval
                $transaction->catatan = ($transaction->catatan ? $transaction->catatan . "\n\n" : '') .
                    "Pembayaran disetujui oleh " . $admin->nama_lengkap . " pada " . now()->format('d/m/Y H:i');

                $message = 'Pembayaran berhasil disetujui!';

            } else {
                // REJECT: Set failed + cancelled + return stock
                $rejectReason = $request->reject_reason ?: 'Tidak ada alasan';

                // Kembalikan stok produk
                $this->restockProducts($transaction);

                $transaction->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled',
                    'catatan' => ($transaction->catatan ? $transaction->catatan . "\n\n" : '') .
                        "Pembayaran ditolak oleh " . $admin->nama_lengkap . " pada " . now()->format('d/m/Y H:i') .
                        ". Alasan: " . $rejectReason . " (Stok produk dikembalikan)"
                ]);

                $message = 'Pembayaran ditolak dan stok produk dikembalikan';
            }

            $transaction->save();

            DB::commit();

            // Log activity
            \Log::info("Payment verification {$transaction->id_transaksi}: {$request->action} oleh {$admin->nama_lengkap}");

            return response()->json([
                'success' => true,
                'message' => $message,
                'payment_status' => $transaction->payment_status,
                'status' => $transaction->status,
                'approved_by' => $admin->nama_lengkap
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payment verification error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memverifikasi pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate Invoice PDF
     */
    public function generateInvoice($id)
    {
        try {
            $transaction = Transaksi::with([
                'customer',
                'shippingMethod',
                'details.produk',
                'details.size',
                'details.color',
                'approvedBy'
            ])->findOrFail($id);

            // Format data untuk invoice
            $invoiceData = [
                'invoice_number' => $transaction->transaction_id ?? 'INV-' . str_pad($transaction->id_transaksi, 6, '0', STR_PAD_LEFT),
                'order_number' => $transaction->transaction_id ?? '#' . str_pad($transaction->id_transaksi, 6, '0', STR_PAD_LEFT),
                'order_date' => $transaction->created_at->format('d F Y'),
                'due_date' => $transaction->created_at->addDays(1)->format('d F Y'),

                // Customer info
                'customer' => [
                    'name' => $transaction->customer->nama_lengkap ?? '-',
                    'email' => $transaction->customer->email ?? '-',
                    'phone' => $transaction->shipping_phone ?? $transaction->customer->no_telp ?? '-',
                    'address' => $this->formatAddress($transaction),
                ],

                // Shipping info
                'shipping' => [
                    'method' => $transaction->shippingMethod->name ?? '-',
                    'tracking_number' => $transaction->resi_number ?? 'Belum tersedia',
                    'address' => $this->formatShippingAddress($transaction),
                ],

                // Payment info
                'payment' => [
                    'method' => strtoupper(str_replace('_', ' ', $transaction->metode_pembayaran)),
                    'status' => $this->translatePaymentStatus($transaction->payment_status),
                    'paid_at' => $transaction->paid_at ? $transaction->paid_at->format('d F Y H:i') : '-',
                ],

                // Items
                'items' => $transaction->details->map(function ($detail) {
                    return [
                        'product_name' => $detail->produk->name ?? 'Produk tidak tersedia',
                        'variant' => ($detail->size ? 'Size: ' . $detail->size->size : '') .
                            ($detail->color ? ' | Warna: ' . $detail->color->name : ''),
                        'price' => $detail->harga,
                        'quantity' => $detail->qty,
                        'discount' => $detail->diskon ?? 0,
                        'subtotal' => ($detail->harga * $detail->qty) - ($detail->diskon ?? 0),
                    ];
                })->toArray(),

                // Totals
                'subtotal' => $transaction->subtotal,
                'discount_amount' => $transaction->discount_amount,
                'shipping_cost' => $transaction->shipping_cost,
                'total_amount' => $transaction->total_amount,

                // Approval info
                'approved_by' => $transaction->approvedBy ? [
                    'name' => $transaction->approvedBy->nama_lengkap,
                    'role' => $transaction->approvedBy->role,
                ] : null,

                'notes' => $transaction->catatan,
            ];

            $pdf = Pdf::loadView('admin.exports.invoice-pdf', $invoiceData);
            $pdf->setPaper('a4', 'portrait');

            $filename = 'invoice-' . $invoiceData['invoice_number'] . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            \Log::error('Invoice generation error: ' . $e->getMessage());

            return back()->with('error', 'Gagal generate invoice: ' . $e->getMessage());
        }
    }

    /**
     * Export transaksi ke PDF
     */
    public function export(Request $request)
    {
        try {
            // Query dengan filter yang sama seperti index
            $query = Transaksi::with(['customer', 'shippingMethod', 'details', 'approvedBy'])
                ->orderBy('created_at', 'desc');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('payment_status')) {
                $query->where('payment_status', $request->payment_status);
            }

            if ($request->filled('search')) {
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

            $transactions = $query->get();

            $data = [
                'transactions' => $transactions,
                'filters' => [
                    'status' => $request->status ? $this->translateStatus($request->status) : 'Semua',
                    'payment_status' => $request->payment_status ? $this->translatePaymentStatus($request->payment_status) : 'Semua',
                    'search' => $request->search ?: 'Tidak ada',
                    'total_records' => $transactions->count(),
                ],
                'export_date' => Carbon::now()->format('d F Y H:i:s')
            ];

            $pdf = Pdf::loadView('admin.exports.transactions-pdf', $data);
            $pdf->setPaper('a4', 'landscape');

            $filename = 'laporan-transaksi-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            \Log::error('Export transactions error: ' . $e->getMessage());

            return back()->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }

    /**
     * Get statistik transaksi
     */
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
            \Log::error('Get statistics error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format alamat customer
     */
    private function formatAddress($transaction)
    {
        $address = [];
        if ($transaction->shipping_address)
            $address[] = $transaction->shipping_address;
        if ($transaction->shipping_village_name)
            $address[] = $transaction->shipping_village_name;
        if ($transaction->shipping_district_name)
            $address[] = $transaction->shipping_district_name;
        if ($transaction->shipping_regency_name)
            $address[] = $transaction->shipping_regency_name;
        if ($transaction->shipping_province_name)
            $address[] = $transaction->shipping_province_name;
        if ($transaction->shipping_postal_code)
            $address[] = $transaction->shipping_postal_code;

        return implode(', ', $address);
    }

    /**
     * Format alamat pengiriman
     */
    private function formatShippingAddress($transaction)
    {
        $parts = [];
        if ($transaction->shipping_name)
            $parts[] = $transaction->shipping_name;
        if ($transaction->shipping_phone)
            $parts[] = $transaction->shipping_phone;

        $address = $this->formatAddress($transaction);
        if ($address)
            $parts[] = $address;

        return implode(' | ', $parts);
    }

    /**
     * Translate status ke Indonesia
     */
    private function translateStatus($status)
    {
        $translations = [
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];
        return $translations[$status] ?? $status;
    }

    /**
     * Translate payment status ke Indonesia
     */
    private function translatePaymentStatus($status)
    {
        $translations = [
            'pending' => 'Menunggu',
            'paid' => 'Lunas',
            'failed' => 'Gagal',
            'refunded' => 'Dikembalikan'
        ];
        return $translations[$status] ?? $status;
    }

    /**
     * Hapus transaksi (opsional)
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaksi::with('details.produk')->findOrFail($id);
            $admin = Auth::guard('admin')->user();

            // Hanya admin dan owner yang boleh hapus
            if (!in_array($admin->role, ['admin', 'owner'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk menghapus transaksi'
                ], 403);
            }

            // Kembalikan stok jika transaksi belum cancelled
            if ($transaction->status !== 'cancelled') {
                $this->restockProducts($transaction);
            }

            // Hapus detail transaksi terlebih dahulu
            $transaction->details()->delete();

            // Hapus transaksi
            $transaction->delete();

            DB::commit();

            \Log::info("Transaksi {$id} dihapus oleh {$admin->nama_lengkap}");

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error delete transaction: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus transaksi: ' . $e->getMessage()
            ], 500);
        }
    }
}
