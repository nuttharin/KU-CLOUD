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

class CompanyController extends Controller
{
    public function getAllUser(){
        $users = DB::select('SELECT TB_USERS.user_id,CONCAT(TB_USERS.fname," ",TB_USERS.lname) AS name,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email FROM TB_USERS 
                            LEFT JOIN TB_PHONE ON TB_USERS.user_id =TB_PHONE.user_id
                            LEFT JOIN (SELECT TB_EMAIL.user_id,GROUP_CONCAT(TB_EMAIL.email_user) AS email FROM TB_EMAIL
                            GROUP BY TB_EMAIL.user_id) AS T1 ON T1.user_id = TB_USERS.user_id
                            WHERE TB_USERS.type_user = ?
                            GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname',['COMPANY']);
        if(!empty($users)){
            return response()->json(compact('users'),200);
        }
        return response()->json(['message' => 'not have data'],200);
    }

    public function addUser(Request $request) {
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
