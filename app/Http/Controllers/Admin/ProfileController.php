<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil admin yang sedang login
     * - Menampilkan foto profil (avatar)
     * - Menampilkan info lengkap: username, email, nama, role, status
     * - Form untuk edit profil dan ganti password
     */
    public function index()
    {
        // Ambil data admin yang sedang login
        $admin = auth('admin')->user();

        return view('admin.pages.profile', compact('admin'));
    }

    /**
     * Update informasi profil admin
     * - Update username, nama lengkap, email, no telepon
     * - Username & email harus unik (tidak boleh dipakai admin lain)
     * - Validasi lengkap dengan custom message Indonesia
     */
    public function update(Request $request)
    {
        $admin = auth('admin')->user();

        // Validasi input dengan Rule::unique untuk ignore ID admin yang sedang login
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('admins', 'username')->ignore($admin->id_admin, 'id_admin')
            ],
            'nama_lengkap' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('admins', 'email')->ignore($admin->id_admin, 'id_admin')
            ],
            'no_telp' => 'nullable|string|max:20',
        ], [
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan oleh admin lain',
            'username.alpha_dash' => 'Username hanya boleh mengandung huruf, angka, dash (-), dan underscore (_)',
            'username.max' => 'Username maksimal 50 karakter',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nama_lengkap.max' => 'Nama lengkap maksimal 100 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan oleh admin lain',
            'email.max' => 'Email maksimal 100 karakter',
            'no_telp.max' => 'Nomor telepon maksimal 20 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        try {
            // Update data profil admin
            $admin->update([
                'username' => $request->username,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
            ]);

            return redirect()->route('admin.profile')
                ->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    /**
     * Update password admin
     * - Validasi password saat ini (harus benar)
     * - Password baru minimal 6 karakter
     * - Konfirmasi password harus sama
     */
    public function updatePassword(Request $request)
    {
        $admin = auth('admin')->user();

        // Validasi input password
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password baru minimal 6 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', $validator->errors()->first());
        }

        // Cek apakah password saat ini benar
        if (!Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()
                ->with('error', 'Password saat ini tidak sesuai!');
        }

        try {
            // Update password baru (hash dulu untuk keamanan)
            $admin->update([
                'password' => Hash::make($request->new_password),
            ]);

            return redirect()->route('admin.profile')
                ->with('success', 'Password berhasil diubah!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengubah password: ' . $e->getMessage());
        }
    }

    /**
     * Update foto profil (avatar) admin
     * - Upload gambar baru ke storage/app/public/avatars
     * - Hapus avatar lama jika ada
     * - Validasi: hanya gambar (jpg, png, jpeg) maks 2MB
     */
    public function updateAvatar(Request $request)
    {
        $admin = auth('admin')->user();

        // Validasi file avatar
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'avatar.required' => 'Foto profil wajib dipilih',
            'avatar.image' => 'File harus berupa gambar',
            'avatar.mimes' => 'Format gambar harus JPG, PNG, atau JPEG',
            'avatar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', $validator->errors()->first());
        }

        try {
            // Hapus avatar lama jika ada
            if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
                Storage::disk('public')->delete($admin->avatar);
            }

            // Upload avatar baru
            $avatar = $request->file('avatar');

            // Generate nama file unik (timestamp + unique ID + extension)
            $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();

            // Simpan ke storage/app/public/avatars
            $avatarPath = $avatar->storeAs('avatars', $avatarName, 'public');

            // Update field avatar di database
            $admin->update([
                'avatar' => $avatarPath,
            ]);

            return redirect()->route('admin.profile')
                ->with('success', 'Foto profil berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui foto profil: ' . $e->getMessage());
        }
    }

    /**
     * Hapus foto profil (avatar) admin
     * - Menghapus file avatar dari storage
     * - Set field avatar di database jadi null
     */
    public function deleteAvatar()
    {
        $admin = auth('admin')->user();

        try {
            // Hapus file avatar dari storage
            if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
                Storage::disk('public')->delete($admin->avatar);
            }

            // Set avatar jadi null
            $admin->update([
                'avatar' => null,
            ]);

            return redirect()->route('admin.profile')
                ->with('success', 'Foto profil berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus foto profil: ' . $e->getMessage());
        }
    }
}
