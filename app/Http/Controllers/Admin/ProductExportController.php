<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Category;
use App\Models\Audience;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ProductExportController extends Controller
{
    public function export(Request $request)
    {
        $request->validate([
            'export_type' => 'required|in:pdf',
            'category' => 'nullable|exists:categories,id',
            'audience' => 'nullable|exists:audiences,id',
            'availability' => 'nullable|in:available,out_of_stock',
            'featured' => 'nullable|in:featured,not_featured',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from'
        ]);

        try {
            $query = Produk::with(['categories', 'audiences', 'colors', 'sizes', 'images'])
                ->orderBy('created_at', 'desc');

            // Apply filters
            if ($request->filled('category')) {
                $query->whereHas('categories', function ($q) use ($request) {
                    $q->where('id_category', $request->category);
                });
            }

            if ($request->filled('audience')) {
                $query->whereHas('audiences', function ($q) use ($request) {
                    $q->where('id_audience', $request->audience);
                });
            }

            if ($request->filled('availability')) {
                if ($request->availability === 'available') {
                    $query->where('quantity', '>', 0)->where('is_available', true);
                } else {
                    $query->where('quantity', 0)->orWhere('is_available', false);
                }
            }

            if ($request->filled('featured')) {
                $query->where('is_featured', $request->featured === 'featured');
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            $products = $query->get();
            $filters = $request->all();

            // Generate PDF
            $pdf = Pdf::loadView('admin.exports.products-pdf', compact('products', 'filters'))
                ->setPaper('a4', 'landscape')
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true
                ]);

            $filename = 'products-export-' . date('Y-m-d-H-i-s') . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengekspor produk: ' . $e->getMessage());
        }
    }

    public function showExportForm()
    {
        $categories = Category::all();
        $audiences = Audience::all();

        return view('admin.exports.products-export-form', compact('categories', 'audiences'));
    }

    public function getStatistics()
    {
        $totalProducts = Produk::count();
        $availableProducts = Produk::where('is_available', true)->where('quantity', '>', 0)->count();
        $outOfStockProducts = Produk::where('quantity', 0)->orWhere('is_available', false)->count();
        $featuredProducts = Produk::where('is_featured', true)->count();
        $newProducts = Produk::where('is_new', true)->count();
        $bestSellers = Produk::where('is_best_seller', true)->count();

        $categories = Category::withCount([
            'products' => function ($query) {
                $query->where('is_available', true);
            }
        ])->get();

        return response()->json([
            'total_products' => $totalProducts,
            'available_products' => $availableProducts,
            'out_of_stock_products' => $outOfStockProducts,
            'featured_products' => $featuredProducts,
            'new_products' => $newProducts,
            'best_seller_products' => $bestSellers,
            'categories' => $categories
        ]);
    }
}
