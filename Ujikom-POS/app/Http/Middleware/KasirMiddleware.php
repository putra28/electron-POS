<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class KasirMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
     {
         // Cek apakah session 'tb_petugas' ada
         if (!Session::has('tb_petugas')) {
             return redirect('/');
         }

         // Ambil role_petugas dari session
         $role = Session::get('tb_petugas')['role_user'];

         // Cek apakah peran pengguna adalah 'admin'
         if ($role !== 'kasir') {
            $request->session()->forget('tb_petugas');
            Auth::logout();
            return redirect('/');
         }

         return $next($request);
     }
}
