<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Cookie;
use JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddlewareWeb extends BaseMiddleware
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
        try {
            $token = isset($_COOKIE["token"]) ? $_COOKIE["token"] : "";

            $request->headers->set("Authorization", "Bearer $token"); //this is working
            $response = $next($request);
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                Cookie::queue(Cookie::forget('token', '/', 'localhost'));
                return redirect('/');
            } else {
                //$expiresAt = Carbon::now()->addMinutes(2);
                //Cache::put('user-is-online-'.$user->user_id,true,$expiresAt);
            }
        } catch (Exception $e) {
            Cookie::queue(Cookie::forget('token', '/', 'localhost'));
            return redirect('/');
        }
        return $response;
    }
}
