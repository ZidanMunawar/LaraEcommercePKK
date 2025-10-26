<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        // Redirect jika sudah login
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.home');
        }

        return view('customer.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:customers,username',
            'email' => 'required|email|max:100|unique:customers,email',
            'password' => 'required|string|min:6|confirmed',
            'nama_lengkap' => 'required|string|max:100',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string',
            // HAPUS semua *_code, KEEP cuma *_name
            'province_name' => 'required|string',
            'regency_name' => 'required|string',
            'district_name' => 'required|string',
            'village_name' => 'required|string',
            'postal_code' => 'nullable|string|max:10',
        ], [
            'username.required' => 'Username is required',
            'username.unique' => 'Username already taken',
            'email.required' => 'Email is required',
            'email.unique' => 'Email already registered',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
            'password.confirmed' => 'Password confirmation does not match',
            'nama_lengkap.required' => 'Full name is required',
            'no_telp.required' => 'Phone number is required',
            'alamat.required' => 'Address is required',
            'province_name.required' => 'Province is required',
            'regency_name.required' => 'City/Regency is required',
            'district_name.required' => 'District is required',
            'village_name.required' => 'Village is required',
        ]);

        try {
            $customer = Customer::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password, // Auto hashed by model mutator
                'nama_lengkap' => $request->nama_lengkap,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                // CUMA NAME AJA, HAPUS CODE
                'province_name' => $request->province_name,
                'regency_name' => $request->regency_name,
                'district_name' => $request->district_name,
                'village_name' => $request->village_name,
                'postal_code' => $request->postal_code,
            ]);

            // Auto login after register
            Auth::guard('customer')->login($customer);

            return redirect()->route('customer.home')
                ->with('success', 'Registration successful! Welcome to ZynHope Apparel!');

        } catch (\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Registration failed. Please try again.');
        }
    }
}
