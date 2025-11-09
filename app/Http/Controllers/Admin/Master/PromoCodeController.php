<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PromoCodeController extends Controller
{
    /**
     * Menampilkan halaman daftar kode promo
     * Kode promo digunakan customer untuk mendapatkan diskon saat checkout
     */
    public function index()
    {
        // Ambil semua kode promo, urutkan dari yang terbaru
        $promocodes = PromoCode::orderBy('created_at', 'desc')->get();

        // Kirim data ke view
        return view('admin.pages.master.promocodes', compact('promocodes'));
    }

    /**
     * Menyimpan kode promo baru ke database
     * Input: kode, gambar (opsional), diskon, tipe diskon, minimal pembelian, tanggal kadaluarsa
     */
    public function store(Request $request)
    {
        // ✅ VALIDASI DINAMIS: Max discount tergantung tipe
        $maxDiscount = $request->discount_type === 'percentage' ? 100 : 999999999;

        // Validasi input
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:promocodes,code|alpha_dash',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'discount' => 'required|integer|min:0|max:' . $maxDiscount,
            'discount_type' => 'required|in:percentage,fixed',
            'min_purchase' => 'nullable|integer|min:0',
            'expires_at' => 'required|date|after:now',
        ], [
            'code.required' => 'Kode promo wajib diisi',
            'code.unique' => 'Kode promo sudah digunakan',
            'code.alpha_dash' => 'Kode promo hanya boleh huruf, angka, dash (-), dan underscore (_)',
            'code.max' => 'Kode promo maksimal 50 karakter',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar: JPEG, PNG, JPG, GIF, SVG',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'discount.required' => 'Diskon wajib diisi',
            'discount.integer' => 'Diskon harus berupa angka bulat',
            'discount.min' => 'Diskon minimal 0',
            'discount.max' => $request->discount_type === 'percentage'
                ? 'Persentase diskon maksimal 100%'
                : 'Diskon maksimal 999,999,999',
            'discount_type.required' => 'Tipe diskon wajib dipilih',
            'discount_type.in' => 'Tipe diskon harus percentage atau fixed',
            'min_purchase.integer' => 'Minimal pembelian harus berupa angka bulat',
            'min_purchase.min' => 'Minimal pembelian tidak boleh negatif',
            'expires_at.required' => 'Tanggal kadaluarsa wajib diisi',
            'expires_at.date' => 'Format tanggal tidak valid',
            'expires_at.after' => 'Tanggal kadaluarsa harus setelah waktu sekarang',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        // ✅ VALIDASI TAMBAHAN: Cek persentase tidak lebih dari 100
        if ($request->discount_type === 'percentage' && $request->discount > 100) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Persentase diskon tidak boleh lebih dari 100%');
        }

        try {
            // Data yang mau disimpan
            $data = [
                'code' => strtoupper($request->code), // Convert ke uppercase
                'discount' => (int) $request->discount, // Cast ke integer
                'discount_type' => $request->discount_type,
                'min_purchase' => (int) ($request->min_purchase ?? 0), // Cast ke integer
                'expires_at' => $request->expires_at,
            ];

            // Upload gambar kalau ada
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Generate nama file unik
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Simpan ke storage/app/public/promocodes
                $imagePath = $image->storeAs('promocodes', $imageName, 'public');
                $data['image'] = $imagePath;
            }

            // Simpan kode promo
            PromoCode::create($data);

            return redirect()->route('admin.master.promocodes')
                ->with('success', 'Kode promo berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan kode promo: ' . $e->getMessage());
        }
    }

    /**
     * Update data kode promo yang sudah ada
     * Bisa ganti kode, gambar, diskon, tipe diskon, minimal pembelian, atau tanggal kadaluarsa
     */
    public function update(Request $request, $id)
    {
        // Cari kode promo berdasarkan ID
        $promocode = PromoCode::findOrFail($id);

        // ✅ VALIDASI DINAMIS: Max discount tergantung tipe
        $maxDiscount = $request->discount_type === 'percentage' ? 100 : 999999999;

        // Validasi input (kecuali ID yang sedang diedit)
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|alpha_dash|unique:promocodes,code,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'discount' => 'required|integer|min:0|max:' . $maxDiscount,
            'discount_type' => 'required|in:percentage,fixed',
            'min_purchase' => 'nullable|integer|min:0',
            'expires_at' => 'required|date|after:now',
        ], [
            'code.required' => 'Kode promo wajib diisi',
            'code.unique' => 'Kode promo sudah digunakan',
            'code.alpha_dash' => 'Kode promo hanya boleh huruf, angka, dash (-), dan underscore (_)',
            'code.max' => 'Kode promo maksimal 50 karakter',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar: JPEG, PNG, JPG, GIF, SVG',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'discount.required' => 'Diskon wajib diisi',
            'discount.integer' => 'Diskon harus berupa angka bulat',
            'discount.min' => 'Diskon minimal 0',
            'discount.max' => $request->discount_type === 'percentage'
                ? 'Persentase diskon maksimal 100%'
                : 'Diskon maksimal 999,999,999',
            'discount_type.required' => 'Tipe diskon wajib dipilih',
            'discount_type.in' => 'Tipe diskon harus percentage atau fixed',
            'min_purchase.integer' => 'Minimal pembelian harus berupa angka bulat',
            'min_purchase.min' => 'Minimal pembelian tidak boleh negatif',
            'expires_at.required' => 'Tanggal kadaluarsa wajib diisi',
            'expires_at.date' => 'Format tanggal tidak valid',
            'expires_at.after' => 'Tanggal kadaluarsa harus setelah waktu sekarang',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        // ✅ VALIDASI TAMBAHAN: Cek persentase tidak lebih dari 100
        if ($request->discount_type === 'percentage' && $request->discount > 100) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Persentase diskon tidak boleh lebih dari 100%');
        }

        try {
            // Data yang mau diupdate
            $data = [
                'code' => strtoupper($request->code),
                'discount' => (int) $request->discount, // Cast ke integer
                'discount_type' => $request->discount_type,
                'min_purchase' => (int) ($request->min_purchase ?? 0), // Cast ke integer
                'expires_at' => $request->expires_at,
            ];

            // Kalau upload gambar baru
            if ($request->hasFile('image')) {
                // Hapus gambar lama dari storage
                if ($promocode->image && Storage::disk('public')->exists($promocode->image)) {
                    Storage::disk('public')->delete($promocode->image);
                }

                // Upload gambar baru
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('promocodes', $imageName, 'public');
                $data['image'] = $imagePath;
            }

            // Update kode promo
            $promocode->update($data);

            return redirect()->route('admin.master.promocodes')
                ->with('success', 'Kode promo berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui kode promo: ' . $e->getMessage());
        }
    }

    /**
     * Hapus kode promo dari database
     * Termasuk hapus gambar dari storage
     */
    public function destroy($id)
    {
        try {
            // Cari kode promo yang mau dihapus
            $promocode = PromoCode::findOrFail($id);

            // Hapus gambar dari storage
            if ($promocode->image && Storage::disk('public')->exists($promocode->image)) {
                Storage::disk('public')->delete($promocode->image);
            }

            // Simpan kode promo (buat pesan sukses)
            $promoCode = $promocode->code;

            // Hapus kode promo dari database
            $promocode->delete();

            return redirect()->route('admin.master.promocodes')
                ->with('success', "Kode promo '{$promoCode}' berhasil dihapus!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus kode promo: ' . $e->getMessage());
        }
    }
}
