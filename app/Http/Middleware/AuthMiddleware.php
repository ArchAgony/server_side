<?php

namespace App\Http\Middleware;

use App\Models\Auth;
use App\Models\LoginToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->query('token');
        $user = LoginToken::where('token', $token)->first();
        if (!$token) {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }

        $request->merge(['authenticated_user' => $user->user]);
        return $next($request);
    }
}
