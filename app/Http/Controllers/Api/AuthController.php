<?php

namespace App\Http\Controllers\Api;

use App\TB_USERS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Config;
use Auth;

use DB;


class AuthController extends Controller
{
    public function login(Request $request){
        $user = DB::select('SELECT TB_USERS.user_id,TB_USERS.password,TB_USERS.type_user,TB_EMAIL.email_user,TB_COMPANY.company_id FROM TB_USERS
                            INNER JOIN TB_USER_COMPANY ON  TB_USER_COMPANY.user_id = TB_USERS.user_id
                            INNER JOIN TB_COMPANY ON TB_COMPANY.company_id = TB_USER_COMPANY.company_id
                            INNER JOIN TB_EMAIL ON TB_EMAIL.user_id = TB_USERS.user_id
                            WHERE TB_EMAIL.email_user = ? limit 1',[$request->get('email')]);
        $hash_password = $user[0]->password;
        if(Hash::check($request->get('password'), $hash_password))
        {
            $user_custom = [
                "email"=>$request->get('email'),
                "company_id"=>empty($user[0]->company_id) ? -1 : $user[0]->company_id,
                "type_user"=>$user[0]->type_user,
            ];
            $factory = JWTFactory::customClaims([
                'sub'   => $user[0]->user_id,
                'user'  =>  $user_custom
            ]);
            $payload = JWTFactory::make($factory);
            $token = JWTAuth::encode($payload);
            //$payload = JWTAuth::decode($token);
            return response()->json(['token' => $token->get(),'status'=>200],200);
            //return response()->json(compact('payload'));
        }
        else{
            return response()->json(['error' => 'could_not_create_token'], 500);
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

    public function resgister(Request $request){
        $user = TB_USERS::create([
            'email' => $request->get('email'),
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'password' => Hash::make($request->get('password')),
            'type_user' => $request->get('type_user')
        ]);
        dd($user);
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