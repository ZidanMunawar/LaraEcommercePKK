<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Audience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Menampilkan halaman daftar kategori
     * Sekaligus ambil data audiences untuk modal
     */
    public function index()
    {
        // Ambil semua kategori beserta relasi audiences-nya
        $categories = Category::with('audiences')
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil semua audiences (untuk checkbox di modal)
        $audiences = Audience::orderBy('name', 'asc')->get();

        // Kirim ke view
        return view('admin.pages.master.categories', compact('categories', 'audiences'));
    }

    /**
     * Menyimpan kategori baru ke database
     * Termasuk upload gambar dan relasi audiences
     */
    public function store(Request $request)
    {
        // Validasi input dari user
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'audience_ids' => 'nullable|array',
            'audience_ids.*' => 'exists:audiences,id',
        ], [
            // Pesan error dalam bahasa Indonesia
            'name.required' => 'Nama kategori wajib diisi',
            'name.unique' => 'Nama kategori sudah ada, gunakan nama lain',
            'name.max' => 'Nama kategori maksimal 100 karakter',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar: JPEG, PNG, JPG, GIF, SVG',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'audience_ids.array' => 'Format audiens tidak valid',
            'audience_ids.*.exists' => 'Audiens tidak valid',
        ]);

        // Kalau validasi gagal, redirect balik dengan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Mohon periksa kembali data yang diisi');
        }

        try {
            // Data yang mau disimpan
            $data = [
                'name' => $request->name,
            ];

            // Upload gambar kalau ada
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Generate nama file unik (biar ga bentrok)
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Simpan ke folder storage/app/public/categories
                $imagePath = $image->storeAs('categories', $imageName, 'public');

                $data['image'] = $imagePath;
            }

            // Simpan kategori ke database
            $category = Category::create($data);

            // Hubungkan kategori dengan audiences (many-to-many)
            if ($request->has('audience_ids') && is_array($request->audience_ids)) {
                $category->audiences()->sync($request->audience_ids);
            }

            // Redirect dengan pesan sukses
            return redirect()->route('admin.master.categories')
                ->with('success', 'Kategori berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Kalau ada error, tampilkan pesan error
            return redirect()->back()
                ->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    /**
     * Update data kategori yang sudah ada
     * Bisa ganti nama, gambar, dan audiences
     */
    public function update(Request $request, $id)
    {
        // Cari kategori berdasarkan ID
        $category = Category::findOrFail($id);

        // Validasi input (kecuali ID yang sedang diedit)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:categories,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'audience_ids' => 'nullable|array',
            'audience_ids.*' => 'exists:audiences,id',
        ], [
            'name.required' => 'Nama kategori wajib diisi',
            'name.unique' => 'Nama kategori sudah ada, gunakan nama lain',
            'name.max' => 'Nama kategori maksimal 100 karakter',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar: JPEG, PNG, JPG, GIF, SVG',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'audience_ids.array' => 'Format audiens tidak valid',
            'audience_ids.*.exists' => 'Audiens tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Mohon periksa kembali data yang diisi');
        }

        try {
            $data = [
                'name' => $request->name,
            ];

            // Kalau upload gambar baru
            if ($request->hasFile('image')) {
                // Hapus gambar lama kalau ada
                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    Storage::disk('public')->delete($category->image);
                }

                // Upload gambar baru
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('categories', $imageName, 'public');
                $data['image'] = $imagePath;
            }

            // Update data kategori
            $category->update($data);

            // Update relasi audiences
            if ($request->has('audience_ids')) {
                $category->audiences()->sync($request->audience_ids);
            } else {
                // Kalau ga ada yang dipilih, lepas semua relasi
                $category->audiences()->detach();
            }

            return redirect()->route('admin.master.categories')
                ->with('success', 'Kategori berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

    /**
     * Hapus kategori dari database
     * Termasuk hapus gambarnya dari storage
     */
    public function destroy($id)
    {
        try {
            // Cari kategori yang mau dihapus
            $category = Category::findOrFail($id);

            // Simpan nama kategori (buat pesan sukses)
            $categoryName = $category->name;

            // Hapus gambar dari storage kalau ada
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            // Hapus kategori dari database
            // (relasi audiences akan otomatis kehapus karena cascade)
            $category->delete();

            return redirect()->route('admin.master.categories')
                ->with('success', "Kategori '{$categoryName}' berhasil dihapus!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}
