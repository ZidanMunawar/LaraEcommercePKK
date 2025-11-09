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
    /**
     * Menampilkan halaman keranjang belanja
     */
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

    /**
     * Menambahkan produk ke keranjang (method lama)
     */
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
                'message' => 'Stok tidak cukup! Hanya tersedia ' . $product->quantity . ' item.'
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
                    'message' => 'Tidak bisa menambah lagi! Hanya tersedia ' . $product->quantity . ' item.'
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
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cart_count' => $cartCount,
            'cartCount' => $cartCount // backup key
        ]);
    }

    /**
     * Menambahkan produk ke keranjang dari halaman produk
     * Method ini dipanggil dari JavaScript AJAX
     */
    public function addToCart($productId)
    {
        try {
            $customerId = Auth::guard('customer')->id();
            $product = Produk::findOrFail($productId);

            // Check if product is available
            if (!$product->is_available) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak tersedia!'
                ], 400);
            }

            // Check stock
            if ($product->quantity < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk habis!'
                ], 400);
            }

            // Get or create cart
            $cart = Keranjang::firstOrCreate(
                ['id_customers' => $customerId]
            );

            // Check if item already exists in cart (tanpa size dan color)
            $existingItem = ItemKeranjang::where('id_cart', $cart->id_cart)
                ->where('id_produk', $productId)
                ->whereNull('id_size')
                ->whereNull('id_color')
                ->first();

            if ($existingItem) {
                // Update quantity
                $newQty = $existingItem->qty + 1;

                if ($product->quantity < $newQty) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak bisa menambah lagi! Stok maksimal ' . $product->quantity . ' item.'
                    ], 400);
                }

                $existingItem->update(['qty' => $newQty]);
                $message = 'Jumlah produk di keranjang berhasil ditambah!';
            } else {
                // Add new item
                ItemKeranjang::create([
                    'id_cart' => $cart->id_cart,
                    'id_produk' => $productId,
                    'id_size' => null, // Bisa diset dari detail page
                    'id_color' => null, // Bisa diset dari detail page
                    'qty' => 1,
                    'harga' => $product->price
                ]);
                $message = 'Produk berhasil ditambahkan ke keranjang!';
            }

            // Hitung total item di cart
            $cartCount = ItemKeranjang::where('id_cart', $cart->id_cart)->sum('qty');

            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_count' => $cartCount,
                'cartCount' => $cartCount // backup key untuk kompabilitas
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update quantity item di keranjang
     */
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
                'message' => 'Stok tidak cukup! Hanya tersedia ' . $product->quantity . ' item.'
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
            'message' => 'Keranjang berhasil diupdate!',
            'item_total' => number_format($itemTotal, 0, ',', '.'),
            'subtotal' => number_format($subtotal, 0, ',', '.'),
            'cart_count' => $cartItems->sum('qty')
        ]);
    }

    /**
     * Update size dan color item di keranjang
     */
    public function updateVariant(Request $request, $id)
    {
        $request->validate([
            'size_id' => 'required|exists:sizes,id',
            'color_id' => 'required|exists:colors,id'
        ]);

        $customerId = Auth::guard('customer')->id();
        $cart = Keranjang::where('id_customers', $customerId)->firstOrFail();

        $cartItem = ItemKeranjang::where('id_cart_item', $id)
            ->where('id_cart', $cart->id_cart)
            ->firstOrFail();

        $product = Produk::findOrFail($cartItem->id_produk);

        // Validasi apakah size dan color tersedia untuk produk ini
        $sizeExists = $product->sizes()->where('sizes.id', $request->size_id)->exists();
        $colorExists = $product->colors()->where('colors.id', $request->color_id)->exists();

        if (!$sizeExists || !$colorExists) {
            return response()->json([
                'success' => false,
                'message' => 'Size atau warna tidak tersedia untuk produk ini!'
            ], 400);
        }

        // Check if item dengan variant yang sama sudah ada
        $existingItem = ItemKeranjang::where('id_cart', $cart->id_cart)
            ->where('id_produk', $cartItem->id_produk)
            ->where('id_size', $request->size_id)
            ->where('id_color', $request->color_id)
            ->where('id_cart_item', '!=', $id)
            ->first();

        if ($existingItem) {
            // Gabungkan quantity
            $newQty = $existingItem->qty + $cartItem->qty;

            if ($product->quantity < $newQty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak bisa menggabungkan! Stok tidak cukup.'
                ], 400);
            }

            $existingItem->update(['qty' => $newQty]);
            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Varian berhasil diupdate dan item digabungkan!',
                'merged' => true,
                'removed_item_id' => $id
            ]);
        }

        // Update variant
        $cartItem->update([
            'id_size' => $request->size_id,
            'id_color' => $request->color_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Varian berhasil diupdate!',
            'merged' => false
        ]);
    }

    /**
     * Menghapus item dari keranjang
     */
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
                'message' => 'Item berhasil dihapus dari keranjang!',
                'subtotal' => number_format($subtotal, 0, ',', '.'),
                'cart_count' => $cartCount
            ]);
        }

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang!');
    }

    /**
     * Validasi keranjang sebelum checkout
     */
    public function validateCart()
    {
        $customerId = Auth::guard('customer')->id();
        $cart = Keranjang::where('id_customers', $customerId)->firstOrFail();

        $cartItems = ItemKeranjang::with(['produk', 'size', 'color'])
            ->where('id_cart', $cart->id_cart)
            ->get();

        $errors = [];

        foreach ($cartItems as $item) {
            // Cek apakah item memiliki size dan color
            if (!$item->id_size || !$item->id_color) {
                $errors[] = "Produk {$item->produk->name} harus memilih size dan warna!";
            }

            // Cek stok
            if ($item->produk->quantity < $item->qty) {
                $errors[] = "Stok {$item->produk->name} tidak cukup! Hanya tersedia {$item->produk->quantity} item.";
            }

            // Cek apakah produk masih tersedia
            if (!$item->produk->is_available) {
                $errors[] = "Produk {$item->produk->name} tidak tersedia!";
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'message' => 'Terdapat masalah dengan keranjang Anda:',
                'errors' => $errors
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Keranjang valid!'
        ]);
    }
}
