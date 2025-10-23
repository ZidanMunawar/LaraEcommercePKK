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
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = Slide::with('promotion')->orderBy('created_at', 'desc')->get();
        $promotions = Promotion::orderBy('name', 'asc')->get();
        return view('admin.pages.master.slides', compact('slides', 'promotions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if already have 4 slides
        $slideCount = Slide::count();
        if ($slideCount >= 4) {
            return redirect()->back()->with('error', 'Maksimal hanya 4 slides yang diperbolehkan. Hapus slide yang ada untuk menambahkan yang baru.');
        }

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'promotion_id' => 'nullable|exists:promotions,id',
        ], [
            'image.required' => 'Gambar slide wajib diupload.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'promotion_id.exists' => 'Promotion tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        try {
            // Upload image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('slides', $imageName, 'public');

                // Create slide
                Slide::create([
                    'image' => $imagePath,
                    'promotion_id' => $request->promotion_id,
                ]);

                return redirect()->route('admin.master.slides')
                    ->with('success', 'Slide berhasil ditambahkan.');
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupload gambar.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $slide = Slide::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'promotion_id' => 'nullable|exists:promotions,id',
        ], [
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'promotion_id.exists' => 'Promotion tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        try {
            $data = [
                'promotion_id' => $request->promotion_id,
            ];

            // Check if new image is uploaded
            if ($request->hasFile('image')) {
                // Delete old image
                if ($slide->image && Storage::disk('public')->exists($slide->image)) {
                    Storage::disk('public')->delete($slide->image);
                }

                // Upload new image
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('slides', $imageName, 'public');

                $data['image'] = $imagePath;
            }

            // Update slide
            $slide->update($data);

            return redirect()->route('admin.master.slides')
                ->with('success', 'Slide berhasil diperbarui.');
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
            $slide = Slide::findOrFail($id);

            // Delete image from storage
            if ($slide->image && Storage::disk('public')->exists($slide->image)) {
                Storage::disk('public')->delete($slide->image);
            }

            // Delete slide
            $slide->delete();

            return redirect()->route('admin.master.slides')
                ->with('success', 'Slide berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
