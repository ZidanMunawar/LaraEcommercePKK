<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    /**
     * Menampilkan halaman daftar banner
     * Maksimal hanya 2 banner yang bisa ditampilkan di halaman customer
     */
    public function index()
    {
        // Ambil semua banner, urutkan dari yang terbaru
        $banners = Banner::orderBy('created_at', 'desc')->get();

        // Kirim data ke view
        return view('admin.pages.master.banners', compact('banners'));
    }

    /**
     * Menyimpan banner baru ke database
     * Validasi: maksimal 2 banner, gambar wajib diupload
     */
    public function store(Request $request)
    {
        // Cek apakah sudah ada 2 banner (maksimal)
        $bannerCount = Banner::count();
        if ($bannerCount >= 2) {
            return redirect()->back()
                ->with('error', 'Maksimal hanya 2 banner yang diperbolehkan. Hapus banner yang ada untuk menambahkan yang baru.');
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'promotion' => 'nullable|string|max:255',
        ], [
            'image.required' => 'Gambar banner wajib diupload',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar: JPEG, PNG, JPG, GIF, SVG',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'promotion.max' => 'Teks promosi maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Mohon periksa kembali data yang diisi');
        }

        try {
            // Upload gambar banner
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Generate nama file unik
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Simpan ke storage/app/public/banners
                $imagePath = $image->storeAs('banners', $imageName, 'public');

                // Simpan banner ke database
                Banner::create([
                    'image' => $imagePath,
                    'promotion' => $request->promotion,
                ]);

                return redirect()->route('admin.master.banners')
                    ->with('success', 'Banner berhasil ditambahkan!');
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengupload gambar');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan banner: ' . $e->getMessage());
        }
    }

    /**
     * Update data banner yang sudah ada
     * Bisa ganti gambar dan/atau teks promosi
     */
    public function update(Request $request, $id)
    {
        // Cari banner berdasarkan ID
        $banner = Banner::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'promotion' => 'nullable|string|max:255',
        ], [
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar: JPEG, PNG, JPG, GIF, SVG',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'promotion.max' => 'Teks promosi maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Mohon periksa kembali data yang diisi');
        }

        try {
            // Data yang mau diupdate
            $data = [
                'promotion' => $request->promotion,
            ];

            // Kalau upload gambar baru
            if ($request->hasFile('image')) {
                // Hapus gambar lama dari storage
                if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                    Storage::disk('public')->delete($banner->image);
                }

                // Upload gambar baru
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('banners', $imageName, 'public');

                $data['image'] = $imagePath;
            }

            // Update banner
            $banner->update($data);

            return redirect()->route('admin.master.banners')
                ->with('success', 'Banner berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui banner: ' . $e->getMessage());
        }
    }

    /**
     * Hapus banner dari database
     * Termasuk hapus gambar dari storage
     */
    public function destroy($id)
    {
        try {
            // Cari banner yang mau dihapus
            $banner = Banner::findOrFail($id);

            // Hapus gambar dari storage
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            // Hapus banner dari database
            $banner->delete();

            return redirect()->route('admin.master.banners')
                ->with('success', 'Banner berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus banner: ' . $e->getMessage());
        }
    }
}
