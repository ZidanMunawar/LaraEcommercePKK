<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

class CustProfileController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.pages.profile', compact('customer'));
    }

    public function update(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:customers,email,' . $customer->id_customers . ',id_customers',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'province_name' => 'nullable|string|max:100',
            'regency_name' => 'nullable|string|max:100',
            'district_name' => 'nullable|string|max:100',
            'village_name' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan dalam mengupdate profil.');
        }

        try {
            $customer->update($request->all());
            return redirect()->route('customer.profile')->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan dalam mengubah password.');
        }

        $customer = Auth::guard('customer')->user();

        if (!Hash::check($request->current_password, $customer->password)) {
            return redirect()->back()->with('error', 'Password saat ini tidak sesuai.');
        }

        try {
            $customer->update([
                'password' => Hash::make($request->new_password)
            ]);

            return redirect()->route('customer.profile')->with('success', 'Password berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
