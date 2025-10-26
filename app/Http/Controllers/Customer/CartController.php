<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\ItemKeranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $customerId = Auth::guard('customer')->id();

        // Get or create cart
        $cart = Keranjang::firstOrCreate(
            ['id_customers' => $customerId]
        );

        $cartItems = ItemKeranjang::with(['produk.images', 'size', 'color'])
            ->where('id_cart', $cart->id_cart)
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->harga * $item->qty;
        });

        return view('customer.pages.cart', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id_produk',
            'quantity' => 'required|integer|min:1',
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id'
        ]);

        $customerId = Auth::guard('customer')->id();
        $product = Produk::findOrFail($request->product_id);

        // Check stock
        if ($product->quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock! Only ' . $product->quantity . ' items available.'
            ], 400);
        }

        // Get or create cart
        $cart = Keranjang::firstOrCreate(
            ['id_customers' => $customerId]
        );

        // Check if item already exists in cart
        $existingItem = ItemKeranjang::where('id_cart', $cart->id_cart)
            ->where('id_produk', $request->product_id)
            ->where('id_size', $request->size_id)
            ->where('id_color', $request->color_id)
            ->first();

        if ($existingItem) {
            // Update quantity
            $newQty = $existingItem->qty + $request->quantity;

            if ($product->quantity < $newQty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add more! Only ' . $product->quantity . ' items available.'
                ], 400);
            }

            $existingItem->update(['qty' => $newQty]);
        } else {
            // Add new item
            ItemKeranjang::create([
                'id_cart' => $cart->id_cart,
                'id_produk' => $request->product_id,
                'id_size' => $request->size_id,
                'id_color' => $request->color_id,
                'qty' => $request->quantity,
                'harga' => $product->price
            ]);
        }

        $cartCount = ItemKeranjang::where('id_cart', $cart->id_cart)->sum('qty');

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'cart_count' => $cartCount
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $customerId = Auth::guard('customer')->id();
        $cart = Keranjang::where('id_customers', $customerId)->firstOrFail();

        $cartItem = ItemKeranjang::where('id_cart_item', $id)
            ->where('id_cart', $cart->id_cart)
            ->firstOrFail();

        // Check stock
        $product = Produk::findOrFail($cartItem->id_produk);
        if ($product->quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock! Only ' . $product->quantity . ' items available.'
            ], 400);
        }

        $cartItem->update(['qty' => $request->quantity]);

        $itemTotal = $cartItem->harga * $cartItem->qty;
        $cartItems = ItemKeranjang::where('id_cart', $cart->id_cart)->get();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->harga * $item->qty;
        });

        return response()->json([
            'success' => true,
            'message' => 'Cart updated!',
            'item_total' => number_format($itemTotal, 0, ',', '.'),
            'subtotal' => number_format($subtotal, 0, ',', '.'),
            'cart_count' => $cartItems->sum('qty')
        ]);
    }

    public function destroy($id)
    {
        $customerId = Auth::guard('customer')->id();
        $cart = Keranjang::where('id_customers', $customerId)->firstOrFail();

        $cartItem = ItemKeranjang::where('id_cart_item', $id)
            ->where('id_cart', $cart->id_cart)
            ->firstOrFail();

        $cartItem->delete();

        $cartItems = ItemKeranjang::where('id_cart', $cart->id_cart)->get();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->harga * $item->qty;
        });
        $cartCount = $cartItems->sum('qty');

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart!',
                'subtotal' => number_format($subtotal, 0, ',', '.'),
                'cart_count' => $cartCount
            ]);
        }

        return redirect()->back()->with('success', 'Item removed from cart!');
    }
}
