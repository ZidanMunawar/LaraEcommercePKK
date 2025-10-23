<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::orderBy('created_at', 'desc')->get();
        return view('admin.pages.users.admins', compact('admins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:admins,username|alpha_dash',
            'password' => 'required|string|min:6',
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:admins,email',
            'no_telp' => 'nullable|string|max:20',
            'role' => 'required|in:owner,admin,petugas',
            'status' => 'required|in:active,inactive',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.alpha_dash' => 'Username hanya boleh mengandung huruf, angka, dash, dan underscore.',
            'username.max' => 'Username maksimal 50 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max' => 'Nama lengkap maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'email.max' => 'Email maksimal 100 karakter.',
            'no_telp.max' => 'Nomor telepon maksimal 20 karakter.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role tidak valid.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        try {
            Admin::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'role' => $request->role,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.users.admins')
                ->with('success', 'Admin berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('admins', 'username')->ignore($id, 'id_admin')
            ],
            'password' => 'nullable|string|min:6',
            'nama_lengkap' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('admins', 'email')->ignore($id, 'id_admin')
            ],
            'no_telp' => 'nullable|string|max:20',
            'role' => 'required|in:owner,admin,petugas',
            'status' => 'required|in:active,inactive',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.alpha_dash' => 'Username hanya boleh mengandung huruf, angka, dash, dan underscore.',
            'username.max' => 'Username maksimal 50 karakter.',
            'password.min' => 'Password minimal 6 karakter.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max' => 'Nama lengkap maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'email.max' => 'Email maksimal 100 karakter.',
            'no_telp.max' => 'Nomor telepon maksimal 20 karakter.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role tidak valid.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        try {
            $data = [
                'username' => $request->username,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'role' => $request->role,
                'status' => $request->status,
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $admin->update($data);

            return redirect()->route('admin.users.admins')
                ->with('success', 'Admin berhasil diperbarui.');
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
            // Prevent deleting current logged in admin
            if (auth('admin')->id() == $id) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus akun yang sedang login.');
            }

            $admin = Admin::findOrFail($id);
            $admin->delete();

            return redirect()->route('admin.users.admins')
                ->with('success', 'Admin berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
