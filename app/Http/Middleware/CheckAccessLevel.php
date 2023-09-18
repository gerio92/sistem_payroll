<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAccessLevel
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Cek apakah pengguna belum login (guest)
        if (!$user) {
            // Guest tidak diizinkan untuk mengakses semua rute kecuali login
            if (!$request->is('login')) {
                abort(403, 'Forbidden: Anda harus login untuk mengakses rute ini.');
            }
        } else {
            // Pengguna sudah login

            // Cek apakah pengguna adalah supervisor
            if ($user->level === 'supervisor') {
                // Pengguna adalah supervisor, izinkan akses ke semua rute
                return $next($request);
            }

            // Pengguna bukan supervisor, periksa apakah adalah staff atau bukan
            if ($user->level === 'staff') {
                // Pengguna adalah staff, cek rute yang diminta
                if ($request->is('slipgaji')) {
                    // Jika pengguna mencoba mengakses /report, tampilkan pesan 403
                    abort(403, 'Forbidden: Anda tidak memiliki akses ke rute ini.');
                } else {
                    // Jika pengguna mencoba mengakses rute lain, izinkan akses
                    return $next($request);
                }
            }

            // Jika pengguna adalah karyawan, arahkan ke error 403 dengan pesan khusus
            abort(403, 'Forbidden: Hubungi supervisor untuk mendapatkan akses.');
        }

        return $next($request);
    }
}
