<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 10/29/2018
 * Time: 10:21 AM
 */

namespace App\Repositories\TB_USERS;

use Illuminate\Support\Facades\Hash;

use App\TB_USERS;
use App\TB_EMAIL;
use App\TB_PHONE;
use App\TB_USER_COMPANY;
use App\TB_USER_CUSTOMER;
use DB;
use Log;

use email;
use Mail;
use Illuminate\Mail\Message;

class EloquentUsers implements UsersRepository
{

    /**
     * EloquentUsers constructor.
     * @param TB_USERS $model
     */
    public function __construct(TB_USERS $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function getByTypeForAdmin($type)
    {
        $data = [];
        if($type == "ADMIN") {
            $users = $this->model::where('type_user','ADMIN')
                    ->get();
            foreach($users as $user){ 
                $data[] = [
                    'user_id'=>$user->user_id,
                    'fname'=>$user->fname,
                    'lname'=>$user->lname,
                    'block'=>$user->block,
                    'created_at'=>$user->created_at,
                    'updated_at'=>$user->updated_at,
                    'online'=>$user->online,
                    'email'=>TB_EMAIL::where('user_id',$user->user_id)->orderByRaw('is_primary DESC')->get(),
                    'phone'=>TB_PHONE::where('user_id',$user->user_id)->orderByRaw('is_primary DESC')->get(),
                ];
            }
            return $data;
        }
        else if($type == "COMPANY"){
            $users = $this->model::where('type_user','COMPANY')->get();
            foreach($users as $user){ 
                $data[] = [
                    'user_id'=>$user->user_id,
                    'fname'=>$user->fname,
                    'lname'=>$user->lname,
                    'block'=>$user->block,
                    'created_at'=>$user->created_at,
                    'updated_at'=>$user->updated_at,
                    'sub_type_user'=>$user->user_company()->get()[0]->sub_type_user,
                    'online'=>$user->online,
                    'email'=>TB_EMAIL::where('user_id',$user->user_id)->orderByRaw('is_primary DESC')->get(),
                    'phone'=>TB_PHONE::where('user_id',$user->user_id)->orderByRaw('is_primary DESC')->get(),
                    'company'=> DB::select('SELECT TB_COMPANY.company_id,TB_COMPANY.company_name FROM TB_USER_COMPANY 
                                            INNER JOIN TB_COMPANY ON TB_COMPANY.company_id = TB_USER_COMPANY.company_id
                                            WHERE TB_COMPANY.company_id != 1 AND TB_USER_COMPANY.user_id = ?',[$user->user_id])[0],
                ];
            }
            return $data;
            // return DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.created_at,TB_USERS.updated_at,TB_USER_COMPANY.sub_type_user,TB_COMPANY.company_name,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email  ,TB_USERS.online
            //                         FROM TB_USERS 
            //                         LEFT JOIN TB_PHONE 
            //                         ON TB_USERS.user_id =TB_PHONE.user_id
            //                         LEFT JOIN (SELECT TB_EMAIL.user_id,GROUP_CONCAT(TB_EMAIL.email_user) AS email 
            //                                     FROM TB_EMAIL 
            //                                     GROUP BY TB_EMAIL.user_id) AS T1 
            //                         ON T1.user_id = TB_USERS.user_id
            //                         INNER JOIN TB_USER_COMPANY 
            //                         ON TB_USER_COMPANY.user_id = TB_USERS.user_id
            //                         INNER JOIN TB_COMPANY 
            //                         ON TB_COMPANY.company_id = TB_USER_COMPANY.company_id
            //                         WHERE TB_USERS.type_user = ?
            //                         GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.created_at,TB_USERS.updated_at,TB_USER_COMPANY.sub_type_user,TB_COMPANY.company_name ,TB_USERS.online',['COMPANY'] );
        }
        else if($type == "CUSTOMER"){
            $users = $this->model::where('type_user','CUSTOMER')->get();
            foreach($users as $user){ 
                $data[] = [
                    'user_id'=>$user->user_id,
                    'fname'=>$user->fname,
                    'lname'=>$user->lname,
                    'block'=>$user->block,
                    'created_at'=>$user->created_at,
                    'updated_at'=>$user->updated_at,
                    'online'=>$user->online,
                    'email'=> TB_EMAIL::where('user_id',$user->user_id)->orderByRaw('is_primary DESC')->get(),
                    'phone'=> TB_PHONE::where('user_id',$user->user_id)->orderByRaw('is_primary DESC')->get(),
                    'company'=> DB::select('SELECT TB_COMPANY.company_id,TB_COMPANY.company_name FROM TB_USER_CUSTOMER 
                                            INNER JOIN TB_COMPANY ON TB_COMPANY.company_id = TB_USER_CUSTOMER.company_id
                                            WHERE TB_COMPANY.company_id != 1 AND TB_USER_CUSTOMER.user_id = ?',[$user->user_id])[0],
                ];
            }
            return $data;
        }
        return;
        // TODO: Implement getByTypeAdmin() method.
    }

    public function getByTypeForCompany($type,$company_id,$start = null,$length =null)
    {
        if($type == "COMPANY") {
            $users =   DB::table('TB_USERS')->where([
                                                        ['TB_USERS.type_user','=',$type],
                                                        ['TB_USER_COMPANY.company_id','=',$company_id]
                                                    ])
            ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_USERS.user_id')
            ->offset($start)
            ->limit($length)
            ->get();

            foreach($users as $user){ 
                $data[] = [
                    'user_id'=>$user->user_id,
                    'fname'=>$user->fname,
                    'lname'=>$user->lname,
                    'sub_type_user'=>$user->sub_type_user,
                    'block'=>$user->block,
                    'created_at'=>$user->created_at,
                    'updated_at'=>$user->updated_at,
                    'online'=>$user->online,
                    'email'=>TB_EMAIL::where('user_id',$user->user_id)->orderByRaw('is_primary DESC')->get(),
                    'phone'=>TB_PHONE::where('user_id',$user->user_id)->orderByRaw('is_primary DESC')->get(),
                ];
            }
            return $data;
        }
        else if($type == "CUSTOMER"){
            $users =   DB::table('TB_USERS')->where([
                ['TB_USERS.type_user','=',$type],
                ['TB_USER_CUSTOMER.company_id','=',$company_id]
            ])
            ->join('TB_USER_CUSTOMER', 'TB_USER_CUSTOMER.user_id', '=', 'TB_USERS.user_id')
            ->offset($start)
            ->limit($length)
            ->get();

            foreach($users as $user){ 
                $data[] = [
                    'user_id'=>$user->user_id,
                    'fname'=>$user->fname,
                    'lname'=>$user->lname,
                    'block'=>$user->block,
                    'created_at'=>$user->created_at,
                    'updated_at'=>$user->updated_at,
                    'online'=>$user->online,
                    'email'=>TB_EMAIL::where('user_id',$user->user_id)->orderByRaw('is_primary DESC')->get(),
                    'phone'=>TB_PHONE::where('user_id',$user->user_id)->orderByRaw('is_primary DESC')->get(),
                ];
            }
            return $data;
        }
    }

    public  function searchByTypeForCompany($type,$company_id,$start,$length,$search){
        $data = null;
        $table = null;
        
        switch (strtolower($search)){
            case 'unblock':
            case 'offline':
                $search = false;
                break;
            case 'block':
            case 'online':
                $search = true;
                break;   
        }

        if($type == 'COMPANY') {
            $users =   DB::table('TB_USERS')->where([
                                                        ['TB_USERS.type_user','=',$type],
                                                        ['TB_USER_COMPANY.company_id','=',$company_id],     
                                                        
                                            ])
                                            ->where(function($query) use ($search)
                                            {
                                                $query->orWhere('TB_USERS.fname','LIKE',"%{$search}%")  
                                                      ->orWhere('TB_USERS.lname','LIKE',"%{$search}%")
                                                      ->orWhere('TB_USERS.block','=',$search)
                                                      ->orWhere('TB_USERS.online','=',$search)
                                                      ->orWhere('TB_PHONE.phone_user','LIKE',"%{$search}%")
                                                      ->orWhere('TB_EMAIL.email_user','LIKE',"%{$search}%");
                                            })
            ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_USERS.user_id')
            ->join('TB_PHONE','TB_PHONE.user_id','=','TB_USERS.user_id')
            ->join('TB_EMAIL','TB_EMAIL.user_id','=','TB_USERS.user_id')
            ->offset($start)
            ->limit($length)
            ->get();        

            $user_id = null;
            foreach($users as $user){
                if($user_id != $user->user_id){
                    $user_id = $user->user_id;
                    $data[] = [
                        'user_id'=>$user->user_id,
                        'fname'=>$user->fname,
                        'lname'=>$user->lname,
                        'sub_type_user'=>$user->sub_type_user,
                        'block'=>$user->block,
                        'created_at'=>$user->created_at,
                        'updated_at'=>$user->updated_at,
                        'online'=>$user->online,
                        'email'=>TB_EMAIL::where('user_id',$user->user_id)->orderByRaw('is_primary DESC')->get(),
                        'phone'=>TB_PHONE::where('user_id',$user->user_id)->orderByRaw('is_primary DESC')->get(),
                    ];
                }
            }
            return $data;
        }
        else if($type == 'CUSTOMER'){
            $users =   DB::table('TB_USERS')->where([
                                                        ['TB_USERS.type_user','=',$type],
                                                        ['TB_USER_CUSTOMER.company_id','=',$company_id],     
                                            ])
                                            ->where(function($query) use ($search)
                                            {
                                                $query->orWhere('TB_USERS.fname','LIKE',"%{$search}%")  
                                                      ->orWhere('TB_USERS.lname','LIKE',"%{$search}%")
                                                      ->orWhere('TB_USERS.block','=',$search)
                                                      ->orWhere('TB_USERS.online','=',$search)
                                                      ->orWhere('TB_PHONE.phone_user','LIKE',"%{$search}%")
                                                      ->orWhere('TB_EMAIL.email_user','LIKE',"%{$search}%");
                                            })    
            ->join('TB_USER_CUSTOMER', 'TB_USER_CUSTOMER.user_id', '=', 'TB_USERS.user_id')
            ->join('TB_PHONE','TB_PHONE.user_id','=','TB_USERS.user_id')
            ->join('TB_EMAIL','TB_EMAIL.user_id','=','TB_USERS.user_id')
            ->offset($start)
            ->limit($length)
            ->get();        

            $user_id = null;
            foreach($users as $user){
                if($user_id != $user->user_id){
                $user_id = $user->user_id;
                $data[] = [
                        'user_id'=>$user->user_id,
                        'fname'=>$user->fname,
                        'lname'=>$user->lname,
                        'block'=>$user->block,
                        'created_at'=>$user->created_at,
                        'updated_at'=>$user->updated_at,
                        'online'=>$user->online,
                        'email'=>TB_EMAIL::where('user_id',$user->user_id)->orderByRaw('is_primary DESC')->get(),
                        'phone'=>TB_PHONE::where('user_id',$user->user_id)->orderByRaw('is_primary DESC')->get(),
                    ];
                }
            }
            return $data;
        }
    }

    public function countUserOnline($type, $company_id = null)
    {
        if($company_id == 1){
            return DB::select('SELECT if(TB_USERS.online,?,?) as online,COUNT(user_id) as count FROM TB_USERS
                                    WHERE type_user = ?
                                    GROUP BY TB_USERS.online',['online','offline',$type]);
        }
        else{
            if($type == 'COMPANY') {
                return DB::select('SELECT if(TB_USERS.online,?,?) as online,COUNT(TB_USERS.user_id) as count FROM TB_USERS
                                        INNER JOIN TB_USER_COMPANY ON TB_USER_COMPANY.user_id = TB_USERS.user_id
                                        WHERE type_user = ? AND TB_USER_COMPANY.company_id = ?
                                        GROUP BY TB_USERS.online', ['online', 'offline', $type,$company_id]);
            }
            else if($type == 'CUSTOMER'){
                return DB::select('SELECT if(TB_USERS.online,?,?) as online,COUNT(TB_USERS.user_id) as count FROM TB_USERS
                                        INNER JOIN TB_USER_CUSTOMER ON TB_USER_CUSTOMER.user_id = TB_USERS.user_id
                                        WHERE type_user = ? AND TB_USER_CUSTOMER.company_id = ?
                                        GROUP BY TB_USERS.online', ['online', 'offline', $type,$company_id]);
            }
        }
        return;
        // TODO: Implement countUserOnline() method.
    }

    public  function countUser($type,$company_id){
        if($company_id == 1){
            return DB::select('SELECT COUNT(user_id) as count FROM TB_USERS
                                    WHERE type_user = ?',[$type]);
        }
        else{
            if($type == 'COMPANY') {
                return DB::select('SELECT COUNT(TB_USERS.user_id) as count FROM TB_USERS
                                        INNER JOIN TB_USER_COMPANY ON TB_USER_COMPANY.user_id = TB_USERS.user_id
                                        WHERE type_user = ? AND TB_USER_COMPANY.company_id = ?',[$type,$company_id]);
            }
            else if($type == 'CUSTOMER'){
                return DB::select('SELECT COUNT(TB_USERS.user_id) as count FROM TB_USERS
                                        INNER JOIN TB_USER_CUSTOMER ON TB_USER_CUSTOMER.user_id = TB_USERS.user_id
                                        WHERE type_user = ? AND TB_USER_CUSTOMER.company_id = ?', [$type,$company_id]);
            }
        }
        return;
    }

    public function create(array $attributes)
    {
        // TODO: Implement create() method.
        DB::beginTransaction();
        try{
            $user = TB_USERS::create([
                'fname' => $attributes['fname'],
                'lname' => $attributes['lname'],
                'password' => Hash::make($attributes['password']),
                'type_user' => $attributes['type_user']
            ]);
    
            if($attributes['type_user'] == "ADMIN"){
                if($user->user_id) {
                    TB_USER_COMPANY::create([
                        'user_id' => $user->user_id,
                        'company_id' => '1',
                        'sub_type_user' => 'ADMIN',
                    ]);

                    TB_EMAIL::create([
                        'user_id' => $user->user_id,
                        'email_user' => $attributes['email_user'],
                        'is_verify' => false,
                        'is_primary'=>true
                    ]);
        
                    TB_PHONE::create([
                        'user_id' => $user->user_id,
                        'phone_user' => $attributes['phone_user'],
                        'is_verify' => false,
                        'is_primary'=>true
                    ]);
                }
            }
            else if($attributes['type_user'] == "COMPANY"){
                if($user->user_id){
                    TB_USER_COMPANY::create([
                        'user_id' => $user->user_id,
                        'company_id' => $attributes['company_id'],
                        'sub_type_user' => $attributes['sub_type_user']
                    ]);
        
                    TB_EMAIL::create([
                        'user_id' => $user->user_id,
                        'email_user' => $attributes['email_user'],
                        'is_verify' => false,
                        'is_primary'=>true
                    ]);
        
                    TB_PHONE::create([
                        'user_id' => $user->user_id,
                        'phone_user' => $attributes['phone_user'],
                        'is_verify' => false,
                        'is_primary'=>true
                    ]);
                }
            }
            else if($attributes['type_user'] == "CUSTOMER"){
                if($user->user_id){
                    TB_USER_CUSTOMER::create([
                        'user_id' => $user->user_id,
                        'company_id' => $attributes['company_id'],
                    ]);
    
                    TB_EMAIL::create([
                        'user_id' => $user->user_id,
                        'email_user' => $attributes['email_user'],
                        'is_verify' => false,
                        'is_primary'=>true
                    ]);
        
                    TB_PHONE::create([
                        'user_id' => $user->user_id,
                        'phone_user' => $attributes['phone_user'],
                        'is_primary'=>true
                    ]);
                }
            }

            // $name = $attributes['fname']." ".$attributes['lname'];
            // $email = $attributes['email_user'];

            // $verification_code = str_random(30); //Generate verification code
            
            // DB::table('USER_VERIFICATIONS')->insert(['user_id'=>$user->user_id,'token'=>$verification_code]);
            // $subject = "Please verify your email address.";
            // Mail::send('auth.verify', ['name' => $name, 'verification_code' => $verification_code,'email' => $email],
            //     function($mail) use ($email, $name, $subject){            
            //         $mail->from(getenv('MAIL_USERNAME'), "From KU-CLOUD Name Goes Here");
            //         $mail->to($email, $name);
            //         $mail->subject($subject);
            // });

        }
        catch(Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function update(array $attributes)
    {
        // TODO: Implement update() method.
        DB::beginTransaction();
        try{
            $user = TB_USERS::where('user_id', $attributes['user_id'])
            ->update([
                    'fname' => $attributes['fname'],
                    'lname' => $attributes['lname'],
                ]);

            if(!empty($attributes['phone_user'])){
                foreach($attributes['phone_user'] as $value){
                    TB_PHONE::firstOrCreate([
                        'user_id' => $attributes['user_id'],
                        'phone_user' => $value
                    ]);
                }
            }

            if(!empty($attributes['email_user'])){
                foreach($attributes['email_user'] as $value){
                    TB_EMAIL::firstOrCreate([
                        'user_id' =>$attributes['user_id'],
                        'email_user' => $value,
                    ]);
                }
            }
        }
        catch(Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function deleteEmailUser(array $attributes){
        DB::beginTransaction();
        try{
            $data = TB_EMAIL::where([
                ['email_user','=',$attributes['email_user']],
                ['is_primary','=',false],
            ])->delete();
        }
        catch(Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function deletePhoneUser(array $attributes){
        DB::beginTransaction();
        try{
            $data = TB_PHONE::where([
                ['phone_user','=',$attributes['phone_user']],
                ['is_primary','=',false],
            ])->delete();
        }
        catch(Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }



}