<?php

    namespace App\Http\Middleware;

    use Closure;
    use JWTAuth;
    use Exception;
    use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
    use Cache;
    use Carbon\Carbon;

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
                $token = isset($_COOKIE["token"]) ? $_COOKIE["token"]:"";
                
                $request->headers->set("Authorization", "Bearer $token");//this is working
                $response = $next($request);
                $user = JWTAuth::parseToken()->authenticate();
                if(!$user){
                    return redirect('/Auth');
                }
                else{
                    //$expiresAt = Carbon::now()->addMinutes(2);
                    //Cache::put('user-is-online-'.$user->user_id,true,$expiresAt);
                }
            } catch (Exception $e){
                return redirect('/Auth');
            } 
            return $response;
        }
    }