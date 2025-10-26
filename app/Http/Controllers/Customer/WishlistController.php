<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('produk.images', 'produk.categories')
            ->where('id_customers', Auth::guard('customer')->id())
            ->latest()
            ->get();

        return view('customer.pages.wishlist', compact('wishlists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id_produk'
        ]);

        $customerId = Auth::guard('customer')->id();
        $productId = $request->product_id;

        // Check if already in wishlist
        $exists = Wishlist::where('id_customers', $customerId)
            ->where('id_produk', $productId)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist!'
            ], 409);
        }

        Wishlist::create([
            'id_customers' => $customerId,
            'id_produk' => $productId
        ]);

        $wishlistCount = Wishlist::where('id_customers', $customerId)->count();

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist!',
            'wishlist_count' => $wishlistCount
        ]);
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::where('id_wishlist', $id)
            ->where('id_customers', Auth::guard('customer')->id())
            ->firstOrFail();

        $wishlist->delete();

        $wishlistCount = Wishlist::where('id_customers', Auth::guard('customer')->id())->count();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist!',
                'wishlist_count' => $wishlistCount
            ]);
        }

        return redirect()->back()->with('success', 'Product removed from wishlist!');
    }
}
