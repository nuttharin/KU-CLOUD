<?php

    namespace App\Http\Middleware;

    use Closure;
    use JWTAuth;
    use Exception;
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
            try {
                $user = JWTAuth::parseToken()->authenticate();
                if($request->cookie('token') != ''){
                    $request->headers->set("Authorization", "Bearer ".$request->cookie('token'));
                    $response = $next($request);
                    return $response;
                }
            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    return response()->json(['status' => 'Token is Invalid']);
                }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    // If the token is expired, then it will be refreshed and added to the headers
                    try
                    {
                        $refreshed = JWTAuth::refresh(JWTAuth::getToken());
                        $response->header('Authorization', 'Bearer ' . $refreshed);
                    }
                    catch (JWTException $e)
                    {
                        return response()->json(['status' => 'Token is Expired']);
                    }
                    $user = JWTAuth::setToken($refreshed)->toUser();
                   
                }else{
                    return response()->json(['status' => 'Authorization Token not found']);
                }
            }       
            
            return $next($request);
        }
    }