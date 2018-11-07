<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 10/29/2018
 * Time: 10:21 AM
 */

namespace App\Repositories\TB_USERS;
use App\TB_USERS;
use App\TB_EMAIL;
use App\TB_PHONE;
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
            // return DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.created_at,TB_USERS.updated_at,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email ,TB_USERS.online
            //                       FROM TB_USERS 
            //                       LEFT JOIN TB_PHONE 
            //                       ON TB_USERS.user_id =TB_PHONE.user_id
            //                       LEFT JOIN (SELECT TB_EMAIL.user_id,GROUP_CONCAT(TB_EMAIL.email_user) AS email 
            //                                         FROM TB_EMAIL 
            //                                         GROUP BY TB_EMAIL.user_id) AS T1 
            //                       ON T1.user_id = TB_USERS.user_id
            //                       WHERE TB_USERS.type_user = ?
            //                       GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.created_at,TB_USERS.updated_at ,TB_USERS.online', [$type]);
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
            return DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email,TB_USERS.block,TB_USER_COMPANY.sub_type_user,TB_USERS.online FROM TB_USERS 
                                  LEFT JOIN TB_PHONE ON TB_USERS.user_id =TB_PHONE.user_id
                                  LEFT JOIN (SELECT TB_EMAIL.user_id,GROUP_CONCAT(TB_EMAIL.email_user) AS email FROM TB_EMAIL
                                  GROUP BY TB_EMAIL.user_id) AS T1 ON T1.user_id = TB_USERS.user_id
                                  INNER JOIN TB_USER_COMPANY ON TB_USER_COMPANY.user_id = TB_USERS.user_id
                                  INNER JOIN TB_COMPANY ON TB_COMPANY.company_id = TB_USER_COMPANY.company_id
                                  WHERE TB_USERS.type_user = ? AND TB_COMPANY.company_id = ?
                                  GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USER_COMPANY.sub_type_user,TB_USERS.online', [$type, $company_id]);
        }
        else if($type == "CUSTOMER"){
            return DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,GROUP_CONCAT(TB_PHONE.phone_user) as phone,T1.email,TB_USERS.block,TB_USERS.online FROM TB_USERS 
                                  LEFT JOIN TB_PHONE ON TB_USERS.user_id =TB_PHONE.user_id
                                  LEFT JOIN (SELECT TB_EMAIL.user_id,GROUP_CONCAT(TB_EMAIL.email_user) AS email FROM TB_EMAIL
                                  GROUP BY TB_EMAIL.user_id) AS T1 ON T1.user_id = TB_USERS.user_id
                                  INNER JOIN TB_USER_CUSTOMER ON TB_USER_CUSTOMER.user_id = TB_USERS.user_id
                                  INNER JOIN TB_COMPANY ON TB_COMPANY.company_id = TB_USER_CUSTOMER.company_id
                                  WHERE TB_USERS.type_user = ? AND TB_COMPANY.company_id = ?
                                  GROUP BY TB_USERS.user_id,T1.email,TB_USERS.fname,TB_USERS.lname,TB_USERS.block,TB_USERS.online',[$type,$company_id]);
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
        return $this->model->create($attributes);
        // TODO: Implement create() method.
    }

    public function update($id, array $attributes)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }


}