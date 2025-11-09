<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Menampilkan halaman daftar ukuran
     * Ukuran produk seperti S, M, L, XL, dll
     */
    public function index()
    {
        // Ambil semua data ukuran, urutkan dari yang terbaru
        $sizes = Size::orderBy('created_at', 'desc')->get();

        // Kirim ke view
        return view('admin.pages.master.sizes', compact('sizes'));
    }

    /**
     * Menyimpan ukuran baru ke database
     * Input: ukuran (S, M, L, XL, dll)
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'size' => 'required|string|max:20|unique:sizes,size',
        ], [
            'size.required' => 'Ukuran wajib diisi',
            'size.unique' => 'Ukuran sudah ada, gunakan ukuran lain',
            'size.max' => 'Ukuran maksimal 20 karakter',
        ]);

        try {
            // Simpan ukuran baru (ubah ke uppercase biar konsisten)
            Size::create([
                'size' => strtoupper($request->size),
            ]);

            return redirect()->route('admin.master.sizes')
                ->with('success', 'Ukuran berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan ukuran: ' . $e->getMessage());
        }
    }

    /**
     * Update data ukuran yang sudah ada
     * Bisa ganti nama ukuran
     */
    public function update(Request $request, $id)
    {
        // Validasi input (kecuali ID yang sedang diedit)
        $request->validate([
            'size' => 'required|string|max:20|unique:sizes,size,' . $id,
        ], [
            'size.required' => 'Ukuran wajib diisi',
            'size.unique' => 'Ukuran sudah ada, gunakan ukuran lain',
            'size.max' => 'Ukuran maksimal 20 karakter',
        ]);

        try {
            // Cari ukuran berdasarkan ID
            $size = Size::findOrFail($id);

            // Update ukuran (ubah ke uppercase)
            $size->update([
                'size' => strtoupper($request->size),
            ]);

            return redirect()->route('admin.master.sizes')
                ->with('success', 'Ukuran berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui ukuran: ' . $e->getMessage());
        }
    }

    /**
     * Hapus ukuran dari database
     */
    public function destroy($id)
    {
        try {
            // Cari ukuran yang mau dihapus
            $size = Size::findOrFail($id);

            // Simpan ukuran (buat pesan sukses)
            $sizeName = $size->size;

            // Hapus ukuran
            $size->delete();

            return redirect()->route('admin.master.sizes')
                ->with('success', "Ukuran '{$sizeName}' berhasil dihapus!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus ukuran: ' . $e->getMessage());
        }
    }
}
