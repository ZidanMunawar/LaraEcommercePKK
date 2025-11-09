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
     * Menampilkan halaman daftar admin
     * - Menampilkan semua akun admin (owner, admin, petugas)
     * - Diurutkan dari yang terbaru
     */
    public function index()
    {
        // Ambil semua admin, urutkan dari yang terbaru dibuat
        $admins = Admin::orderBy('created_at', 'desc')->get();

        return view('admin.pages.users.admins', compact('admins'));
    }

    /**
     * Menyimpan admin baru ke database
     * - Validasi input lengkap dengan custom message Indonesia
     * - Hash password sebelum disimpan
     * - Username harus unik (tidak boleh sama)
     */
    public function store(Request $request)
    {
        // Validasi input dengan pesan error bahasa Indonesia
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:admins,username|alpha_dash',
            'password' => 'required|string|min:6',
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:admins,email',
            'no_telp' => 'nullable|string|max:20',
            'role' => 'required|in:owner,admin,petugas',
            'status' => 'required|in:active,inactive',
        ], [
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'username.alpha_dash' => 'Username hanya boleh mengandung huruf, angka, dash (-), dan underscore (_)',
            'username.max' => 'Username maksimal 50 karakter',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nama_lengkap.max' => 'Nama lengkap maksimal 100 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'email.max' => 'Email maksimal 100 karakter',
            'no_telp.max' => 'Nomor telepon maksimal 20 karakter',
            'role.required' => 'Role wajib dipilih',
            'role.in' => 'Role tidak valid',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        try {
            // Simpan admin baru ke database
            Admin::create([
                'username' => $request->username,
                'password' => Hash::make($request->password), // Hash password untuk keamanan
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'role' => $request->role,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.users.admins')
                ->with('success', 'Admin berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan admin: ' . $e->getMessage());
        }
    }

    /**
     * Update data admin yang sudah ada
     * - Username & email harus unik (kecuali milik admin yang sedang diedit)
     * - Password hanya diupdate jika diisi (opsional saat edit)
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        // Validasi dengan Rule::unique untuk mengabaikan ID yang sedang diedit
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('admins', 'username')->ignore($id, 'id_admin') // Ignore username admin ini
            ],
            'password' => 'nullable|string|min:6', // Nullable = opsional saat edit
            'nama_lengkap' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('admins', 'email')->ignore($id, 'id_admin') // Ignore email admin ini
            ],
            'no_telp' => 'nullable|string|max:20',
            'role' => 'required|in:owner,admin,petugas',
            'status' => 'required|in:active,inactive',
        ], [
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'username.alpha_dash' => 'Username hanya boleh mengandung huruf, angka, dash (-), dan underscore (_)',
            'username.max' => 'Username maksimal 50 karakter',
            'password.min' => 'Password minimal 6 karakter',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nama_lengkap.max' => 'Nama lengkap maksimal 100 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'email.max' => 'Email maksimal 100 karakter',
            'no_telp.max' => 'Nomor telepon maksimal 20 karakter',
            'role.required' => 'Role wajib dipilih',
            'role.in' => 'Role tidak valid',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        try {
            // Siapkan data yang akan diupdate
            $data = [
                'username' => $request->username,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'role' => $request->role,
                'status' => $request->status,
            ];

            // Hanya update password jika diisi (tidak kosong)
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // Update data admin
            $admin->update($data);

            return redirect()->route('admin.users.admins')
                ->with('success', 'Admin berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui admin: ' . $e->getMessage());
        }
    }

    /**
     * Hapus admin dari database
     * - Mencegah admin menghapus akun sendiri
     * - Soft delete / hard delete tergantung konfigurasi model
     */
    public function destroy($id)
    {
        try {
            // Cek apakah admin yang mau dihapus adalah diri sendiri
            if (auth('admin')->id() == $id) {
                return redirect()->back()
                    ->with('error', 'Tidak dapat menghapus akun Anda sendiri yang sedang login!');
            }

            // Cari admin berdasarkan ID
            $admin = Admin::findOrFail($id);

            // Simpan username untuk pesan sukses
            $username = $admin->username;

            // Hapus admin
            $admin->delete();

            return redirect()->route('admin.users.admins')
                ->with('success', "Admin '{$username}' berhasil dihapus!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus admin: ' . $e->getMessage());
        }
    }
}
