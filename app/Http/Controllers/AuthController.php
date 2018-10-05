<?php

namespace App\Http\Controllers;

use App\TB_USERS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    public function index(){
        return view('auth.index');
    }

    public function test(){
        $usesr = TB_USERS::get();
        if(!empty($user))
        {
            return response($usesr, 200)
                    ->header('Content-Type', 'application/json');
        }
        return response('not found', 200)
        ->header('Content-Type', 'application/json');
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