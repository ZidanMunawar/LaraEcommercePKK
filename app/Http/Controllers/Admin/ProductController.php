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

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index()
    {
        $products = Produk::with(['categories', 'audiences', 'primaryImage', 'promotion'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.pages.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
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
     * Store a newly created product
     */
    public function store(Request $request)
    {
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
            'name.required' => 'Nama produk wajib diisi.',
            'price.required' => 'Harga produk wajib diisi.',
            'quantity.required' => 'Jumlah stok wajib diisi.',
            'audiences.required' => 'Pilih minimal 1 audience.',
            'categories.required' => 'Pilih minimal 1 kategori.',
            'colors.required' => 'Pilih minimal 1 warna.',
            'sizes.required' => 'Pilih minimal 1 ukuran.',
            'tags.required' => 'Pilih minimal 1 tag.',
            'images.required' => 'Upload minimal 1 gambar produk.',
            'images.max' => 'Maksimal 10 gambar produk.',
            'promotion_id.exists' => 'Promotion tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Create product
            $product = Produk::create([
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

            // Sync relations
            $product->audiences()->sync($request->audiences);
            $product->categories()->sync($request->categories);
            $product->colors()->sync($request->colors);
            $product->sizes()->sync($request->sizes);
            $product->tags()->sync($request->tags);

            // Upload images
            if ($request->hasFile('images')) {
                $primaryIndex = $request->primary_image ?? 0;

                foreach ($request->file('images') as $index => $image) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $image->storeAs('products', $imageName, 'public');

                    ProdukImage::create([
                        'id_produk' => $product->id_produk,
                        'image_url' => $imagePath,
                        'is_primary' => ($index == $primaryIndex),
                    ]);
                }

                // Set main product image to first/primary image
                $primaryImage = $product->images()->where('is_primary', true)->first()
                    ?? $product->images()->first();

                if ($primaryImage) {
                    $product->update(['image' => $primaryImage->image_url]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing product
     */
    public function edit($id)
    {
        $product = Produk::with([
            'audiences',
            'categories',
            'colors',
            'sizes',
            'tags',
            'images',
            'promotion'
        ])->findOrFail($id);

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
     * Update the specified product
     */
    public function update(Request $request, $id)
    {
        $product = Produk::findOrFail($id);

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
            'name.required' => 'Nama produk wajib diisi.',
            'price.required' => 'Harga produk wajib diisi.',
            'quantity.required' => 'Jumlah stok wajib diisi.',
            'audiences.required' => 'Pilih minimal 1 audience.',
            'categories.required' => 'Pilih minimal 1 kategori.',
            'colors.required' => 'Pilih minimal 1 warna.',
            'sizes.required' => 'Pilih minimal 1 ukuran.',
            'tags.required' => 'Pilih minimal 1 tag.',
            'promotion_id.exists' => 'Promotion tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update product
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

            // Sync relations
            $product->audiences()->sync($request->audiences);
            $product->categories()->sync($request->categories);
            $product->colors()->sync($request->colors);
            $product->sizes()->sync($request->sizes);
            $product->tags()->sync($request->tags);

            // Upload new images if exists
            if ($request->hasFile('new_images')) {
                $currentImagesCount = $product->images()->count();
                $newImagesCount = count($request->file('new_images'));

                if (($currentImagesCount + $newImagesCount) > 10) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Total gambar tidak boleh lebih dari 10.');
                }

                foreach ($request->file('new_images') as $image) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $image->storeAs('products', $imageName, 'public');

                    ProdukImage::create([
                        'id_produk' => $product->id_produk,
                        'image_url' => $imagePath,
                        'is_primary' => false,
                    ]);
                }
            }

            // Update primary image
            if ($request->has('primary_image')) {
                $product->images()->update(['is_primary' => false]);
                $product->images()->where('id', $request->primary_image)->update(['is_primary' => true]);

                $primaryImage = $product->images()->where('id', $request->primary_image)->first();
                if ($primaryImage) {
                    $product->update(['image' => $primaryImage->image_url]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified product
     */
    public function destroy($id)
    {
        try {
            $product = Produk::findOrFail($id);

            // Delete all images
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image->image_url)) {
                    Storage::disk('public')->delete($image->image_url);
                }
            }

            $product->delete();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete single image
     */
    public function deleteImage($id)
    {
        try {
            $image = ProdukImage::findOrFail($id);
            $product = $image->produk;

            // Prevent deleting if only 1 image left
            if ($product->images()->count() <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus gambar terakhir.'
                ], 400);
            }

            // Delete file
            if (Storage::disk('public')->exists($image->image_url)) {
                Storage::disk('public')->delete($image->image_url);
            }

            $wasPrimary = $image->is_primary;
            $image->delete();

            // If deleted primary, set first image as primary
            if ($wasPrimary) {
                $newPrimary = $product->images()->first();
                if ($newPrimary) {
                    $newPrimary->update(['is_primary' => true]);
                    $product->update(['image' => $newPrimary->image_url]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
