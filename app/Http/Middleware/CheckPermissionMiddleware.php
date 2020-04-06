<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;

class CheckPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $userSpecials = Arr::pluck($request->auth->permission, 'special');
        $userSlugs = Arr::pluck($request->auth->permission, 'slug');

        if(in_array('nothing', $userSpecials)){
            return response()->json([
                'error' => "Anda tidak memiliki akses."
            ],403);
        }

        if(!in_array('everything', $userSpecials)){
            if(!in_array($permission, $userSlugs)){
                return response()->json([
                    'error' => "Anda tidak memiliki akses."
                ],403);
            }
        }

        return $next($request);
    }
}
