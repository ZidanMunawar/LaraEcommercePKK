<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\ItemKeranjang;
use App\Models\ShippingMethod;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $customerId = Auth::guard('customer')->id();
        $customer = Auth::guard('customer')->user();

        // Get cart
        $cart = Keranjang::where('id_customers', $customerId)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('customer.cart')
                ->with('error', 'Your cart is empty!');
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

    public function process(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'province_code' => 'required|string',      // ✅ TAMBAH
            'province_name' => 'required|string',      // ✅ TAMBAH
            'regency_code' => 'required|string',       // ✅ TAMBAH
            'regency_name' => 'required|string',       // ✅ TAMBAH
            'district_code' => 'required|string',      // ✅ TAMBAH
            'district_name' => 'required|string',      // ✅ TAMBAH
            'village_code' => 'required|string',       // ✅ TAMBAH
            'village_name' => 'required|string',       // ✅ TAMBAH
            'postal_code' => 'nullable|string|max:10', // ✅ TAMBAH

            'shipping_method' => 'required|exists:shipping_methods,id',
            'payment_method' => 'required|in:transfer_bca,transfer_bni,transfer_mandiri,gopay,dana,seabank',
            'catatan' => 'nullable|string'
        ]);

        $customerId = Auth::guard('customer')->id();
        $cart = Keranjang::where('id_customers', $customerId)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
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

            $shippingMethod = ShippingMethod::findOrFail($request->shipping_method);
            $shippingCost = $shippingMethod->cost;
            $discountAmount = 0;
            $totalAmount = $subtotal + $shippingCost - $discountAmount;

            // Generate unique transaction ID
            $transactionId = 'TRX-' . date('Ymd') . '-' . strtoupper(uniqid());

            // Create transaction
            $transaction = Transaksi::create([
                'id_customers' => $customerId,
                'id_shipping_method' => $shippingMethod->id,
                'shipping_cost' => $shippingCost,
                'shipping_name' => $request->nama_lengkap,              // ✅ TAMBAH
                'shipping_phone' => $request->no_telp,                  // ✅ TAMBAH
                'shipping_address' => $request->alamat,                 // ✅ TAMBAH
                'shipping_province_code' => $request->province_code,    // ✅ TAMBAH
                'shipping_province_name' => $request->province_name,    // ✅ TAMBAH
                'shipping_regency_code' => $request->regency_code,      // ✅ TAMBAH
                'shipping_regency_name' => $request->regency_name,      // ✅ TAMBAH
                'shipping_district_code' => $request->district_code,    // ✅ TAMBAH
                'shipping_district_name' => $request->district_name,    // ✅ TAMBAH
                'shipping_village_code' => $request->village_code,      // ✅ TAMBAH
                'shipping_village_name' => $request->village_name,      // ✅ TAMBAH
                'shipping_postal_code' => $request->postal_code,        // ✅ TAMBAH
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'metode_pembayaran' => $request->payment_method,
                'transaction_id' => $transactionId,
                'payment_status' => 'pending',
                'status' => 'pending',
                'catatan' => $request->catatan
            ]);

            // Create transaction details
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

                // Update product stock
                $item->produk->decrement('quantity', $item->qty);
            }

            // Clear cart
            ItemKeranjang::where('id_cart', $cart->id_cart)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'transaction_id' => $transaction->id_transaksi,
                'order_number' => $transactionId,
                'redirect_url' => route('customer.payment.upload.page', $transaction->id_transaksi) // ✅ GANTI INI
            ]);


        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }

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

        // ✅ TAMBAH INI: Redirect ke upload page kalau belum upload bukti
        if (!$transaction->payment_proof) {
            return redirect()->route('customer.payment.upload.page', $id)
                ->with('info', 'Please upload your payment proof to complete the order.');
        }

        return view('customer.pages.checkout-success', compact('transaction'));
    }

}
