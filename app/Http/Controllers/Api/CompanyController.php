<?php

namespace App\Http\Controllers\Api;

use App\Repositories\TB_USERS\UsersRepository;
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
use App\LogViewer\LogViewer;
use Auth;

class CompanyController extends Controller
{
    /**
     * @var UsersRepository
     */
    private $users;
    private $auth;

    public  function __construct(UsersRepository $users)
    {
        $this->users = $users;
        $this->log_viewer = new LogViewer();
        $this->auth = Auth::user();
        // $token = $request->cookie('token');
        // $payload = JWTAuth::setToken($token)->getPayload();
        // $this->log_viewer->setFolder('COMPANY_'.$payload["user"]->company_id);
    }

    public function test(){
        $compnay_id = $this->auth->user_company()->first();
        return response()->json(compact('compnay_id'),201);
    }

    public function getAllUser(Request $request){
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();

        $users = $this->users->getByTypeForCompany('COMPANY',$payload["user"]->company_id);
        
        if(!empty($users)){
            return response()->json(compact('users'),200);
        }
        
        return response()->json(['message' => 'not have data'],200);
    }

    public function addUserCompany(Request $request) {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        
        $user = $this->users->create([
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

        /*$name = $request->get('fname')." ".$request->get('lname');
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
        */
        
        //$request->bearerToken(),201
        return response()->json(["status_code","201"],201);
    }

    public function editUserCompany(Request $request){
        $user = TB_USERS::where('user_id', $request->get('user_id'))
        ->update([
                'fname' => $request->get('fname'),
                'lname' => $request->get('lname'),
            ]);
        
        foreach($request->get('phone_user') as $value){
            TB_PHONE::firstOrCreate([
                'user_id' => $request->get('user_id'),
                'phone_user' => $value
            ]);
        }

        foreach($request->get('email_user') as $value){
            TB_EMAIL::firstOrCreate([
                'user_id' => $request->get('user_id'),
                'email_user' => $value
            ]);
        }
        
        //TB_PHONE::updateOrCreate(["user_id"=>$request->get('user_id')],$request->get('phone_user'));
    }

    public function blockUserCompany(Request $request){
        $user = TB_USERS::where('user_id', $request->get('user_id'))
                        ->update(['block' => $request->get('block')]);
        return response()->json(["status","success"],200);
    }

    public function getAllCustomer(Request $request){
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);

        $customer = $this->users->getByTypeForCompany('CUSTOMER',$payload['user']->company_id);
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

    public function countUserOnline(Request $request){
        $type_user = $request->get('type_user');
        $company_id = $this->auth->user_company()->first()->company_id;
        $users = $this->users->countUserOnline($type_user, $company_id);
        return response()->json(compact('users'),200);
    }
}
