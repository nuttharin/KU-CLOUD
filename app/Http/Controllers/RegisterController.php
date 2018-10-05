<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\TB_USERS;
use App\TB_EMAIL;
use App\TB_PHONE;

class RegisterController extends Controller
{
    public function index(){
        return view('register.index');
    }

    public function addUser(Request $request) {
        $user = TB_USERS::create([
            'username' => $request->get('username'),
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'password' => Hash::make($request->get('password')),
            'type_user' => $request->get('type_user')
        ]);
        if($user->user_id){
            $email = TB_EMAIL::create([
                'user_id' => $user->user_id,
                'email_user' => $request->get('email')
            ]);

            $phone = TB_PHONE::create([
                'user_id' => $user->user_id,
                'phone_user' => $request->get('phone')
            ]);
        }

        return response()->json(compact('user'),201);
    }
}
