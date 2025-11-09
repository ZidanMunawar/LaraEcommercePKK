<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Audience;
use Illuminate\Http\Request;

class AudienceController extends Controller
{
    /**
     * Menampilkan halaman daftar audiens
     * Bisa dengan search realtime tanpa refresh
     */
    public function index()
    {
        // Ambil semua data audiens, urutkan dari yang terbaru
        $audiences = Audience::orderBy('created_at', 'desc')->get();

        // Kirim data ke view
        return view('admin.pages.master.audiences', compact('audiences'));
    }

    /**
     * Menyimpan audiens baru ke database
     * Dipanggil saat submit form tambah audiens
     */
    public function store(Request $request)
    {
        // Validasi input dari user
        $request->validate([
            'name' => 'required|string|max:100|unique:audiences,name',
        ], [
            'name.required' => 'Nama audiens wajib diisi',
            'name.unique' => 'Nama audiens sudah ada, gunakan nama lain'
        ]);

        // Simpan data audiens baru
        Audience::create([
            'name' => $request->name,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.master.audiences')->with('success', 'Audiens berhasil ditambahkan!');
    }

    /**
     * Update data audiens yang sudah ada
     * Dipanggil saat submit form edit audiens
     */
    public function update(Request $request, $id)
    {
        // Validasi input, kecuali ID yang sedang diedit (biar gak bentrok)
        $request->validate([
            'name' => 'required|string|max:100|unique:audiences,name,' . $id,
        ], [
            'name.required' => 'Nama audiens wajib diisi',
            'name.unique' => 'Nama audiens sudah ada, gunakan nama lain'
        ]);

        // Cari data audiens berdasarkan ID
        $audience = Audience::findOrFail($id);

        // Update nama audiens
        $audience->update([
            'name' => $request->name,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.master.audiences')->with('success', 'Audiens berhasil diperbarui!');
    }

    /**
     * Menghapus audiens dari database
     * Dipanggil saat konfirmasi hapus di modal
     */
    public function destroy($id)
    {
        try {
            // Cari audiens berdasarkan ID
            $audience = Audience::findOrFail($id);

            // Simpan nama audiens sebelum dihapus (buat pesan)
            $audienceName = $audience->name;

            // Hapus data audiens
            $audience->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('admin.master.audiences')->with('success', "Audiens '{$audienceName}' berhasil dihapus!");

        } catch (\Exception $e) {
            // Kalau ada error (misal: data dipakai di tabel lain), tampilkan pesan error
            return redirect()->route('admin.master.audiences')->with('error', 'Gagal menghapus audiens. Mungkin data masih digunakan di tempat lain.');
        }
    }
}
