<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek 2 hal:
        // 1. Dia udah login BELUM?
        // 2. Kalo udah login, role-nya 'admin' BUKAN?
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // Kalo salah satu gagal, tendang dia
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        // if admin, proceed
        return $next($request);
    }
}
