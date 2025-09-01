<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Menangani permintaan otentikasi yang masuk.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input dari form
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. Mencoba untuk mengotentikasi pengguna
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            // Jika gagal, kembalikan ke halaman login dengan pesan error
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // 3. Jika berhasil, buat ulang session untuk keamanan
        $request->session()->regenerate();

        // 4. Arahkan pengguna berdasarkan perannya (role)
        if ($request->user()->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($request->user()->role === 'pelanggan') {
            return redirect()->intended(route('pelanggan.dashboard'));
        }
        
        // Fallback jika peran tidak terdefinisi
        return redirect()->intended('/');
    }

    /**
     * Menghancurkan sesi yang terotentikasi (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}


