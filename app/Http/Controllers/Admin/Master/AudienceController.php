<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Audience;
use Illuminate\Http\Request;

class AudienceController extends Controller
{
    public function index()
    {
        $audiences = Audience::all();
        return view('admin.pages.master.audiences', compact('audiences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:audiences,name',
        ]);

        Audience::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.master.audiences')->with('success', 'Audience added successfully.');
    }

    public function edit($id)
    {
        $audience = Audience::findOrFail($id);
        return view('admin.modal.audiences.edit', compact('audience'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:audiences,name,' . $id,
        ]);

        $audience = Audience::findOrFail($id);
        $audience->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.master.audiences')->with('success', 'Audience updated successfully.');
    }

    public function destroy($id)
    {
        try {
            $audience = Audience::findOrFail($id);
            $audience->delete();

            return redirect()->route('admin.master.audiences')->with('success', 'Audience deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.master.audiences')->with('error', 'Failed to delete audience. Please try again.');
        }
    }
}
