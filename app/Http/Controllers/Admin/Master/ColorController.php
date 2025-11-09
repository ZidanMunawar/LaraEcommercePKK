<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Menampilkan halaman daftar warna
     * Data warna diurutkan dari yang terbaru
     */
    public function index()
    {
        // Ambil semua data warna, urutkan dari yang terbaru
        $colors = Color::orderBy('created_at', 'desc')->get();

        // Kirim ke view
        return view('admin.pages.master.colors', compact('colors'));
    }

    /**
     * Menyimpan warna baru ke database
     * Input: nama warna & kode hex color
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:50|unique:colors,name',
            'code' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ], [
            'name.required' => 'Nama warna wajib diisi',
            'name.unique' => 'Nama warna sudah ada, gunakan nama lain',
            'code.required' => 'Kode warna wajib diisi',
            'code.regex' => 'Format kode warna tidak valid (contoh: #FF0000)',
        ]);

        try {
            // Simpan warna baru
            Color::create([
                'name' => $request->name,
                'code' => $request->code,
            ]);

            return redirect()->route('admin.master.colors')
                ->with('success', 'Warna berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan warna: ' . $e->getMessage());
        }
    }

    /**
     * Update data warna yang sudah ada
     * Bisa ganti nama atau kode warna
     */
    public function update(Request $request, $id)
    {
        // Validasi input (kecuali ID yang sedang diedit)
        $request->validate([
            'name' => 'required|string|max:50|unique:colors,name,' . $id,
            'code' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ], [
            'name.required' => 'Nama warna wajib diisi',
            'name.unique' => 'Nama warna sudah ada, gunakan nama lain',
            'code.required' => 'Kode warna wajib diisi',
            'code.regex' => 'Format kode warna tidak valid (contoh: #FF0000)',
        ]);

        try {
            // Cari warna berdasarkan ID
            $color = Color::findOrFail($id);

            // Update data warna
            $color->update([
                'name' => $request->name,
                'code' => $request->code,
            ]);

            return redirect()->route('admin.master.colors')
                ->with('success', 'Warna berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui warna: ' . $e->getMessage());
        }
    }

    /**
     * Hapus warna dari database
     */
    public function destroy($id)
    {
        try {
            // Cari warna yang mau dihapus
            $color = Color::findOrFail($id);

            // Simpan nama warna (buat pesan sukses)
            $colorName = $color->name;

            // Hapus warna
            $color->delete();

            return redirect()->route('admin.master.colors')
                ->with('success', "Warna '{$colorName}' berhasil dihapus!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus warna: ' . $e->getMessage());
        }
    }
}
