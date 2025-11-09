<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * ========== FUNGSI: INDEX ==========
     * Menampilkan halaman wishlist customer dengan semua produk yang disimpan
     *
     * @return \Illuminate\View\View - View halaman wishlist dengan data produk
     */
    public function index()
    {
        // Ambil semua wishlist user yang login dengan relasi produk, gambar, dan kategori
        $wishlists = Wishlist::with('produk.images', 'produk.categories')
            ->where('id_customers', Auth::guard('customer')->id())
            ->latest() // Urutkan dari yang terbaru
            ->get();

        // Kirim data ke view
        return view('customer.pages.wishlist', compact('wishlists'));
    }

    /**
     * ========== FUNGSI: STORE ==========
     * Menambahkan produk ke wishlist (method lama, bisa dihapus jika tidak digunakan)
     *
     * @param Request $request - Request yang berisi product_id
     * @return \Illuminate\Http\JsonResponse - Response JSON dengan status operasi
     */
    public function store(Request $request)
    {
        // Validasi input: product_id harus ada dan produk harus valid di database
        $request->validate([
            'product_id' => 'required|exists:produk,id_produk'
        ]);

        $customerId = Auth::guard('customer')->id();
        $productId = $request->product_id;

        // ========== PENGECEKAN: PRODUK SUDAH DI WISHLIST? ==========
        // Cek apakah produk sudah ada di wishlist user ini
        $exists = Wishlist::where('id_customers', $customerId)
            ->where('id_produk', $productId)
            ->exists();

        if ($exists) {
            // Jika sudah ada, return error dengan status 409 (Conflict)
            return response()->json([
                'success' => false,
                'message' => 'Produk sudah ada di wishlist!'
            ], 409);
        }

        // ========== AKSI: TAMBAH KE WISHLIST ==========
        // Jika belum ada, buat record wishlist baru
        Wishlist::create([
            'id_customers' => $customerId,
            'id_produk' => $productId
        ]);

        // Hitung total produk di wishlist user
        $wishlistCount = Wishlist::where('id_customers', $customerId)->count();

        // Return success response dengan data terbaru
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke wishlist!',
            'wishlist_count' => $wishlistCount,
            'action' => 'added'
        ]);
    }

    /**
     * ========== FUNGSI: TOGGLE ==========
     * Menambah atau menghapus produk dari wishlist (Smart Toggle)
     * Jika produk sudah di wishlist → HAPUS
     * Jika produk belum di wishlist → TAMBAH
     *
     * @param int $productId - ID produk yang akan di-toggle
     * @return \Illuminate\Http\JsonResponse - Response JSON dengan status operasi
     */
    public function toggle($productId)
    {
        try {
            $customerId = Auth::guard('customer')->id();

            // ========== VALIDASI: PRODUK EXIST ==========
            // Cek apakah produk ada di database
            $product = Produk::findOrFail($productId);

            // ========== PENGECEKAN: PRODUK DI WISHLIST? ==========
            // Cek apakah produk sudah ada di wishlist user ini
            $wishlist = Wishlist::where('id_customers', $customerId)
                ->where('id_produk', $productId)
                ->first();

            if ($wishlist) {
                // ========== KONDISI: PRODUK SUDAH ADA ==========
                // Jika sudah ada, HAPUS dari wishlist (Action: REMOVE)
                $wishlist->delete();

                // Hitung total produk wishlist terbaru
                $wishlistCount = Wishlist::where('id_customers', $customerId)->count();

                return response()->json([
                    'success' => true,
                    'message' => 'Produk dihapus dari wishlist!',
                    'action' => 'removed',
                    'wishlist_count' => $wishlistCount,
                    'wishlistCount' => $wishlistCount // backup key untuk kompatibilitas
                ]);
            } else {
                // ========== KONDISI: PRODUK BELUM ADA ==========
                // Jika belum ada, TAMBAH ke wishlist (Action: ADD)
                Wishlist::create([
                    'id_customers' => $customerId,
                    'id_produk' => $productId
                ]);

                // Hitung total produk wishlist terbaru
                $wishlistCount = Wishlist::where('id_customers', $customerId)->count();

                return response()->json([
                    'success' => true,
                    'message' => 'Produk ditambahkan ke wishlist!',
                    'action' => 'added',
                    'wishlist_count' => $wishlistCount,
                    'wishlistCount' => $wishlistCount // backup key untuk kompatibilitas
                ]);
            }
        } catch (\Exception $e) {
            // ========== ERROR HANDLING ==========
            // Jika terjadi error, return error response
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ========== FUNGSI: DESTROY ==========
     * Menghapus produk dari wishlist berdasarkan ID wishlist
     *
     * @param int $id - ID wishlist yang akan dihapus
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // ========== VALIDASI: WISHLIST EXIST & OWNERSHIP ==========
        // Cari wishlist berdasarkan ID dan user yang login
        // Jika tidak ada, akan throw 404 error (firstOrFail)
        $wishlist = Wishlist::where('id_wishlist', $id)
            ->where('id_customers', Auth::guard('customer')->id())
            ->firstOrFail();

        // ========== AKSI: HAPUS WISHLIST ==========
        // Hapus record wishlist dari database
        $wishlist->delete();

        // Hitung total produk wishlist setelah penghapusan
        $wishlistCount = Wishlist::where('id_customers', Auth::guard('customer')->id())
            ->count();

        // ========== CONDITIONAL RESPONSE ==========
        // Jika request dari AJAX, return JSON response
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk dihapus dari wishlist!',
                'wishlist_count' => $wishlistCount
            ]);
        }

        // Jika request biasa, redirect back dengan notifikasi
        return redirect()->back()->with('success', 'Produk dihapus dari wishlist!');
    }
}
?>