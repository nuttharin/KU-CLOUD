<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\TB_EMAIL;
use App\TB_USERS;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use JWTFactory;
use Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $user = DB::select('SELECT TB_USERS.user_id,TB_USERS.password,TB_USERS.type_user,TB_EMAIL.email_user,TB_COMPANY.company_id FROM TB_USERS
                            LEFT JOIN TB_USER_COMPANY ON  TB_USER_COMPANY.user_id = TB_USERS.user_id
                            LEFT JOIN TB_COMPANY ON TB_COMPANY.company_id = TB_USER_COMPANY.company_id
                            INNER JOIN TB_EMAIL ON TB_EMAIL.user_id = TB_USERS.user_id
                            WHERE TB_EMAIL.email_user = ? AND is_verify = ? limit 1', [$request->get('email'), true]);
        if (!empty($user)) {
            $hash_password = $user[0]->password;
            if (Hash::check($request->get('password'), $hash_password)) {
                $user_custom = [
                    "email" => $request->get('email'),
                    "company_id" => empty($user[0]->company_id) ? -1 : $user[0]->company_id,
                    "type_user" => $user[0]->type_user,
                ];
                $factory = JWTFactory::customClaims([
                    'sub' => $user[0]->user_id,
                    'user' => $user_custom,
                ]);
                $payload = JWTFactory::make($factory);
                $token = JWTAuth::encode($payload);

                //Log::debug('An informational message.',['id'=>$user[0]->type_user]);
                //$payload = JWTAuth::decode($token);
                if ($user[0]->type_user == "ADMIN") {
                    return response()->json(['token' => $token->get(), 'path' => '/Admin/UsersAdminister', 'status' => 200], 200);
                } else if ($user[0]->type_user == "COMPANY") {
                    return response()->json(['token' => $token->get(), 'path' => '/Company/User', 'status' => 200], 200);
                } else if ($user[0]->type_user == "CUSTOMER") {
                    return response()->json(['token' => $token->get(), 'path' => '', 'status' => 200], 200);
                }

                //return response()->json(compact('payload'));
            } else {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }
        }
        return response()->json(['status' => 'error'], 500);

        /*$credentials = $request->only('email', 'password');
    try {

    if (! $token = JWTAuth::attempt($credentials)) {
    return response()->json(['error' => $token], 400);
    }
    } catch (JWTException $e) {
    return response()->json(['error' => 'could_not_create_token'], 500);
    }
    //$payload = JWTAuth::setToken($token)->getPayload();
    return response()->json(compact('token'));*/
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function resgister(Request $request)
    {
        $user = TB_USERS::create([
            'email' => $request->get('email'),
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'password' => Hash::make($request->get('password')),
            'type_user' => $request->get('type_user'),
        ]);
        dd($user);
    }

    public function verifyUser($verification_code, $email)
    {
        $check = DB::table('USER_VERIFICATIONS')->where('token', $verification_code)->first();
        if (!is_null($check)) {
            $email = TB_EMAIL::where('email_user', '=', $email);
            if ($user->is_verify == 1) {
                return response()->json([
                    'success' => true,
                    'message' => 'Account already verified..',
                ]);
            }
            $email->update(['is_verified' => 1]);
            DB::table('USER_VERIFICATIONS')->where('token', $verification_code)->delete();
            return response()->json([
                'success' => true,
                'message' => 'You have successfully verified your email address.',
            ]);
        }
        return response()->json(['success' => false, 'error' => "Verification code is invalid."]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
}
