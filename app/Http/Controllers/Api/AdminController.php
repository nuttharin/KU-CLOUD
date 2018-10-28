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
        $users      = DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.created_at,TB_USERS.updated_at,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email ,TB_USERS.online
                                    FROM TB_USERS 
                                    LEFT JOIN TB_PHONE 
                                    ON TB_USERS.user_id =TB_PHONE.user_id
                                    LEFT JOIN (SELECT TB_EMAIL.user_id,GROUP_CONCAT(TB_EMAIL.email_user) AS email 
                                                FROM TB_EMAIL 
                                                GROUP BY TB_EMAIL.user_id) AS T1 
                                    ON T1.user_id = TB_USERS.user_id
                                    WHERE TB_USERS.type_user = "ADMIN"
                                    GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.created_at,TB_USERS.updated_at ,TB_USERS.online');

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
                'is_verify'     => false
            ]);

            $phone = TB_PHONE::create([
                'user_id'       => $user->user_id,
                'phone_user'    => $request->get('phone')
            ]);
        }

        return response()->json(["status_code","201"],201);
    }

    public function editAdminister(Request $request) 
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->update([
                                'fname'     => $request->get('fname'),
                                'lname'     => $request->get('lname')
                            ]);

        $delPhone = TB_PHONE::where('user_id', $request->get('user_id'))
                            ->delete();

        $delEmail = TB_EMAIL::where('user_id', $request->get('user_id'))
                            ->delete();
        
        $arrayPhone = explode(",", $request->get('phone'));

        if(!empty($arrayPhone[0]))
        {
            $createP1 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[0]
            ]);
        }

        if(!empty($arrayPhone[1]))
        {
            $createP2 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[1]
            ]);
        }

        if(!empty($arrayPhone[2]))
        {
            $createP3 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[2]
            ]);
        }

        $arrayEmail = explode(",", $request->get('email'));

        if(!empty($arrayEmail[0]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[0],
                'is_verify'     => false
            ]);
        }

        if(!empty($arrayEmail[1]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[1],
                'is_verify'     => false
            ]);
        }

        if(!empty($arrayEmail[2]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[2],
                'is_verify'     => false
            ]);
        }
        
        return response()->json(["status_code","201"],201);
    }

    public function getAllCompanies(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        $users      = DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.created_at,TB_USERS.updated_at,TB_USER_COMPANY.sub_type_user,TB_COMPANY.company_name,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email  ,TB_USERS.online
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
                                    GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.created_at,TB_USERS.updated_at,TB_USER_COMPANY.sub_type_user,TB_COMPANY.company_name ,TB_USERS.online',['COMPANY',$payload["user"]->company_id] );

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

        //$request->bearerToken(),201
        return response()->json(["status_code","201"],201);
    }

    public function editCompany(Request $request) 
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->update([
                                'fname'     => $request->get('fname'),
                                'lname'     => $request->get('lname')
                            ]);

        $delPhone = TB_PHONE::where('user_id', $request->get('user_id'))
                            ->delete();

        $delEmail = TB_EMAIL::where('user_id', $request->get('user_id'))
                            ->delete();
        
        $arrayPhone = explode(",", $request->get('phone'));

        if(!empty($arrayPhone[0]))
        {
            $createP1 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[0]
            ]);
        }

        if(!empty($arrayPhone[1]))
        {
            $createP2 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[1]
            ]);
        }

        if(!empty($arrayPhone[2]))
        {
            $createP3 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[2]
            ]);
        }

        $arrayEmail = explode(",", $request->get('email'));

        if(!empty($arrayEmail[0]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[0],
                'is_verify'     => false
            ]);
        }

        if(!empty($arrayEmail[1]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[1],
                'is_verify'     => false
            ]);
        }

        if(!empty($arrayEmail[2]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[2],
                'is_verify'     => false
            ]);
        }

        $userCompany = TB_USER_COMPANY::where('user_id', $request->get('user_id'))
                                            ->update([
                                                'company_id'     => $request->get('company'),
                                                'sub_type_user'  => $request->get('sub_type_user')
                                            ]);
        
        return response()->json(["status_code","201"],201);
    }

    public function deleteCompany(Request $request)
    {
        $userCompany = TB_USER_COMPANY::where('user_id', $request->get('user_id'))
                                            ->delete();
        $email = true;
        while($email)
        {
            $email = TB_EMAIL::where('user_id', $request->get('user_id'))
                                ->delete();
        }

        $phone = true;
        while($phone)
        {
            $phone = TB_PHONE::where('user_id', $request->get('user_id'))
                                ->delete();
        }

        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->delete();

        return response()->json(["status","success"],200);
    }

    public function getAllCustomers(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        $users   = DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.created_at,TB_USERS.updated_at,TB_COMPANY.company_name,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email  ,TB_USERS.online
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
                                    GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.created_at,TB_USERS.updated_at,TB_COMPANY.company_name ,TB_USERS.online',['CUSTOMER',$payload["user"]->company_id]);
        
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

    public function editCustomer(Request $request) 
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->update([
                                'fname'     => $request->get('fname'),
                                'lname'     => $request->get('lname')
                            ]);

        $delPhone = TB_PHONE::where('user_id', $request->get('user_id'))
                            ->delete();

        $delEmail = TB_EMAIL::where('user_id', $request->get('user_id'))
                            ->delete();
        
        $arrayPhone = explode(",", $request->get('phone'));

        if(!empty($arrayPhone[0]))
        {
            $createP1 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[0]
            ]);
        }

        if(!empty($arrayPhone[1]))
        {
            $createP2 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[1]
            ]);
        }

        if(!empty($arrayPhone[2]))
        {
            $createP3 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[2]
            ]);
        }

        $arrayEmail = explode(",", $request->get('email'));

        if(!empty($arrayEmail[0]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[0],
                'is_verify'     => false
            ]);
        }

        if(!empty($arrayEmail[1]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[1],
                'is_verify'     => false
            ]);
        }

        if(!empty($arrayEmail[2]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[2],
                'is_verify'     => false
            ]);
        }

        $userCompany = TB_USER_CUSTOMER::where('user_id', $request->get('user_id'))
                                            ->update([
                                                'company_id'     => $request->get('company'),
                                            ]);
        
        return response()->json(["status_code","201"],201);
    }

    public function deleteCustomer(Request $request)
    {
        $userCustomer = TB_USER_CUSTOMER::where('user_id', $request->get('user_id'))
                                            ->delete();
        $email = true;
        while($email)
        {
            $email = TB_EMAIL::where('user_id', $request->get('user_id'))
                                ->delete();
        }

        $phone = true;
        while($phone)
        {
            $phone = TB_PHONE::where('user_id', $request->get('user_id'))
                                ->delete();
        }

        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->delete();

        return response()->json(["status","success"],200);
    }

    public function getAllCompanyData(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        $company    = DB::select('SELECT TB_COMPANY.company_id as id, TB_COMPANY.company_name as name, TB_COMPANY.alias, TB_COMPANY.address, TB_COMPANY.note, TB_COMPANY.created_at, TB_COMPANY.updated_at 
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

    public function editCompanyData(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $company = TB_COMPANY::where('company_id', $request->get('company_id'))
                            ->update([
                                'company_name'  => $request->get('company_name'),
                                'alias'         => $request->get('alias'),
                                'address'       => $request->get('address'),
                                'note'          => $request->get('note')
                            ]);

        //$request->bearerToken(),201
        return response()->json(["status_code","201"],201);
    }

    public function deleteCompanyData(Request $request)
    {
        $user = TB_COMPANY::where('company_id', $request->get('company_id'))
                                ->delete();
        return response()->json(["status","success"],200);
    }

    /* Custom */
    public function getCountUsersByCompanyID(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        $countCustomer   = DB::table('TB_USER_CUSTOMER')
                            ->where('company_id', $request->get('company_id'))
                            ->count();
        $countCompany    = DB::table('TB_USER_COMPANY')
                            ->where('company_id', $request->get('company_id'))
                            ->count();
        
        if($countCompany + $countCustomer == 0)
        {
            return response()->json(true, 200);
        }
        else
        {
            return response()->json(false, 200);
        }
    }
    
    public function blockUser(Request $request) 
    {
        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->update(['block' => true]);
        return response()->json(["status","success"],200);
    }

    public function unblockUser(Request $request) 
    {
        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->update(['block' => false]);
        return response()->json(["status","success"],200);
    }

    public function deleteUser(Request $request)
    {
        $userCompany = TB_USER_COMPANY::where('user_id', $request->get('user_id'))
                                            ->delete();
        
        $userCustomer = TB_USER_CUSTOMER::where('user_id', $request->get('user_id'))
                                            ->delete();

        $email = true;
        while($email)
        {
            $email = TB_EMAIL::where('user_id', $request->get('user_id'))
                                ->delete();
        }

        $phone = true;
        while($phone)
        {
            $phone = TB_PHONE::where('user_id', $request->get('user_id'))
                                ->delete();
        }

        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->delete();

        return response()->json(["status","success"],200);
    }

    public function countUserOnline(Request $request){
        $type_user = $request->get('type_user');
        $users = DB::select('SELECT if(TB_USERS.online,?,?) as online,COUNT(user_id) as count FROM TB_USERS
        WHERE type_user = ?
        GROUP BY TB_USERS.online',['online','offline',$type_user]);
        return response()->json(compact('users'),200);
    }
}
