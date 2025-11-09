<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Menampilkan halaman daftar tag
     * Tag digunakan untuk penanda/label produk (misalnya: Bestseller, New Arrival, Sale)
     */
    public function index()
    {
        // Ambil semua tag, urutkan dari yang terbaru
        $tags = Tag::orderBy('created_at', 'desc')->get();

        // Kirim data ke view
        return view('admin.pages.master.tags', compact('tags'));
    }

    /**
     * Menyimpan tag baru ke database
     * Input: nama tag (contoh: Bestseller, New Arrival)
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:50|unique:tags,name',
        ], [
            'name.required' => 'Nama tag wajib diisi',
            'name.unique' => 'Tag sudah ada, gunakan nama lain',
            'name.max' => 'Nama tag maksimal 50 karakter',
        ]);

        try {
            // Simpan tag baru
            Tag::create([
                'name' => $request->name,
            ]);

            return redirect()->route('admin.master.tags')
                ->with('success', 'Tag berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan tag: ' . $e->getMessage());
        }
    }

    /**
     * Update data tag yang sudah ada
     * Bisa ganti nama tag
     */
    public function update(Request $request, $id)
    {
        // Validasi input (kecuali ID yang sedang diedit)
        $request->validate([
            'name' => 'required|string|max:50|unique:tags,name,' . $id,
        ], [
            'name.required' => 'Nama tag wajib diisi',
            'name.unique' => 'Tag sudah ada, gunakan nama lain',
            'name.max' => 'Nama tag maksimal 50 karakter',
        ]);

        try {
            // Cari tag berdasarkan ID
            $tag = Tag::findOrFail($id);

            // Update nama tag
            $tag->update([
                'name' => $request->name,
            ]);

            return redirect()->route('admin.master.tags')
                ->with('success', 'Tag berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui tag: ' . $e->getMessage());
        }
    }

    /**
     * Hapus tag dari database
     */
    public function destroy($id)
    {
        try {
            // Cari tag yang mau dihapus
            $tag = Tag::findOrFail($id);

            // Simpan nama tag (buat pesan sukses)
            $tagName = $tag->name;

            // Hapus tag
            $tag->delete();

            return redirect()->route('admin.master.tags')
                ->with('success', "Tag '{$tagName}' berhasil dihapus!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus tag: ' . $e->getMessage());
        }
    }
}
