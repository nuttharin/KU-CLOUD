<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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
        $response = $next($request);
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!empty($request->cookie('token'))) {
                if (strcmp($user->getRememberToken(), $request->cookie('token'))) {
                    return response()->json(['status' => 'Token is Invalid']);
                }
            } else if (!empty($request->header('Authorization'))) {
                if (strcmp($user->getRememberToken(), $request->header('Authorization'))) {
                    return response()->json(['status' => 'Token is Invalid']);
                }
            }

            if ($request->cookie('token') != '') {
                $request->headers->set("Authorization", "Bearer " . $request->cookie('token'));
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => 'Token is Invalid']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                //If the token is expired, then it will be refreshed and added to the headers
                try
                {
                    $refreshed = auth()->refresh();
                    $response = $next($request);
                    $response->headers->set('Authorization', 'Bearer ' . $refreshed);
                    //header('Authorization: Bearer ' . $refreshed);
                } catch (JWTException $e) {
                    return response()->json(['status' => 'Token is Expired']);
                }

                $user = JWTAuth::parseToken()->authenticate();

            } else {
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }

        Auth::login($user, false);
        return $response;
    }
}
