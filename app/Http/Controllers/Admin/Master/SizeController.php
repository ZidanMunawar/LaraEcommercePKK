<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();
        return view('admin.pages.master.sizes', compact('sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'size' => 'required|string|max:20|unique:sizes,size',
        ]);

        Size::create([
            'size' => $request->size,
        ]);

        return redirect()->route('admin.master.sizes')->with('success', 'Size added successfully.');
    }

    public function edit($id)
    {
        $size = Size::findOrFail($id);
        return view('admin.modal.master.sizes.edit', compact('size'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'size' => 'required|string|max:20|unique:sizes,size,' . $id,
        ]);

        $size = Size::findOrFail($id);
        $size->update([
            'size' => $request->size,
        ]);

        return redirect()->route('admin.master.sizes')->with('success', 'Size updated successfully.');
    }

    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return redirect()->route('admin.master.sizes')->with('success', 'Size deleted successfully.');
    }
}
