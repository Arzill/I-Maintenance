<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class Usermiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah pengguna telah login dan memiliki role "user"
        if (auth()->check() && auth()->user()->role === 'user') {
            return $next($request);
        }

        // Jika pengguna tidak memiliki role "user", alihkan ke halaman lain atau tampilkan pesan error
        Alert::error('Error', 'Silahkan login terlebih dahulu');

        return redirect()->route('home');
    }
}