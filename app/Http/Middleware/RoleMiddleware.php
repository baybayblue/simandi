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
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  // Menggunakan ...$roles agar bisa menerima lebih dari satu peran
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Periksa apakah pengguna sudah login
        if (!Auth::check()) {
            // Jika belum, arahkan ke halaman login
            return redirect('login');
        }

        // 2. Periksa apakah peran pengguna cocok dengan salah satu peran yang diizinkan
        foreach ($roles as $role) {
            // Asumsi: Model User Anda memiliki properti/kolom bernama 'role'
            if ($request->user()->role == $role) {
                // Jika peran cocok, lanjutkan request
                return $next($request);
            }
        }

        // 3. Jika setelah diperiksa tidak ada peran yang cocok, tolak akses
        // Abort helper akan menampilkan halaman error (403 Forbidden)
        abort(403, 'AKSI TIDAK DIIZINKAN.');
    }
}
