<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Ambil nilai dari header Role
        $role = $request->header('Role');

        // Tentukan akses berdasarkan role
        if ($role === 'admin') {
            // Izinkan akses penuh
            return $next($request);
        } elseif ($role === 'user') {
            // Cek apakah metode adalah GET
            if ($request->isMethod('get')) {
                return $next($request);
            } else {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        // Jika Role tidak ditemukan atau tidak valid
        return response()->json(['message' => 'Role not found or invalid'], 401);
    }
}