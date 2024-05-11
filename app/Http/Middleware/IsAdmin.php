<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->role == "admin")
                    return $next($request);
            }
            return response()->json([
                'error' => 'Unauthorized'
            ], 403);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'error' => 'Unauthorized'
            ], 403);
        }
}}
