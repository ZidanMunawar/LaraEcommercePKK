<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;
use App\Models\Admin;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Get last logged in user email from cookie
        $lastEmail = Cookie::get('last_admin_email');
        return view('admin.auth.login', compact('lastEmail'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek apakah user ada
        $admin = Admin::where('email', $request->email)->first();

        // Jika user tidak ditemukan
        if (!$admin) {
            throw ValidationException::withMessages([
                'email' => ['Email tidak terdaftar.'],
            ]);
        }

        // Cek apakah user status inactive
        if ($admin->status === 'inactive') {
            throw ValidationException::withMessages([
                'email' => ['Akun Anda sedang tidak aktif. Silakan hubungi administrator.'],
            ]);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Save last logged in email to cookie for 15 days
            Cookie::queue('last_admin_email', $request->email, 21600); // 15 days in minutes

            return redirect()->intended('/admin/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function clearLastLogin()
    {
        Cookie::queue(Cookie::forget('last_admin_email'));
        return redirect()->back();
    }
}
