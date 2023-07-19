<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Cek apakah pengguna telah login dan memiliki role "admin"
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Jika pengguna tidak memiliki role "admin", alihkan ke halaman lain atau tampilkan pesan error
        Alert::error('Error', 'Anda Bukan Admin');

        return redirect()->route('home');
    }
}
