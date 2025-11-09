<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SlideController extends Controller
{
    /**
     * Menampilkan halaman daftar slide
     * Slide adalah gambar carousel yang ditampilkan di halaman customer
     * Maksimal 4 slide
     */
    public function index()
    {
        // Ambil semua slide beserta relasi promotion-nya
        $slides = Slide::with('promotion')
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil semua promotion untuk dropdown di modal
        $promotions = Promotion::orderBy('name', 'asc')->get();

        // Kirim data ke view
        return view('admin.pages.master.slides', compact('slides', 'promotions'));
    }

    /**
     * Menyimpan slide baru ke database
     * Validasi: maksimal 4 slide, gambar wajib diupload
     */
    public function store(Request $request)
    {
        // Cek apakah sudah ada 4 slide (maksimal)
        $slideCount = Slide::count();
        if ($slideCount >= 4) {
            return redirect()->back()
                ->with('error', 'Maksimal hanya 4 slide yang diperbolehkan. Hapus slide yang ada untuk menambahkan yang baru.');
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'promotion_id' => 'nullable|exists:promotions,id',
        ], [
            'image.required' => 'Gambar slide wajib diupload',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar: JPEG, PNG, JPG, GIF, SVG',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'promotion_id.exists' => 'Promosi tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Mohon periksa kembali data yang diisi');
        }

        try {
            // Upload gambar slide
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Generate nama file unik
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Simpan ke storage/app/public/slides
                $imagePath = $image->storeAs('slides', $imageName, 'public');

                // Simpan slide ke database
                Slide::create([
                    'image' => $imagePath,
                    'promotion_id' => $request->promotion_id,
                ]);

                return redirect()->route('admin.master.slides')
                    ->with('success', 'Slide berhasil ditambahkan!');
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengupload gambar');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan slide: ' . $e->getMessage());
        }
    }

    /**
     * Update data slide yang sudah ada
     * Bisa ganti gambar dan/atau promotion
     */
    public function update(Request $request, $id)
    {
        // Cari slide berdasarkan ID
        $slide = Slide::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'promotion_id' => 'nullable|exists:promotions,id',
        ], [
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar: JPEG, PNG, JPG, GIF, SVG',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'promotion_id.exists' => 'Promosi tidak valid',
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
                'promotion_id' => $request->promotion_id,
            ];

            // Kalau upload gambar baru
            if ($request->hasFile('image')) {
                // Hapus gambar lama dari storage
                if ($slide->image && Storage::disk('public')->exists($slide->image)) {
                    Storage::disk('public')->delete($slide->image);
                }

                // Upload gambar baru
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('slides', $imageName, 'public');

                $data['image'] = $imagePath;
            }

            // Update slide
            $slide->update($data);

            return redirect()->route('admin.master.slides')
                ->with('success', 'Slide berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui slide: ' . $e->getMessage());
        }
    }

    /**
     * Hapus slide dari database
     * Termasuk hapus gambar dari storage
     */
    public function destroy($id)
    {
        try {
            // Cari slide yang mau dihapus
            $slide = Slide::findOrFail($id);

            // Hapus gambar dari storage
            if ($slide->image && Storage::disk('public')->exists($slide->image)) {
                Storage::disk('public')->delete($slide->image);
            }

            // Hapus slide dari database
            $slide->delete();

            return redirect()->route('admin.master.slides')
                ->with('success', 'Slide berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus slide: ' . $e->getMessage());
        }
    }
}
