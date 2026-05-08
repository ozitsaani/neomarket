<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User belum login.',
                ], 401);
            }

            return redirect()->route('login');
        }

        if ($request->user()->role !== $role) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Role tidak sesuai.',
                ], 403);
            }

            abort(403, 'Akses ditolak. Role tidak sesuai.');
        }

        return $next($request);
    }
}