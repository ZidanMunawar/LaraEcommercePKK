<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::all();
        return view('admin.pages.master.promotions', compact('promotions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
        ]);

        Promotion::create($request->all());

        return redirect()->route('admin.master.promotions')->with('success', 'Promotion added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
        ]);

        $promotion = Promotion::findOrFail($id);
        $promotion->update($request->all());

        return redirect()->route('admin.master.promotions')->with('success', 'Promotion updated successfully.');
    }

    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();

        return redirect()->route('admin.master.promotions')->with('success', 'Promotion deleted successfully.');
    }
}
