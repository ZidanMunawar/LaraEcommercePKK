<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Audience;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductCustController extends Controller
{
    /**
     * Menampilkan halaman daftar produk dengan fitur filter, sorting, dan pencarian
     * @param Request $request berisi parameter filter, search, sort, dll
     * @return view halaman produk customer
     */
    public function index(Request $request)
    {
        // Query dasar: ambil produk yang tersedia beserta relasi-relasinya
        $query = Produk::with(['audiences', 'categories', 'colors', 'sizes', 'tags', 'images'])
            ->where('is_available', true);

        // Filter berdasarkan pencarian (nama atau deskripsi produk)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan Kategori
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Filter berdasarkan Audience (target pembeli)
        if ($request->has('audience') && $request->audience != '') {
            $query->whereHas('audiences', function ($q) use ($request) {
                $q->where('audiences.id', $request->audience);
            });
        }

        // Filter berdasarkan Warna (multiple selection)
        if ($request->has('colors') && !empty($request->colors)) {
            $query->whereHas('colors', function ($q) use ($request) {
                $q->whereIn('colors.id', $request->colors);
            });
        }

        // Filter berdasarkan Ukuran (multiple selection)
        if ($request->has('sizes') && !empty($request->sizes)) {
            $query->whereHas('sizes', function ($q) use ($request) {
                $q->whereIn('sizes.id', $request->sizes);
            });
        }

        // Filter berdasarkan range harga
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting produk berdasarkan pilihan user
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Pagination: jumlah produk per halaman
        $perPage = $request->get('show', 12);
        $products = $query->paginate($perPage)->appends($request->query());

        // Data untuk filter sidebar
        $audiences = Audience::all();
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        // Hitung harga tertinggi untuk slider
        $maxPrice = Produk::where('is_available', true)->max('price') ?? 1000000;

        return view('customer.pages.products', compact(
            'products',
            'audiences',
            'categories',
            'colors',
            'sizes',
            'maxPrice'
        ));
    }

    /**
     * Menampilkan detail produk
     * @param int $id ID produk yang akan ditampilkan
     * @return view halaman detail produk
     */
    public function show($id)
    {
        // Ambil data produk berdasarkan ID
        $product = Produk::with(['audiences', 'categories', 'colors', 'sizes', 'tags', 'images'])
            ->findOrFail($id);

        // Ambil produk terkait (produk dengan kategori yang sama)
        $relatedProducts = Produk::where('id_produk', '!=', $id)
            ->where('is_available', true)
            ->whereHas('categories', function ($q) use ($product) {
                $q->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->limit(4)
            ->get();

        return view('customer.pages.product-detail', compact('product', 'relatedProducts'));
    }
}
