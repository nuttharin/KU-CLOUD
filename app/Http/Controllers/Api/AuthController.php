<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\TB_EMAIL;
use App\TB_USERS;
use App\USER_FIRST_CREATE;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use JWTFactory;
use Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = TB_USERS::where([
                ['username', '=', $request->get('username')],
            ])->first();

            if (!empty($user) && $user->email()->where('is_primary', true)->first()->is_verify) {

                $checkFirstCreate = $user->checkFirstCreate()->first();

                if (!empty($checkFirstCreate)) {
                    return response()->json(['path' => '/Auth/ResetPasswordFirst/' . $checkFirstCreate->user_id . '/' . $checkFirstCreate->token, 'status' => 200], 200);
                }

                $hash_password = $user->password;
                if (Hash::check($request->get('password'), $hash_password)) {
                    $user_custom = [
                        "user_id" => $user->user_id,
                        "username" => $user->username,
                        "fname" => $user->fname,
                        "lname" => $user->lname,
                        "email" => $user->email()->where('is_primary', true)->first()->email_user,
                        "img_profile" => $user->img_profile,
                        "type_user" => $user->type_user,
                    ];
                    if ($user->type_user === "CUSTOMER") {
                        $user_custom['compay_id'] = $user->user_customer()->get();
                        $user_custom['sub_type_user'] = "";
                    } else {
                        $user_custom['sub_type_user'] = $user->user_company()->first()->sub_type_user;
                        $user_custom['compay_id'] = $user->user_company()->first()->company_id;
                    }
                    $factory = JWTFactory::customClaims([
                        'sub' => $user->user_id,
                        'user' => $user_custom,
                    ]);
                    $payload = JWTFactory::make($factory);
                    $token = JWTAuth::encode($payload);

                    //Log::debug('An informational message.',['id'=>$user[0]->type_user]);
                    //$payload = JWTAuth::decode($token);

                    $data = json_encode(['user_id' => $user->user_id]);
                    $token_id = uniqid();
                    $signature = hash_hmac("sha256", $token_id . "." . $data . "." . $hash_password, config('app.SOCKET_KEY'));
                    $socket_token = \base64_encode($token_id . "." . $data . "." . $signature);

                    if ($user->type_user == "ADMIN") {
                        return response()->json(['token' => $token->get(), 'socket_token' => $socket_token, 'user' => $user_custom, 'path' => '/User/Administer', 'status' => 200], 200)->header('Content-Type', 'application/json');
                    } else if ($user->type_user == "COMPANY") {
                        return response()->json(['token' => $token->get(), 'socket_token' => $socket_token, 'user' => $user_custom, 'path' => '/User/Company', 'status' => 200], 200)->header('Content-Type', 'application/json');
                    } else if ($user->type_user == "CUSTOMER") {
                        return response()->json(['token' => $token->get(), 'socket_token' => $socket_token, 'user' => $user_custom, 'path' => '/Dashboards', 'status' => 200], 200)->header('Content-Type', 'application/json');
                    }
                } else {
                    throw new Exception('Password not corrent', 401);
                }
            } else {
                if (empty($user)) {
                    throw new Exception('Username not already ', 401);
                } else if (!$user->email()->where('is_primary', true)->first()->is_verify) {
                    throw new Exception('Email not verify', 401);
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
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

    public function resetPasswordFirst(Request $request)
    {
        DB::beginTransaction();

        try {
            $checkUserFirstCreate = USER_FIRST_CREATE::where([
                ['user_id', '=', $request->get('user_id')],
                ['token', '=', $request->get('token')],
            ])->first();
            if (!empty($checkUserFirstCreate)) {
                $user_id = $request->get('user_id');
                $checkUserFirstCreate->delete();
                TB_USERS::where([
                    ['user_id', '=', $user_id],
                ])->update([
                    'password' => Hash::make($request->get('password')),
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user(), 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        //auth()->logout();
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out'], 200);
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

    public function getAllEmail(Request $request)
    {
        $checkEmail = DB::table('TB_EMAIL')
            ->where('EMAIL_USER', $request->get('email'))
            ->count();

        if ($checkEmail > 0) {
            return response()->json(['success' => true, 'detail' => "We are send email already."]);
        } else {
            return response()->json(['success' => false, 'detail' => "This email is not in system."]);
        }
    }
}
