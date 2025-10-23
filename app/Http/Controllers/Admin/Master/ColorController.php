<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('admin.pages.master.colors', compact('colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:colors,name',
            'code' => 'required|string|max:7',
        ]);

        Color::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        return redirect()->route('admin.master.colors')->with('success', 'Color added successfully.');
    }

    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return view('admin.modal.master.colors.edit', compact('color'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:colors,name,' . $id,
            'code' => 'required|string|max:7',
        ]);

        $color = Color::findOrFail($id);
        $color->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        return redirect()->route('admin.master.colors')->with('success', 'Color updated successfully.');
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        return redirect()->route('admin.master.colors')->with('success', 'Color deleted successfully.');
    }
}
