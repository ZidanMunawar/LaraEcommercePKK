<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $userRole = auth('admin')->user()->role;

        if (!in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak! Role Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
