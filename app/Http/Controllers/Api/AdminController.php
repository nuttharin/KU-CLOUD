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
use App\TB_COMPANY;
use email;
use Mail;
use Illuminate\Mail\Message;

class AdminController extends Controller
{
    public function getAllAdminister(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        $users      = DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email 
                                    FROM TB_USERS 
                                    LEFT JOIN TB_PHONE 
                                    ON TB_USERS.user_id =TB_PHONE.user_id
                                    LEFT JOIN (SELECT TB_EMAIL.user_id,GROUP_CONCAT(TB_EMAIL.email_user) AS email 
                                                FROM TB_EMAIL 
                                                GROUP BY TB_EMAIL.user_id) AS T1 
                                    ON T1.user_id = TB_USERS.user_id
                                    WHERE TB_USERS.type_user = "ADMIN"
                                    GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname');

        if(empty($users))
        {           
            return response()->json(['message' => 'not have data'],200);
        }
        
        return response()->json(compact('users'),200);
    }

    public function createAdminister(Request $request) 
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $user = TB_USERS::create([
            'fname'     => $request->get('fname'),
            'lname'     => $request->get('lname'),
            'password'  => Hash::make($request->get('password')),
            'type_user' => $request->get('type_user')
        ]);
        
        if($user->user_id)
        {
            $email = TB_EMAIL::create([
                'user_id'       => $user->user_id,
                'email_user'    => $request->get('email'),
                'is_verify'     => false,
            ]);

            $phone = TB_PHONE::create([
                'user_id'       => $user->user_id,
                'phone_user'    => $request->get('phone')
            ]);
        }

        return response()->json(["status_code","201"],201);
    }

    public function getAllCompanies(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        $users      = DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email 
                                    FROM TB_USERS 
                                    LEFT JOIN TB_PHONE 
                                    ON TB_USERS.user_id =TB_PHONE.user_id
                                    LEFT JOIN (SELECT TB_EMAIL.user_id,GROUP_CONCAT(TB_EMAIL.email_user) AS email 
                                                FROM TB_EMAIL 
                                                GROUP BY TB_EMAIL.user_id) AS T1 
                                    ON T1.user_id = TB_USERS.user_id
                                    INNER JOIN TB_USER_COMPANY 
                                    ON TB_USER_COMPANY.user_id = TB_USERS.user_id
                                    INNER JOIN TB_COMPANY 
                                    ON TB_COMPANY.company_id = TB_USER_COMPANY.company_id
                                    WHERE TB_USERS.type_user = "COMPANY"
                                    GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname',['COMPANY',$payload["user"]->company_id] );

        if(empty($users))
        {           
            return response()->json(['message' => 'not have data'],200);
        }
        
        return response()->json(compact('users'),200);
    }

    public function createCompany(Request $request) 
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $user = TB_USERS::create([
            'fname'     => $request->get('fname'),
            'lname'     => $request->get('lname'),
            'password'  => Hash::make($request->get('password')),
            'type_user' => 'COMPANY'
        ]);
        
        if($user->user_id)
        {
            $user_company = TB_USER_COMPANY::create([
                'user_id'       => $user->user_id,
                'company_id'    => $payload["user"]->company_id,
                'sub_type_user' => $request->get('sub_type_user')
            ]);

            $email = TB_EMAIL::create([
                'user_id'       => $user->user_id,
                'email_user'    => $request->get('email'),
                'is_verify'     => false,
            ]);

            $phone = TB_PHONE::create([
                'user_id'       => $user->user_id,
                'phone_user'    => $request->get('phone')
            ]);
        }

        $name   = $request->get('fname')." ".$request->get('lname');
        $email  = $request->get('email');

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

    public function getAllCustomers(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        $users   = DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email 
                                    FROM TB_USERS 
                                    LEFT JOIN TB_PHONE 
                                    ON TB_USERS.user_id =TB_PHONE.user_id
                                    LEFT JOIN (SELECT TB_EMAIL.user_id,GROUP_CONCAT(TB_EMAIL.email_user) AS email 
                                                FROM TB_EMAIL
                                                GROUP BY TB_EMAIL.user_id) AS T1 
                                    ON T1.user_id = TB_USERS.user_id
                                    INNER JOIN TB_USER_CUSTOMER 
                                    ON TB_USER_CUSTOMER.user_id = TB_USERS.user_id
                                    INNER JOIN TB_COMPANY 
                                    ON TB_COMPANY.company_id = TB_USER_CUSTOMER.company_id
                                    WHERE TB_USERS.type_user = "CUSTOMER"
                                    GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname',['CUSTOMER',$payload["user"]->company_id]);
        
        if(empty($users))
        {           
            return response()->json(['message' => 'not have data'],200);
        }
        
        return response()->json(compact('users'),200);
    }

    public function createCustomer(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $user = TB_USERS::create([
            'fname'     => $request->get('fname'),
            'lname'     => $request->get('lname'),
            'password'  => Hash::make($request->get('password')),
            'type_user' => 'CUSTOMER'
        ]);
        
        if($user->user_id)
        {
            $user_company = TB_USER_CUSTOMER::create([
                'user_id'       => $user->user_id,
                'company_id'    => $request->get('company'),
            ]);

            $email = TB_EMAIL::create([
                'user_id'       => $user->user_id,
                'email_user'    => $request->get('email'),
                'is_verify'     => true,
            ]);

            $phone = TB_PHONE::create([
                'user_id'       => $user->user_id,
                'phone_user'    => $request->get('phone')
            ]);
        }
        //$request->bearerToken(),201
        return response()->json(["status_code","201"],201);
    }

    public function getAllCompanyData(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        $company    = DB::select('SELECT TB_COMPANY.company_id as id, TB_COMPANY.company_name as name, TB_COMPANY.alias, TB_COMPANY.address, TB_COMPANY.note 
                                    FROM TB_COMPANY');
        
        if(empty($company))
        {           
            return response()->json(['message' => 'not have data'],200);
        }
        
        return response()->json(compact('company'),200);
    }

    public function createCompanyData(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $company = TB_COMPANY::create([
            'company_name'  => $request->get('company_name'),
            'alias'         => $request->get('alias'),
            'address'       => $request->get('address'),
            'note'          => $request->get('note')
        ]);

        //$request->bearerToken(),201
        return response()->json(["status_code","201"],201);
    }
}
