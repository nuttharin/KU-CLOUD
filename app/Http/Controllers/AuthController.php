<?php

namespace App\Http\Controllers;

use App\TB_USERS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\USER_VERIFICATIONS;
use App\TB_EMAIL;
use DB;

use email;
use Mail;
use Illuminate\Mail\Message;

class AuthController extends Controller
{

    public function index(){
        return view('auth.index');
    }

    public function forgetPassword(){
        return view('forgetPassword.index');
    }

    public function forgetPasswordSendMail(Request $request){
        $email = $request->get('email');
        $name = "testtest";
        $verification_code = "123456";
        $subject = "Please verify your email address.";
        Mail::send('auth.verify', ['name' => $name, 'verification_code' => $verification_code,'email' => $email],
            function($mail) use ($email, $name, $subject){         
                $mail->from(getenv('MAIL_USERNAME'), "From KU-CLOUD");
                $mail->to($email, $name);
                $mail->subject($subject);
        });
   
        $responseMessage = "true";
        return view('forgetPassword.index')->with('responseMessage',$responseMessage);
    }

    public function verifyUser($verification_code,$email){
        $check = DB::table('USER_VERIFICATIONS')->where('token',$verification_code)->first();
        if(!is_null($check)){
            $email = TB_EMAIL::where('email_user','=',$email)->first();
            if($email->is_verify == 1){
                return response()->json([
                    'success'=> true,
                    'message'=> 'Account already verified..'
                ]);
            }
            $email->update(['is_verify' => 1]);
            DB::table('USER_VERIFICATIONS')->where('token',$verification_code)->delete();
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