<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login dan memiliki role user biasa
        if (!Auth::check()) {
            return redirect()->route('login')->with('failed', 'Anda harus login terlebih dahulu!');
        }

        if (Auth::user()->role !== 'calon_santri') {
        abort(403, 'Akses ditolak.');
        }



        return $next($request);
    }
}
