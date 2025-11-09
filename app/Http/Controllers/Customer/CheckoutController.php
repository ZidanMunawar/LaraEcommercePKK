<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\ItemKeranjang;
use App\Models\ShippingMethod;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // ========== HALAMAN CHECKOUT ==========
    public function index()
    {
        $customerId = Auth::guard('customer')->id();
        $customer = Auth::guard('customer')->user();

        // Get cart
        $cart = Keranjang::where('id_customers', $customerId)->first();

        // ✅ PROTEKSI: Jika tidak ada cart atau kosong, redirect ke cart
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('customer.cart')
                ->with('error', 'Keranjang Anda kosong! Silakan tambahkan item terlebih dahulu.');
        }

        $cartItems = ItemKeranjang::with(['produk.images', 'size', 'color'])
            ->where('id_cart', $cart->id_cart)
            ->get();

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item->harga * $item->qty;
        });

        // Get shipping methods
        $shippingMethods = ShippingMethod::where('is_active', true)->get();

        return view('customer.pages.checkout', compact(
            'customer',
            'cartItems',
            'subtotal',
            'shippingMethods'
        ));
    }

    // ========== VALIDASI PROMO CODE (✅ SUPPORT PERCENTAGE & FIXED) ==========
    public function validatePromoCode(Request $request)
    {
        $request->validate([
            'kode_diskon' => 'required|string',
            'subtotal' => 'required|numeric'
        ]);

        // ✅ QUERY PROMO CODE DARI DB (SESUAI STRUKTUR BARU)
        $promoCode = PromoCode::where('code', strtoupper($request->kode_diskon))
            ->where('expires_at', '>=', now())
            ->first();

        if (!$promoCode) {
            return response()->json([
                'success' => false,
                'message' => 'Kode promo "' . strtoupper($request->kode_diskon) . '" tidak valid atau sudah kadaluarsa!'
            ], 400);
        }

        // ✅ CEK MINIMAL PEMBELIAN
        if ($request->subtotal < $promoCode->min_purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal pembelian untuk kode promo ini adalah Rp ' . number_format($promoCode->min_purchase, 0, ',', '.')
            ], 400);
        }

        // ✅ HITUNG DISKON BERDASARKAN TIPE (PERCENTAGE atau FIXED)
        $discountAmount = $promoCode->calculateDiscount($request->subtotal);

        return response()->json([
            'success' => true,
            'discount_amount' => (float) $discountAmount,
            'discount_type' => $promoCode->discount_type,
            'discount_value' => $promoCode->discount, // Nilai asli (10 atau 50000)
            'message' => 'Kode promo berhasil diterapkan!'
        ]);
    }

    // ========== PROSES CHECKOUT ==========
    public function process(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string',
            // ❌ HAPUS SEMUA *_code FIELDS
            'province_name' => 'required|string',
            'regency_name' => 'required|string',
            'district_name' => 'required|string',
            'village_name' => 'required|string',
            'postal_code' => 'nullable|string|max:10', // ✅ KEEP postal_code
            'shipping_method' => 'required|exists:shipping_methods,id',
            'payment_method' => 'required|in:transfer_bca,transfer_bni,transfer_mandiri,gopay,dana,seabank',
            'kode_diskon' => 'nullable|string',
            'catatan' => 'nullable|string'
        ]);

        $customerId = Auth::guard('customer')->id();
        $cart = Keranjang::where('id_customers', $customerId)->first();

        // ✅ CEK ULANG: Cart harus ada
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Get cart items
            $cartItems = ItemKeranjang::with('produk')
                ->where('id_cart', $cart->id_cart)
                ->get();

            // Calculate amounts
            $subtotal = $cartItems->sum(function ($item) {
                return $item->harga * $item->qty;
            });

            $discountAmount = 0;

            // ✅ VALIDASI PROMO CODE DARI DATABASE (SESUAI STRUKTUR BARU)
            if ($request->kode_diskon) {
                $promoCode = PromoCode::where('code', strtoupper($request->kode_diskon))
                    ->where('expires_at', '>=', now())
                    ->first();

                if (!$promoCode) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kode promo tidak valid!'
                    ], 400);
                }

                // ✅ CEK MINIMAL PEMBELIAN
                if ($subtotal < $promoCode->min_purchase) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Minimal pembelian untuk kode promo ini adalah Rp ' . number_format($promoCode->min_purchase, 0, ',', '.')
                    ], 400);
                }

                // ✅ HITUNG DISKON MENGGUNAKAN METHOD DI MODEL
                $discountAmount = $promoCode->calculateDiscount($subtotal);
            }

            $shippingMethod = ShippingMethod::findOrFail($request->shipping_method);
            $shippingCost = $shippingMethod->cost;
            $totalAmount = ($subtotal - $discountAmount) + $shippingCost;

            // Generate: ZH20251108001
            $transactionId = 'ZH-' . date('Ymd') . '-' . str_pad(Transaksi::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);

            // ✅ CREATE TRANSAKSI - HAPUS SEMUA *_code FIELDS
            $transaction = Transaksi::create([
                'id_customers' => $customerId,
                'id_shipping_method' => $shippingMethod->id,
                'shipping_cost' => $shippingCost,
                'shipping_name' => $request->nama_lengkap,
                'shipping_phone' => $request->no_telp,
                'shipping_address' => $request->alamat,
                // ❌ HAPUS SEMUA *_code FIELDS
                'shipping_province_name' => $request->province_name,
                'shipping_regency_name' => $request->regency_name,
                'shipping_district_name' => $request->district_name,
                'shipping_village_name' => $request->village_name,
                'shipping_postal_code' => $request->postal_code, // ✅ KEEP postal_code
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'kode_diskon' => $request->kode_diskon,
                'total_amount' => $totalAmount,
                'metode_pembayaran' => $request->payment_method,
                'transaction_id' => $transactionId,
                'payment_status' => 'pending',
                'status' => 'pending',
                'catatan' => $request->catatan
            ]);

            // ✅ CREATE DETAIL TRANSAKSI
            foreach ($cartItems as $item) {
                DetailTransaksi::create([
                    'id_transaksi' => $transaction->id_transaksi,
                    'id_produk' => $item->id_produk,
                    'id_size' => $item->id_size,
                    'id_color' => $item->id_color,
                    'harga' => $item->harga,
                    'qty' => $item->qty,
                    'diskon' => 0
                ]);

                // ✅ UPDATE PRODUCT STOCK
                $item->produk->decrement('quantity', $item->qty);
            }

            // ✅ CLEAR CART
            ItemKeranjang::where('id_cart', $cart->id_cart)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'transaction_id' => $transaction->id_transaksi,
                'order_number' => $transactionId,
                'redirect_url' => route('customer.payment.upload.page', $transaction->id_transaksi)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    // ========== SUCCESS PAGE ==========
    public function success($id)
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

        if (!$transaction->payment_proof) {
            return redirect()->route('customer.payment.upload.page', $id)
                ->with('info', 'Silakan upload bukti pembayaran untuk menyelesaikan pesanan.');
        }

        return view('customer.pages.checkout-success', compact('transaction'));
    }
}
