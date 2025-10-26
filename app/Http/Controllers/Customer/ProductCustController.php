<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Audience;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductCustController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with(['audiences', 'categories', 'colors', 'sizes', 'tags', 'images'])
            ->where('is_available', true);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by Category
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Filter by Audience
        if ($request->has('audience') && $request->audience != '') {
            $query->whereHas('audiences', function ($q) use ($request) {
                $q->where('audiences.id', $request->audience);
            });
        }

        // Sorting
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

        // Pagination
        $perPage = $request->get('show', 12);
        $products = $query->paginate($perPage);

        // For filters
        $audiences = Audience::all();
        $categories = Category::all();

        return view('customer.pages.products', compact('products', 'audiences', 'categories'));
    }

    public function show($id)
    {
        $product = Produk::with(['audiences', 'categories', 'colors', 'sizes', 'tags', 'images'])
            ->findOrFail($id);

        // Related products
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
