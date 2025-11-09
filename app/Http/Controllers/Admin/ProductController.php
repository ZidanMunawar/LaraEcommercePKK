<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\ProdukImage;
use App\Models\Audience;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Tag;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman daftar produk
     * - Menampilkan semua produk dengan pagination (20 per halaman)
     * - Include relasi: kategori, audience, gambar utama, promosi
     * - Diurutkan dari yang terbaru
     */
    public function index()
    {
        $categories = Category::all(); // PERBAIKAN: Pindahkan ke atas
        // Ambil produk dengan relasi terkait dan pagination
        $products = Produk::with(['categories', 'audiences', 'primaryImage', 'promotion'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // PERBAIKAN: Tambahkan $categories ke compact
        return view('admin.pages.products.index', compact('products', 'categories'));
    }

    /**
     * Menampilkan form untuk tambah produk baru
     * - Memuat semua data master (audience, category, color, size, tag, promotion)
     * - Data diurutkan berdasarkan nama/ukuran untuk mempermudah pilih
     */
    public function create()
    {
        // Ambil semua data master yang dibutuhkan untuk form
        $audiences = Audience::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $colors = Color::orderBy('name')->get();
        $sizes = Size::orderBy('size')->get();
        $tags = Tag::orderBy('name')->get();
        $promotions = Promotion::orderBy('name')->get();

        return view('admin.pages.products.create', compact(
            'audiences',
            'categories',
            'colors',
            'sizes',
            'tags',
            'promotions'
        ));
    }

    /**
     * Menyimpan produk baru ke database
     * - Validasi input lengkap
     * - Upload gambar (1-10 gambar)
     * - Sync relasi many-to-many (audience, category, color, size, tag)
     * - Set gambar pertama sebagai primary image
     * - Gunakan DB transaction untuk keamanan data
     */
    public function store(Request $request)
    {
        // Validasi input dengan custom error message Indonesia
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'is_available' => 'boolean',
            'is_new' => 'boolean',
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
            'promotion_id' => 'nullable|exists:promotions,id',
            'audiences' => 'required|array|min:1',
            'audiences.*' => 'exists:audiences,id',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'colors' => 'required|array|min:1',
            'colors.*' => 'exists:colors,id',
            'sizes' => 'required|array|min:1',
            'sizes.*' => 'exists:sizes,id',
            'tags' => 'required|array|min:1',
            'tags.*' => 'exists:tags,id',
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_image' => 'nullable|integer',
        ], [
            'name.required' => 'Nama produk wajib diisi',
            'price.required' => 'Harga produk wajib diisi',
            'quantity.required' => 'Jumlah stok wajib diisi',
            'audiences.required' => 'Pilih minimal 1 audience',
            'categories.required' => 'Pilih minimal 1 kategori',
            'colors.required' => 'Pilih minimal 1 warna',
            'sizes.required' => 'Pilih minimal 1 ukuran',
            'tags.required' => 'Pilih minimal 1 tag',
            'images.required' => 'Upload minimal 1 gambar produk',
            'images.max' => 'Maksimal 10 gambar produk',
            'promotion_id.exists' => 'Promosi tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        try {
            // Mulai database transaction (biar rollback kalau ada error)
            DB::beginTransaction();

            // Simpan data produk utama
            $product = Produk::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'old_price' => $request->old_price,
                'quantity' => $request->quantity,
                'is_available' => $request->has('is_available'), // Checkbox: true jika dicentang
                'is_new' => $request->has('is_new'),
                'is_featured' => $request->has('is_featured'),
                'is_best_seller' => $request->has('is_best_seller'),
                'promotion_id' => $request->promotion_id,
            ]);

            // Sync relasi many-to-many ke tabel pivot
            $product->audiences()->sync($request->audiences);
            $product->categories()->sync($request->categories);
            $product->colors()->sync($request->colors);
            $product->sizes()->sync($request->sizes);
            $product->tags()->sync($request->tags);

            // Upload dan simpan gambar produk
            if ($request->hasFile('images')) {
                $primaryIndex = $request->primary_image ?? 0; // Default: gambar pertama jadi primary

                foreach ($request->file('images') as $index => $image) {
                    // Generate nama file unik (timestamp + unique ID + extension)
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    // Simpan ke storage/app/public/products
                    $imagePath = $image->storeAs('products', $imageName, 'public');

                    // Simpan info gambar ke tabel produk_images
                    ProdukImage::create([
                        'id_produk' => $product->id_produk,
                        'image_url' => $imagePath,
                        'is_primary' => ($index == $primaryIndex), // Set primary jika index sama
                    ]);
                }

                // Set field 'image' di tabel produk dengan gambar primary
                $primaryImage = $product->images()->where('is_primary', true)->first()
                    ?? $product->images()->first();

                if ($primaryImage) {
                    $product->update(['image' => $primaryImage->image_url]);
                }
            }

            // Commit transaction (simpan semua perubahan)
            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Rollback jika ada error (batalkan semua perubahan)
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan produk: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form untuk edit produk
     * - Load produk beserta semua relasinya
     * - Load semua data master untuk dropdown/checkbox
     */
    public function edit($id)
    {
        // Ambil produk dengan semua relasinya
        $product = Produk::with([
            'audiences',
            'categories',
            'colors',
            'sizes',
            'tags',
            'images',
            'promotion'
        ])->findOrFail($id);

        // Ambil semua data master
        $audiences = Audience::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $colors = Color::orderBy('name')->get();
        $sizes = Size::orderBy('size')->get();
        $tags = Tag::orderBy('name')->get();
        $promotions = Promotion::orderBy('name')->get();

        return view('admin.pages.products.edit', compact(
            'product',
            'audiences',
            'categories',
            'colors',
            'sizes',
            'tags',
            'promotions'
        ));
    }

    /**
     * Update data produk yang sudah ada
     * - Update info produk
     * - Sync relasi many-to-many
     * - Upload gambar baru (opsional)
     * - Update gambar primary
     */
    public function update(Request $request, $id)
    {
        $product = Produk::findOrFail($id);

        // Validasi input (sama seperti store, tapi gambar baru opsional)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'is_available' => 'boolean',
            'is_new' => 'boolean',
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
            'promotion_id' => 'nullable|exists:promotions,id',
            'audiences' => 'required|array|min:1',
            'audiences.*' => 'exists:audiences,id',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'colors' => 'required|array|min:1',
            'colors.*' => 'exists:colors,id',
            'sizes' => 'required|array|min:1',
            'sizes.*' => 'exists:sizes,id',
            'tags' => 'required|array|min:1',
            'tags.*' => 'exists:tags,id',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_image' => 'nullable|integer',
        ], [
            'name.required' => 'Nama produk wajib diisi',
            'price.required' => 'Harga produk wajib diisi',
            'quantity.required' => 'Jumlah stok wajib diisi',
            'audiences.required' => 'Pilih minimal 1 audience',
            'categories.required' => 'Pilih minimal 1 kategori',
            'colors.required' => 'Pilih minimal 1 warna',
            'sizes.required' => 'Pilih minimal 1 ukuran',
            'tags.required' => 'Pilih minimal 1 tag',
            'promotion_id.exists' => 'Promosi tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update data produk
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'old_price' => $request->old_price,
                'quantity' => $request->quantity,
                'is_available' => $request->has('is_available'),
                'is_new' => $request->has('is_new'),
                'is_featured' => $request->has('is_featured'),
                'is_best_seller' => $request->has('is_best_seller'),
                'promotion_id' => $request->promotion_id,
            ]);

            // Sync ulang semua relasi (replace yang lama dengan yang baru)
            $product->audiences()->sync($request->audiences);
            $product->categories()->sync($request->categories);
            $product->colors()->sync($request->colors);
            $product->sizes()->sync($request->sizes);
            $product->tags()->sync($request->tags);

            // Upload gambar baru jika ada
            if ($request->hasFile('new_images')) {
                $currentImagesCount = $product->images()->count();
                $newImagesCount = count($request->file('new_images'));

                // Validasi total gambar tidak lebih dari 10
                if (($currentImagesCount + $newImagesCount) > 10) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Total gambar tidak boleh lebih dari 10');
                }

                // Upload setiap gambar baru
                foreach ($request->file('new_images') as $image) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $image->storeAs('products', $imageName, 'public');

                    ProdukImage::create([
                        'id_produk' => $product->id_produk,
                        'image_url' => $imagePath,
                        'is_primary' => false, // Gambar baru default bukan primary
                    ]);
                }
            }

            // Update gambar primary jika dipilih
            if ($request->has('primary_image')) {
                // Set semua gambar jadi non-primary
                $product->images()->update(['is_primary' => false]);

                // Set gambar terpilih jadi primary
                $product->images()->where('id', $request->primary_image)->update(['is_primary' => true]);

                // Update field 'image' di tabel produk
                $primaryImage = $product->images()->where('id', $request->primary_image)->first();
                if ($primaryImage) {
                    $product->update(['image' => $primaryImage->image_url]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    /**
     * Hapus produk dari database
     * - Hapus semua gambar dari storage
     * - Hapus produk (cascade delete untuk relasi)
     */
    public function destroy($id)
    {
        try {
            $product = Produk::findOrFail($id);

            // Hapus semua file gambar dari storage
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image->image_url)) {
                    Storage::disk('public')->delete($image->image_url);
                }
            }

            // Simpan nama produk untuk pesan sukses
            $productName = $product->name;

            // Hapus produk (relasi di tabel pivot akan ikut terhapus karena cascade)
            $product->delete();

            return redirect()->route('admin.products.index')
                ->with('success', "Produk '{$productName}' berhasil dihapus!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    /**
     * Hapus satu gambar produk (via AJAX)
     * - Cek minimal harus ada 1 gambar (tidak boleh hapus semua)
     * - Hapus file dari storage
     * - Jika gambar primary dihapus, set gambar pertama jadi primary baru
     */
    public function deleteImage($id)
    {
        try {
            $image = ProdukImage::findOrFail($id);
            $product = $image->produk;

            // Validasi: minimal harus ada 1 gambar
            if ($product->images()->count() <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus gambar terakhir. Minimal harus ada 1 gambar produk.'
                ], 400);
            }

            // Hapus file gambar dari storage
            if (Storage::disk('public')->exists($image->image_url)) {
                Storage::disk('public')->delete($image->image_url);
            }

            // Cek apakah gambar yang dihapus adalah primary
            $wasPrimary = $image->is_primary;

            // Hapus record dari database
            $image->delete();

            // Jika primary dihapus, set gambar pertama sebagai primary baru
            if ($wasPrimary) {
                $newPrimary = $product->images()->first();
                if ($newPrimary) {
                    $newPrimary->update(['is_primary' => true]);
                    $product->update(['image' => $newPrimary->image_url]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus gambar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export products to PDF
     */
    public function exportPdf(Request $request)
    {
        try {
            // Get all filter parameters from request
            $filters = [
                'category' => $request->get('export_category'),
                'search' => $request->get('export_search'),
                'status' => $request->get('export_status'),
                'sort' => $request->get('export_sort', 'latest'),
                'date_from' => $request->get('export_date_from'),
                'date_to' => $request->get('export_date_to'),
            ];

            // Build query
            $query = Produk::with(['categories', 'colors', 'sizes', 'images']);

            // Apply category filter
            if (!empty($filters['category']) && $filters['category'] !== 'all') {
                $query->whereHas('categories', function ($q) use ($filters) {
                    $q->where('id_category', $filters['category']);
                });
            }

            // Apply search filter
            if (!empty($filters['search'])) {
                $query->where(function ($q) use ($filters) {
                    $q->where('name', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('description', 'like', '%' . $filters['search'] . '%');
                });
            }

            // Apply status filter
            if (!empty($filters['status']) && $filters['status'] !== 'all') {
                switch ($filters['status']) {
                    case 'available':
                        $query->where('is_available', true);
                        break;
                    case 'unavailable':
                        $query->where('is_available', false);
                        break;
                    case 'new':
                        $query->where('is_new', true);
                        break;
                    case 'featured':
                        $query->where('is_featured', true);
                        break;
                    case 'best_seller':
                        $query->where('is_best_seller', true);
                        break;
                    case 'with_discount':
                        $query->whereNotNull('old_price')
                            ->whereColumn('old_price', '>', 'price');
                        break;
                }
            }

            // Apply date filter
            if (!empty($filters['date_from'])) {
                $query->whereDate('created_at', '>=', $filters['date_from']);
            }
            if (!empty($filters['date_to'])) {
                $query->whereDate('created_at', '<=', $filters['date_to']);
            }

            // Apply sorting
            switch ($filters['sort']) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                case 'quantity_low':
                    $query->orderBy('quantity', 'asc');
                    break;
                case 'quantity_high':
                    $query->orderBy('quantity', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default: // latest
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            $products = $query->get();
            $categories = Category::all();

            // Prepare data for PDF
            $data = [
                'products' => $products,
                'categories' => $categories,
                'filters' => [
                    'category' => $filters['category'] !== 'all' ?
                        Category::find($filters['category'])?->name : 'Semua Kategori',
                    'search' => $filters['search'] ?: 'Tidak ada',
                    'status' => $this->getStatusText($filters['status']),
                    'sort' => $this->getSortText($filters['sort']),
                    'date_range' => $this->getDateRangeText($filters['date_from'], $filters['date_to']),
                    'total_products' => $products->count(),
                    'total_categories' => $categories->count(),
                    'total_available' => $products->where('is_available', true)->count(),
                    'total_unavailable' => $products->where('is_available', false)->count(),
                    'total_new' => $products->where('is_new', true)->count(),
                    'total_featured' => $products->where('is_featured', true)->count(),
                    'total_best_seller' => $products->where('is_best_seller', true)->count(),
                    'generated_at' => Carbon::now()->format('d F Y H:i:s'),
                ]
            ];

            // Generate PDF
            $pdf = Pdf::loadView('admin.exports.products-pdf', $data);

            // Set paper orientation to landscape for better table view
            $pdf->setPaper('a4', 'landscape');

            // Download PDF
            return $pdf->download('laporan-produk-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }

    /**
     * Get status text for PDF
     */
    private function getStatusText($status)
    {
        return match ($status) {
            'available' => 'Tersedia',
            'unavailable' => 'Tidak Tersedia',
            'new' => 'Baru',
            'featured' => 'Unggulan',
            'best_seller' => 'Terlaris',
            'with_discount' => 'Ada Diskon',
            default => 'Semua Status'
        };
    }

    /**
     * Get sort text for PDF
     */
    private function getSortText($sort)
    {
        return match ($sort) {
            'price_low' => 'Harga: Rendah ke Tinggi',
            'price_high' => 'Harga: Tinggi ke Rendah',
            'name' => 'Nama: A-Z',
            'quantity_low' => 'Stok: Sedikit ke Banyak',
            'quantity_high' => 'Stok: Banyak ke Sedikit',
            'oldest' => 'Terlama',
            default => 'Terbaru'
        };
    }

    /**
     * Get date range text for PDF
     */
    private function getDateRangeText($dateFrom, $dateTo)
    {
        if ($dateFrom && $dateTo) {
            return Carbon::parse($dateFrom)->format('d/m/Y') . ' - ' . Carbon::parse($dateTo)->format('d/m/Y');
        } elseif ($dateFrom) {
            return 'Dari ' . Carbon::parse($dateFrom)->format('d/m/Y');
        } elseif ($dateTo) {
            return 'Sampai ' . Carbon::parse($dateTo)->format('d/m/Y');
        }
        return 'Semua Tanggal';
    }
}
