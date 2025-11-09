<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Menampilkan halaman daftar promosi
     * Promosi digunakan untuk menandai produk/slide (seperti: Flash Sale, New Arrival)
     */
    public function index()
    {
        // Ambil semua promosi, urutkan dari yang terbaru
        $promotions = Promotion::orderBy('created_at', 'desc')->get();

        // Kirim data ke view
        return view('admin.pages.master.promotions', compact('promotions'));
    }

    /**
     * Menyimpan promosi baru ke database
     * Input: nama promosi (contoh: Flash Sale, New Arrival)
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:100|unique:promotions,name',
        ], [
            'name.required' => 'Nama promosi wajib diisi',
            'name.unique' => 'Nama promosi sudah ada, gunakan nama lain',
            'name.max' => 'Nama promosi maksimal 100 karakter',
        ]);

        try {
            // Simpan promosi baru
            Promotion::create([
                'name' => $request->name,
            ]);

            return redirect()->route('admin.master.promotions')
                ->with('success', 'Promosi berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan promosi: ' . $e->getMessage());
        }
    }

    /**
     * Update data promosi yang sudah ada
     * Bisa ganti nama promosi
     */
    public function update(Request $request, $id)
    {
        // Validasi input (kecuali ID yang sedang diedit)
        $request->validate([
            'name' => 'required|string|max:100|unique:promotions,name,' . $id,
        ], [
            'name.required' => 'Nama promosi wajib diisi',
            'name.unique' => 'Nama promosi sudah ada, gunakan nama lain',
            'name.max' => 'Nama promosi maksimal 100 karakter',
        ]);

        try {
            // Cari promosi berdasarkan ID
            $promotion = Promotion::findOrFail($id);

            // Update nama promosi
            $promotion->update([
                'name' => $request->name,
            ]);

            return redirect()->route('admin.master.promotions')
                ->with('success', 'Promosi berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui promosi: ' . $e->getMessage());
        }
    }

    /**
     * Hapus promosi dari database
     */
    public function destroy($id)
    {
        try {
            // Cari promosi yang mau dihapus
            $promotion = Promotion::findOrFail($id);

            // Simpan nama promosi (buat pesan sukses)
            $promotionName = $promotion->name;

            // Hapus promosi
            $promotion->delete();

            return redirect()->route('admin.master.promotions')
                ->with('success', "Promosi '{$promotionName}' berhasil dihapus!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus promosi: ' . $e->getMessage());
        }
    }
}
