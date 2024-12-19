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
    public function handle($request, Closure $next)
    {
        $token = $request->query('token') ?? $request->header('Authorization');
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized: Token not provided'
            ], 401);
        }

        $loginToken = LoginToken::where('token', $token)->first();
        if (!$loginToken) {
            return response()->json([
                'message' => 'unauthorized user'
            ], 401);
        }

        $request->merge(['authenticated_user' => $loginToken->user]);
        return $next($request);
    }
}
