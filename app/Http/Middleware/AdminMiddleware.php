<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Hanya mengizinkan user dengan role 'admin'.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Hanya admin yang diizinkan.',
                    'data'    => null,
                ], Response::HTTP_FORBIDDEN);
            }

            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }

        return $next($request);
    }
}
