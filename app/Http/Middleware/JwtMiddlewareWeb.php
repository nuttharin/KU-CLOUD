<?php

    namespace App\Http\Middleware;

    use Closure;
    use JWTAuth;
    use Exception;
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
        {   try{   
                $token = isset($_COOKIE["token"])?$_COOKIE["token"]:"";
                
                $request->headers->set("Authorization", "Bearer $token");//this is working
                $response = $next($request);
                $user = JWTAuth::parseToken()->authenticate();
            } catch (Exception $e){
                return redirect('/Auth');
            } 
            
            return $response;
        }
    }