<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
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

        if (!$request->session()->has('user')) {
            return redirect('/');
        } else {
            $exp = $request->session()->get('token_exp');
            $totalDuration = Carbon::now()->diffInMinutes($exp->addMinutes(30));
            $token = isset($_COOKIE["token"]) ? $_COOKIE["token"] : "";
            Cookie::queue('token', $token, $totalDuration, null, null, false, false);
            // $request->headers->set("Authorization", "Bearer $token"); //this is working
            return $next($request);
        }

        // try {

        //     // if (!Auth::check()) {
        //     //     Cookie::queue(Cookie::forget('token', '/', 'localhost'));
        //     //     return redirect('/');
        //     // } else {
        //     //     $response = $next($request);
        //     //     //$expiresAt = Carbon::now()->addMinutes(2);
        //     //     //Cache::put('user-is-online-'.$user->user_id,true,$expiresAt);
        //     // }
        //     //dd($request->session()->get('user'));

        //     $token = isset($_COOKIE["token"]) ? $_COOKIE["token"] : "";

        //     $request->headers->set("Authorization", "Bearer $token"); //this is working

        //     $response = $next($request);

        //     $user = JWTAuth::parseToken()->authenticate();

        //     if (!$user) {
        //         Cookie::queue(Cookie::forget('token', '/', 'localhost'));
        //         return redirect('/');
        //     } else {
        //         //$expiresAt = Carbon::now()->addMinutes(2);
        //         //Cache::put('user-is-online-'.$user->user_id,true,$expiresAt);
        //     }

        // } catch (Exception $e) {
        //     if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
        //         // If the token is expired, then it will be refreshed and added to the headers
        //         try
        //         {
        //             $refreshed = JWTAuth::refresh($token);
        //             $request->headers->set("Authorization", "Bearer $refreshed"); //this is working
        //             $response = $next($request);
        //             Cookie::queue('token', $refreshed, 60);
        //         } catch (JWTException $e) {
        //             return response()->json(['status' => 'Token is Expired']);
        //         }

        //         $user = JWTAuth::parseToken()->authenticate();
        //         return $response;

        //     } else {
        //         Cookie::queue(Cookie::forget('token', '/', 'localhost'));
        //         return redirect('/');
        //     }
        // }
        // return $response;
    }
}
