<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginCustController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        // Redirect jika sudah login
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.home');
        }

        return view('customer.auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Email or username is required',
            'password.required' => 'Password is required',
        ]);

        // Detect login type (email or username)
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password
        ];

        $remember = $request->filled('remember');

        // Attempt login
        if (Auth::guard('customer')->attempt($credentials, $remember)) {
            // Regenerate session untuk security
            $request->session()->regenerate();

            // Get customer name
            $customerName = Auth::guard('customer')->user()->nama_lengkap;

            // Redirect to intended page or home
            return redirect()->intended(route('customer.home'))
                ->with('success', 'Welcome back, ' . $customerName . '!');
        }

        // Login failed
        return back()
            ->withInput($request->only('login', 'remember'))
            ->withErrors([
                'login' => 'The provided credentials do not match our records.',
            ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        // Get customer name before logout
        $customerName = Auth::guard('customer')->user()->nama_lengkap ?? 'Customer';

        // Logout
        Auth::guard('customer')->logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Redirect to home with success message
        return redirect()->route('customer.home')
            ->with('success', 'Goodbye, ' . $customerName . '! You have been logged out successfully.');
    }
}
