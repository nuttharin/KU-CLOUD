<?php

namespace App\Http\Controllers;

use App\TB_EMAIL;
use App\TB_TOKEN_FORGETPASSWORD;
use App\TB_USERS;
use App\USER_FIRST_CREATE;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Mail;

class AuthController extends Controller
{

    public function index()
    {
        //return view('auth.index');
    }

    public function Login(Request $request)
    {
        $tokenRequest = Request::create(
            env('API_URL') . 'Auth/Login',
            'POST'
            , array(
                "username" => $request->get('username'),
                "password" => $request->get('password'),
            )
        );

        $response = Route::dispatch($tokenRequest);

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getContent());
            //Cookie::queue('token', $data->token, 60);
            if (!empty($data->user)) {
                $request->session()->put('user', $data->user);
            }
            return $response->getContent();
            // return redirect('/User/Company')->cookie(
            //     'access_token', //name
            //     $data->token, //value
            //     true// HttpsOnly
            // );
        } else {
            return $response;
        }
    }

    public function SetCookie(Request $request)
    {
        Cookie::queue('token', $request->get('token'), 60);
        return \response()->json(["message" => "success"], 201);
    }

    public function getCookieToken(Request $request)
    {
        $token = $request->cookie('token');
        return \response()->json(\compact('token'), 200);
    }

    public function forgetPassword()
    {
        return view('forgetPassword.index');
    }

    public function forgetPasswordSendMail(Request $request)
    {
        $userName = DB::select('SELECT TB_USERS.username as accountname, TB_USERS.fname as firstname, TB_USERS.lname as lastname, TB_USERS.user_id as userId FROM TB_USERS
                                    INNER JOIN TB_EMAIL ON TB_EMAIL.user_id = TB_USERS.user_id
                                    WHERE TB_EMAIL.email_user = ?', [$request->get('email')]);

        $fullName = $userName[0]->firstname . " " . $userName[0]->lastname;
        $accountName = $userName[0]->accountname;
        $email = $request->get('email');
        $verification_code = str_random(30);
        $subject = "Reset Password.";

        Mail::send('forgetPassword.resetPasswordBody', ['accountname' => $accountName, 'fullname' => $fullName, 'verification_code' => $verification_code, 'userId' => $userName[0]->userId],
            function ($mail) use ($email, $fullName, $subject) {
                $mail->from(getenv('MAIL_USERNAME'), "From KU-CLOUD");
                $mail->to($email, $fullName);
                $mail->subject($subject);
            });

        $token = TB_TOKEN_FORGETPASSWORD::create([
            'user_id' => $userName[0]->userId,
            'token' => $verification_code,
        ]);

        $responseMessage = "We're send email already.";
        return view('forgetPassword.index')->with('responseMessage', $responseMessage);
    }

    public function ResetPasswordFirst($user_id, $token)
    {
        $check = USER_FIRST_CREATE::where([
            ['token', '=', $token],
            ['user_id', '=', $user_id],
        ])->first();

        if (!empty($check)) {
            return view('auth.ResetPasswordFirst')
                ->with('user_id', $check->user_id)
                ->with('token', $check->token);
        }
    }

    public function resetPassword($verification_code, $userId)
    {
        $check = DB::table('TB_TOKEN_FORGETPASSWORD')->where('token', $verification_code)->first();

        if ($check != null) {
            DB::table('TB_TOKEN_FORGETPASSWORD')->where('token', $verification_code)->delete();

            return view('forgetPassword.resetPassword', ['userId' => $userId]);
        }

        $responseMessage = "Your token has expire. Please send email again.";
        return view('forgetPassword.index')->with('responseMessage', $responseMessage);
    }

    public function resetPasswordPost(Request $request)
    {

        $user = TB_USERS::where('user_id', $request->get('user_id'))
            ->update([
                'password' => Hash::make($request->get('password')),
            ]);

        return view('Home.Index');
    }

    public function verifyUser($verification_code, $email)
    {
        $check = DB::table('USER_VERIFICATIONS')->where('token', $verification_code)->first();
        if (!is_null($check)) {
            $email = TB_EMAIL::where('email_user', '=', $email)->first();
            if ($email->is_verify == 1) {
                return response()->json([
                    'success' => true,
                    'message' => 'Account already verified..',
                ]);
            }
            $email->update(['is_verify' => 1]);
            DB::table('USER_VERIFICATIONS')->where('token', $verification_code)->delete();
            return view('auth.verifyMessage', ['message' => 'You have successfully verified your email address.']);
            /*return response()->json([
        'success'=> true,
        'message'=> 'You have successfully verified your email address.'
        ]);*/
        }
        return view('auth.verifyMessage', ['message' => 'Verification code is invalid.']);
        //return response()->json(['success'=> false, 'error'=> "Verification code is invalid."]);
    }
}

/*TB_USERS::create([
'username' => $request->get('username'),
'fname' => $request->get('fname'),
'lname' => $request->get('lname'),
'pwd' => Hash::make($request->get('pwd')),
'type_user' => $request->get('type_user')
]);
$user = TB_USERS::first();
$token = JWTAuth::fromUser($user);

return response()->json(compact('user','token'),201);*/

/*$data1 = [
'username' => 'team12345',
'pwd' => '12345',
];

$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL => "http://localhost:9000/auth",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30000,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS => json_encode($data1),
CURLOPT_HTTPHEADER => array(*/
// "accept: */*",
/*                "content-type: application/json",
),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
echo "cURL Error #:" . $err;
} else {
return response($response, 200)
->header('Content-Type', 'application/json');
}*/
