<?php

namespace App\Http\Middleware;

use App\Models\Scopes\UserScope;
use Closure;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // $token = $request->get('token');
        $token = $request->bearerToken();
        $credentials = null;

        if(!$token){
            return response()->json([
                'error' => 'Token not provided'
            ], 401);
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            return response()->json([
                'error' => 'Token is expired'
            ],400);
        } catch (Exception $e){
            return response()->json([
                'error' => 'An error while decoding token'
            ],400);
        }

        $user = \App\User::withoutGlobalScope(new UserScope)->find($credentials->sub);

        $request->auth = $user;

        return $next($request);
    }
}
