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
            $users = $this->model::where('type_user','ADMIN')->get();
            foreach($users as $user){ 
                $data[] = [
                    'user_id'=>$user->user_id,
                    'fname'=>$user->fname,
                    'lname'=>$user->lname,
                    'block'=>$user->block,
                    'created_at'=>$user->created_at,
                    'updated_at'=>$user->updated_at,
                    'online'=>$user->online,
                    'email'=>TB_EMAIL::where('user_id',$user->user_id)->get(),
                    'phone'=>TB_PHONE::where('user_id',$user->user_id)->get(),
                ];
            }
            return $data;
        }
        else if($type == "COMPANY"){
            return DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.created_at,TB_USERS.updated_at,TB_USER_COMPANY.sub_type_user,TB_COMPANY.company_name,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email  ,TB_USERS.online
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
                                    WHERE TB_USERS.type_user = ?
                                    GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.created_at,TB_USERS.updated_at,TB_USER_COMPANY.sub_type_user,TB_COMPANY.company_name ,TB_USERS.online',['COMPANY'] );
        }
        else if($type == "CUSTOMER"){
            return DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.created_at,TB_USERS.updated_at,TB_COMPANY.company_name,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email  ,TB_USERS.online
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
                                    WHERE TB_USERS.type_user = ?
                                    GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.created_at,TB_USERS.updated_at,TB_COMPANY.company_name ,TB_USERS.online',['CUSTOMER']);
        }
        return;

        // TODO: Implement getByTypeAdmin() method.
    }

    public function getByTypeForCompany($type,$company_id)
    {
        if($type == "COMPANY") {
            $users = DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,TB_USER_COMPANY.sub_type_user,TB_USERS.block,TB_USERS.online,TB_USERS.created_at,TB_USERS.updated_at FROM TB_USERS
                                 INNER JOIN TB_USER_COMPANY ON TB_USER_COMPANY.user_id = TB_USERS.user_id
                                 WHERE TB_USERS.type_user = ? AND TB_USER_COMPANY.company_id = ?',[$type,$company_id]);
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
            $users = DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.online,TB_USERS.created_at,TB_USERS.updated_at FROM TB_USERS
                                 INNER JOIN TB_USER_CUSTOMER ON TB_USER_CUSTOMER.user_id = TB_USERS.user_id
                                 WHERE TB_USERS.type_user = ? AND TB_USER_CUSTOMER.company_id = ?',[$type,$company_id]);
            foreach($users as $user){ 
                $data[] = [
                    'user_id'=>$user->user_id,
                    'fname'=>$user->fname,
                    'lname'=>$user->lname,
                    'block'=>$user->block,
                    'created_at'=>$user->created_at,
                    'updated_at'=>$user->updated_at,
                    'online'=>$user->online,
                    'email'=>TB_EMAIL::where('user_id',$user->user_id)->get(),
                    'phone'=>TB_PHONE::where('user_id',$user->user_id)->get(),
                ];
            }
            return $data;

            // return DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email,TB_USERS.block,TB_USERS.online FROM TB_USERS 
            //                       LEFT JOIN TB_PHONE ON TB_USERS.user_id =TB_PHONE.user_id
            //                       LEFT JOIN (SELECT TB_EMAIL.user_id,GROUP_CONCAT(TB_EMAIL.email_user) AS email FROM TB_EMAIL
            //                       GROUP BY TB_EMAIL.user_id) AS T1 ON T1.user_id = TB_USERS.user_id
            //                       INNER JOIN TB_USER_CUSTOMER ON TB_USER_CUSTOMER.user_id = TB_USERS.user_id
            //                       INNER JOIN TB_COMPANY ON TB_COMPANY.company_id = TB_USER_CUSTOMER.company_id
            //                       WHERE TB_USERS.type_user = ? AND TB_COMPANY.company_id = ?
            //                       GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.online',[$type,$company_id]);
        }
        // TODO: Implement getByTypeForCompany() method.
    }

    public function countUserOnline($type, $company_id = null)
    {
        if($company_id == null){
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
        $user = TB_USERS::where('user_id', $attributes['user_id'])
        ->update([
                'fname' => $attributes['fname'],
                'lname' => $attributes['lname'],
            ]);
        
        foreach($attributes['phone_user'] as $value){
            TB_PHONE::firstOrCreate([
                'user_id' => $attributes['user_id'],
                'phone_user' => $value
            ]);
        }

        foreach($attributes['email_user'] as $value){
            TB_EMAIL::firstOrCreate([
                'user_id' =>$attributes['user_id'],
                'email_user' => $value,
            ]);
        }
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }


}