<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. JIKA BELUM login, baru dilempar ke login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Ambil role user
        $userRole = Auth::user()->role->name;

        // 3. Cek apakah role diizinkan (Gunakan in_array dengan benar)
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Jika login tapi role tidak sesuai, block akses
        abort(403, 'Unauthorized action.');
    }
}