<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\ShippingMethod;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BuyNowController extends Controller
{
    // ========== STORE KE SESSION (BYPASS KERANJANG) ==========
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id_produk',
            'quantity' => 'required|integer|min:1',
            'color_id' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id'
        ]);

        $product = Produk::findOrFail($request->product_id);

        // ✅ VALIDASI STOK
        if (!$product->is_available || $product->quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak cukup!'
            ], 400);
        }

        // ✅ SIMPAN KE SESSION (BUKAN DB)
        $buyNowItem = [
            'product_id' => $product->id_produk,
            'product_name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->quantity,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
            'image' => $product->images->first() ? $product->images->first()->image_url : 'default.png'
        ];

        Session::put('buy_now_item', $buyNowItem);

        return response()->json([
            'success' => true,
            'message' => 'Redirecting to checkout...'
        ]);
    }

    // ========== HALAMAN CHECKOUT (DARI BUY NOW) ==========
    public function checkout()
    {
        $buyNowItem = Session::get('buy_now_item');

        // ✅ PROTEKSI: Jika session tidak ada, redirect ke produk
        if (!$buyNowItem) {
            return redirect()->route('customer.products')
                ->with('error', 'Tidak ada item untuk buy now!');
        }

        $customer = Auth::guard('customer')->user();
        $shippingMethods = ShippingMethod::where('is_active', true)->get();

        // ✅ HITUNG SUBTOTAL
        $subtotal = $buyNowItem['price'] * $buyNowItem['quantity'];

        return view('customer.pages.buy-now-checkout', compact(
            'customer',
            'buyNowItem',
            'subtotal',
            'shippingMethods'
        ));
    }

    // ========== PROSES CHECKOUT BUY NOW ==========
    public function process(Request $request)
    {
        $buyNowItem = Session::get('buy_now_item');

        // ✅ VALIDASI SESSION
        if (!$buyNowItem) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi buy now kadaluarsa!'
            ], 400);
        }

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

        try {
            DB::beginTransaction();

            $product = Produk::findOrFail($buyNowItem['product_id']);
            $subtotal = $buyNowItem['price'] * $buyNowItem['quantity'];
            $discountAmount = 0;

            // ✅ CEK KODE DISKON DARI DATABASE (SUPPORT PERCENTAGE & FIXED)
            if ($request->kode_diskon) {
                $promoCode = PromoCode::where('code', strtoupper($request->kode_diskon))
                    ->where('expires_at', '>=', now())
                    ->first();

                if (!$promoCode) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kode promo tidak valid atau sudah kadaluarsa!'
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
            DetailTransaksi::create([
                'id_transaksi' => $transaction->id_transaksi,
                'id_produk' => $buyNowItem['product_id'],
                'id_size' => $buyNowItem['size_id'],
                'id_color' => $buyNowItem['color_id'],
                'harga' => $buyNowItem['price'],
                'qty' => $buyNowItem['quantity'],
                'diskon' => 0
            ]);

            // ✅ KURANGI STOK PRODUK
            $product->decrement('quantity', $buyNowItem['quantity']);

            // ✅ CLEAR SESSION
            Session::forget('buy_now_item');

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
}
