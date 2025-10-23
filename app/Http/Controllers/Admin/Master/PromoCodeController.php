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
     * Display a listing of the resource.
     */
    public function index()
    {
        $promocodes = PromoCode::orderBy('created_at', 'desc')->get();
        return view('admin.pages.master.promocodes', compact('promocodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:promocodes,code|alpha_dash',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'discount' => 'required|numeric|min:0|max:999999.99',
            'expires_at' => 'required|date|after:now',
        ], [
            'code.required' => 'Kode promo wajib diisi.',
            'code.unique' => 'Kode promo sudah digunakan.',
            'code.alpha_dash' => 'Kode promo hanya boleh mengandung huruf, angka, dash, dan underscore.',
            'code.max' => 'Kode promo maksimal 50 karakter.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'discount.required' => 'Diskon wajib diisi.',
            'discount.numeric' => 'Diskon harus berupa angka.',
            'discount.min' => 'Diskon minimal 0.',
            'discount.max' => 'Diskon maksimal 999999.99.',
            'expires_at.required' => 'Tanggal kadaluarsa wajib diisi.',
            'expires_at.date' => 'Format tanggal tidak valid.',
            'expires_at.after' => 'Tanggal kadaluarsa harus setelah waktu sekarang.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        try {
            $data = [
                'code' => strtoupper($request->code),
                'discount' => $request->discount,
                'expires_at' => $request->expires_at,
            ];

            // Upload image if exists
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('promocodes', $imageName, 'public');
                $data['image'] = $imagePath;
            }

            PromoCode::create($data);

            return redirect()->route('admin.master.promocodes')
                ->with('success', 'Promo code berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $promocode = PromoCode::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|alpha_dash|unique:promocodes,code,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'discount' => 'required|numeric|min:0|max:999999.99',
            'expires_at' => 'required|date|after:now',
        ], [
            'code.required' => 'Kode promo wajib diisi.',
            'code.unique' => 'Kode promo sudah digunakan.',
            'code.alpha_dash' => 'Kode promo hanya boleh mengandung huruf, angka, dash, dan underscore.',
            'code.max' => 'Kode promo maksimal 50 karakter.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'discount.required' => 'Diskon wajib diisi.',
            'discount.numeric' => 'Diskon harus berupa angka.',
            'discount.min' => 'Diskon minimal 0.',
            'discount.max' => 'Diskon maksimal 999999.99.',
            'expires_at.required' => 'Tanggal kadaluarsa wajib diisi.',
            'expires_at.date' => 'Format tanggal tidak valid.',
            'expires_at.after' => 'Tanggal kadaluarsa harus setelah waktu sekarang.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        try {
            $data = [
                'code' => strtoupper($request->code),
                'discount' => $request->discount,
                'expires_at' => $request->expires_at,
            ];

            // Check if new image is uploaded
            if ($request->hasFile('image')) {
                // Delete old image
                if ($promocode->image && Storage::disk('public')->exists($promocode->image)) {
                    Storage::disk('public')->delete($promocode->image);
                }

                // Upload new image
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('promocodes', $imageName, 'public');
                $data['image'] = $imagePath;
            }

            $promocode->update($data);

            return redirect()->route('admin.master.promocodes')
                ->with('success', 'Promo code berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $promocode = PromoCode::findOrFail($id);

            // Delete image from storage
            if ($promocode->image && Storage::disk('public')->exists($promocode->image)) {
                Storage::disk('public')->delete($promocode->image);
            }

            $promocode->delete();

            return redirect()->route('admin.master.promocodes')
                ->with('success', 'Promo code berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
