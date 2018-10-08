<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use JWTAuth;
use DB;
use App\TB_USERS;
use App\TB_EMAIL;
use App\TB_PHONE;
use App\TB_USER_COMPANY;
use App\TB_USER_CUSTOMER;
use email;
use Mail;
use Illuminate\Mail\Message;

class CompanyController extends Controller
{
    public function getAllUser(Request $request){
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();

        $users = DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email FROM TB_USERS 
                            LEFT JOIN TB_PHONE ON TB_USERS.user_id =TB_PHONE.user_id
                            LEFT JOIN (SELECT TB_EMAIL.user_id,GROUP_CONCAT(TB_EMAIL.email_user) AS email FROM TB_EMAIL
                            GROUP BY TB_EMAIL.user_id) AS T1 ON T1.user_id = TB_USERS.user_id
                            INNER JOIN TB_USER_COMPANY ON TB_USER_COMPANY.user_id = TB_USERS.user_id
                            INNER JOIN TB_COMPANY ON TB_COMPANY.company_id = TB_USER_COMPANY.company_id
                            WHERE TB_USERS.type_user = ? AND TB_COMPANY.company_id = ?
                            GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname',['COMPANY',$payload["user"]->company_id]);
        
        if(!empty($users)){
            return response()->json(compact('users'),200);
        }
        
        return response()->json(['message' => 'not have data'],200);
    }

    public function addUserCompany(Request $request) {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $user = TB_USERS::create([
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'password' => Hash::make($request->get('password')),
            'type_user' => 'COMPANY'
        ]);
        
        if($user->user_id){

            $user_company = TB_USER_COMPANY::create([
                'user_id' => $user->user_id,
                'company_id' => $payload["user"]->company_id,
                'sub_type_user' => $request->get('sub_type_user')
            ]);

            $email = TB_EMAIL::create([
                'user_id' => $user->user_id,
                'email_user' => $request->get('email'),
                'is_verify' => false,
            ]);

            $phone = TB_PHONE::create([
                'user_id' => $user->user_id,
                'phone_user' => $request->get('phone')
            ]);
        }

        $name = $request->get('fname')." ".$request->get('lname');
        $email = $request->get('email');

        $verification_code = str_random(30); //Generate verification code
        
        DB::table('USER_VERIFICATIONS')->insert(['user_id'=>$user->user_id,'token'=>$verification_code]);
        $subject = "Please verify your email address.";
        Mail::send('auth.verify', ['name' => $name, 'verification_code' => $verification_code,'email' => $email],
            function($mail) use ($email, $name, $subject){            
                $mail->from(getenv('MAIL_USERNAME'), "From KU-CLOUD Name Goes Here");
                $mail->to($email, $name);
                $mail->subject($subject);
            });
        
        //$request->bearerToken(),201
        return response()->json(["status_code","201"],201);
    }

    public function getAllCustomer(Request $request){
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);

        $customer = DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email FROM TB_USERS 
                            LEFT JOIN TB_PHONE ON TB_USERS.user_id =TB_PHONE.user_id
                            LEFT JOIN (SELECT TB_EMAIL.user_id,GROUP_CONCAT(TB_EMAIL.email_user) AS email FROM TB_EMAIL
                            GROUP BY TB_EMAIL.user_id) AS T1 ON T1.user_id = TB_USERS.user_id
                            INNER JOIN TB_USER_CUSTOMER ON TB_USER_CUSTOMER.user_id = TB_USERS.user_id
                            INNER JOIN TB_COMPANY ON TB_COMPANY.company_id = TB_USER_CUSTOMER.company_id
                            WHERE TB_USERS.type_user = ? AND TB_COMPANY.company_id = ?
                            GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname',['CUSTOMER',$payload["user"]->company_id]);
        if(!empty($customer)){
            return response()->json(compact('customer'),200);
        }
        return response()->json(['message' => 'not have data'],200);
    }

    public function addUserCustomer(Request $request){
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $user = TB_USERS::create([
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'password' => Hash::make($request->get('password')),
            'type_user' => 'CUSTOMER'
        ]);
        
        if($user->user_id){

            $user_company = TB_USER_CUSTOMER::create([
                'user_id' => $user->user_id,
                'company_id' => $payload["user"]->company_id,
            ]);

            $email = TB_EMAIL::create([
                'user_id' => $user->user_id,
                'email_user' => $request->get('email'),
                'is_verify' => true,
            ]);

            $phone = TB_PHONE::create([
                'user_id' => $user->user_id,
                'phone_user' => $request->get('phone')
            ]);
        }
        //$request->bearerToken(),201
        return response()->json(["status_code","201"],201);
    }
}
