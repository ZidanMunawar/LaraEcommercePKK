<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    // Menampilkan semua tags
    public function index()
    {
        $tags = Tag::all();  // Ambil semua tags
        return view('admin.pages.master.tags', compact('tags'));  // Kirim data tags ke view
    }

    // Menampilkan form untuk membuat tag baru
    public function create()
    {
        return view('admin.modals.master.tags.add');  // Modal untuk tambah tag
    }

    // Menyimpan tag baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:tags,name',
        ]);

        Tag::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.master.tags')->with('success', 'Tag added successfully.');
    }

    // Menampilkan form untuk mengedit tag
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return view('admin.modals.master.tags.edit', compact('tag'));  // Modal untuk edit tag
    }

    // Mengupdate tag
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:tags,name,' . $id,
        ]);

        $tag = Tag::findOrFail($id);
        $tag->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.master.tags')->with('success', 'Tag updated successfully.');
    }

    // Menghapus tag
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('admin.master.tags')->with('success', 'Tag deleted successfully.');
    }
}

