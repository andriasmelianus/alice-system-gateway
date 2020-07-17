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
        // Dapatkan token dari request.
        $token = $request->bearerToken();
        $credentials = null;

        if (!$token) {
            // Token tidak ada.
            return response()->json([
                'error' => 'Token not provided'
            ], 401);
        }

        try {
            // Coba decode token yang dikirimkan.
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            // Token sudah tidak berlaku.
            return response()->json([
                'error' => 'Token is expired'
            ], 400);
        } catch (Exception $e) {
            // Exception lainnya yang menggagalkan proses decode token.
            return response()->json([
                'error' => 'An error while decoding token'
            ], 400);
        }

        // Token berhasil didecode. Ambil ID user yang tersimpan dan pasangkan pada variabel $request->auth.
        $user = \App\User::withoutGlobalScope(new UserScope)->find($credentials->sub);
        $user['permission'] = \DB::table('v_user_permission')->where('id', $user['id'])->get();
        $request->auth = $user;

        return $next($request);
    }
}
