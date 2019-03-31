<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 10/29/2018
 * Time: 10:21 AM
 */

namespace App\Repositories\TB_USERS;

use DB;
use Auth;
use App\TB_EMAIL;
use App\TB_PHONE;
use App\TB_USERS;
use App\Address_users;
use App\TB_USER_COMPANY;
use App\TB_USER_CUSTOMER;
use App\USER_FIRST_CREATE;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
        // TODO: Implement getByTypeAdmin() method.
        $data = [];
        if ($type == "ADMIN") {
            $users = $this->model::where('type_user', 'ADMIN')->get();

            foreach ($users as $user) {
                if(Auth::user()->user_id != $user->user_id)
                {
                    $data[] = [
                        'user_id' => $user->user_id,
                        'username' => $user->username,
                        'fname' => $user->fname,
                        'lname' => $user->lname,
                        'block' => $user->block,
                        'type_user' => $user->type_user,
                        'address' => DB::select('SELECT ADDRESS_USERS.user_id, ADDRESS_USERS.address_detail, ADDRESS_USERS.district_id, ADDRESS_USERS.amphure_id, ADDRESS_USERS.province_id,
                                                        DISTRICTS.zip_code, DISTRICTS.name_th as dNameTh, DISTRICTS.name_en as dNameEn,
                                                        AMPHURES.name_th as aNameTh, AMPHURES.name_en as aNameEn,
                                                        PROVINCES.name_th as pNameTh, PROVINCES.name_en as pNameEn
                                                FROM ADDRESS_USERS INNER JOIN DISTRICTS ON DISTRICTS.district_id = ADDRESS_USERS.district_id
                                                INNER JOIN AMPHURES ON AMPHURES.amphure_id = ADDRESS_USERS.amphure_id
                                                INNER JOIN PROVINCES ON PROVINCES.province_id = ADDRESS_USERS.province_id
                                                WHERE ADDRESS_USERS.user_id = ?', [$user->user_id]),
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                        'online' => $user->online,
                        'email' => TB_EMAIL::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
                        'phone' => TB_PHONE::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
                    ];
                }
            }
            return $data;
        } else if ($type == "COMPANY") {
            $users = $this->model::where('type_user', 'COMPANY')->get();

            foreach ($users as $user) {
                $data[] = [
                    'user_id' => $user->user_id,
                    'username' => $user->username,
                    'fname' => $user->fname,
                    'lname' => $user->lname,
                    'block' => $user->block,
                    'type_user' => $user->type_user,
                    'address' => DB::select('SELECT ADDRESS_USERS.user_id, ADDRESS_USERS.address_detail, ADDRESS_USERS.district_id, ADDRESS_USERS.amphure_id, ADDRESS_USERS.province_id,
                                                    DISTRICTS.zip_code, DISTRICTS.name_th as dNameTh, DISTRICTS.name_en as dNameEn,
                                                    AMPHURES.name_th as aNameTh, AMPHURES.name_en as aNameEn,
                                                    PROVINCES.name_th as pNameTh, PROVINCES.name_en as pNameEn
                                            FROM ADDRESS_USERS INNER JOIN DISTRICTS ON DISTRICTS.district_id = ADDRESS_USERS.district_id
                                            INNER JOIN AMPHURES ON AMPHURES.amphure_id = ADDRESS_USERS.amphure_id
                                            INNER JOIN PROVINCES ON PROVINCES.province_id = ADDRESS_USERS.province_id
                                            WHERE ADDRESS_USERS.user_id = ?', [$user->user_id]),
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                    'sub_type_user' => $user->user_company()->first()->sub_type_user,
                    'online' => $user->online,
                    'email' => TB_EMAIL::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
                    'phone' => TB_PHONE::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
                    'company' => DB::select('SELECT TB_COMPANY.company_id,TB_COMPANY.company_name FROM TB_USER_COMPANY
                                            INNER JOIN TB_COMPANY ON TB_COMPANY.company_id = TB_USER_COMPANY.company_id
                                            WHERE TB_COMPANY.company_id != 1 AND TB_USER_COMPANY.user_id = ?', [$user->user_id])[0],
                ];
            }
            return $data;
        } else if ($type == "CUSTOMER") {
            $users = $this->model::where('type_user', 'CUSTOMER')->get();
            foreach ($users as $user) {
                $data[] = [
                    'user_id' => $user->user_id,
                    'username' => $user->username,
                    'fname' => $user->fname,
                    'lname' => $user->lname,
                    'block' => $user->block,
                    'type_user' => $user->type_user,
                    'address' => DB::select('SELECT ADDRESS_USERS.user_id, ADDRESS_USERS.address_detail, ADDRESS_USERS.district_id, ADDRESS_USERS.amphure_id, ADDRESS_USERS.province_id,
                                                    DISTRICTS.zip_code, DISTRICTS.name_th as dNameTh, DISTRICTS.name_en as dNameEn,
                                                    AMPHURES.name_th as aNameTh, AMPHURES.name_en as aNameEn,
                                                    PROVINCES.name_th as pNameTh, PROVINCES.name_en as pNameEn
                                            FROM ADDRESS_USERS INNER JOIN DISTRICTS ON DISTRICTS.district_id = ADDRESS_USERS.district_id
                                            INNER JOIN AMPHURES ON AMPHURES.amphure_id = ADDRESS_USERS.amphure_id
                                            INNER JOIN PROVINCES ON PROVINCES.province_id = ADDRESS_USERS.province_id
                                            WHERE ADDRESS_USERS.user_id = ?', [$user->user_id]),
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                    'online' => $user->online,
                    'email' => TB_EMAIL::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
                    'phone' => TB_PHONE::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
                    'company' => DB::select('SELECT TB_COMPANY.company_id,TB_COMPANY.company_name FROM TB_USER_CUSTOMER
                                            LEFT JOIN TB_COMPANY ON TB_COMPANY.company_id = TB_USER_CUSTOMER.company_id
                                            WHERE TB_COMPANY.company_id != 1 AND TB_USER_CUSTOMER.user_id = ? AND TB_USER_CUSTOMER.company_id IS NOT NULL', [$user->user_id]),
                ];
            }
            return $data;
        }
        return;

    }

    public function getByTypeForCompany($type, $company_id, $start = null, $length = null, $order, $dir)
    {
        if ($type == "COMPANY") {
            $users = DB::table('TB_USERS')->where([
                ['TB_USERS.user_id', '!=', Auth::user()->user_id],
                ['TB_USERS.type_user', '=', $type],
                ['TB_USER_COMPANY.company_id', '=', $company_id],
                ['TB_PHONE.is_primary', '=', true],
                ['TB_EMAIL.is_primary', '=', true],
            ])
                ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_USERS.user_id')
                ->join('TB_PHONE', 'TB_PHONE.user_id', '=', 'TB_USERS.user_id')
                ->join('TB_EMAIL', 'TB_EMAIL.user_id', '=', 'TB_USERS.user_id')
                ->offset($start)
                ->limit($length)
                ->orderBy($order, $dir)
                ->get();
            $data = [];
            if (!empty($users)) {
                foreach ($users as $user) {
                    $data[] = [
                        'user_id' => $user->user_id,
                        'username' => $user->username,
                        'fname' => $user->fname,
                        'lname' => $user->lname,
                        'sub_type_user' => $user->sub_type_user,
                        'block' => $user->block,
                        'type_user' => $user->type_user,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                        'online' => $user->online,
                        'email' => TB_EMAIL::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
                        'phone' => TB_PHONE::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
                    ];
                }
            }
            return $data;
        } else if ($type == "CUSTOMER") {
            $users = DB::table('TB_USERS')->where([
                ['TB_USERS.user_id', '!=', Auth::user()->user_id],
                ['TB_USERS.type_user', '=', $type],
                ['TB_USER_CUSTOMER.company_id', '=', $company_id],
                ['TB_PHONE.is_primary', '=', true],
                ['TB_EMAIL.is_primary', '=', true],
            ])
                ->join('TB_USER_CUSTOMER', 'TB_USER_CUSTOMER.user_id', '=', 'TB_USERS.user_id')
                ->join('TB_PHONE', 'TB_PHONE.user_id', '=', 'TB_USERS.user_id')
                ->join('TB_EMAIL', 'TB_EMAIL.user_id', '=', 'TB_USERS.user_id')
                ->offset($start)
                ->limit($length)
                ->orderBy($order, $dir)
                ->get();

            $data = [];
            if (!empty($users)) {
                foreach ($users as $user) {
                    $data[] = [
                        'user_id' => $user->user_id,
                        'username' => $user->username,
                        'fname' => $user->fname,
                        'lname' => $user->lname,
                        'block' => $user->is_block,
                        'type_user' => $user->type_user,
                        'address' => DB::select('SELECT ADDRESS_USERS.user_id, ADDRESS_USERS.address_detail, ADDRESS_USERS.district_id, ADDRESS_USERS.amphure_id, ADDRESS_USERS.province_id,
                                                        DISTRICTS.zip_code, DISTRICTS.name_th as dNameTh, DISTRICTS.name_en as dNameEn,
                                                        AMPHURES.name_th as aNameTh, AMPHURES.name_en as aNameEn,
                                                        PROVINCES.name_th as pNameTh, PROVINCES.name_en as pNameEn
                                                FROM ADDRESS_USERS INNER JOIN DISTRICTS ON DISTRICTS.district_id = ADDRESS_USERS.district_id
                                                INNER JOIN AMPHURES ON AMPHURES.amphure_id = ADDRESS_USERS.amphure_id
                                                INNER JOIN PROVINCES ON PROVINCES.province_id = ADDRESS_USERS.province_id
                                                WHERE ADDRESS_USERS.user_id = ?', [$user->user_id]),
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                        'online' => $user->online,
                        'email' => TB_EMAIL::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
                        'phone' => TB_PHONE::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
                    ];
                }
            }
            return $data;
        }
    }

    public function searchByTypeForCompany($type, $company_id, $start, $length, $search, $order, $dir)
    {
        $data = [];
        $table = null;

        if ($type == 'COMPANY') {
            $users = DB::table('TB_USERS')->where([
                ['TB_USERS.user_id', '!=', Auth::user()->user_id],
                ['TB_USERS.type_user', '=', $type],
                ['TB_USER_COMPANY.company_id', '=', $company_id],

            ])
                ->where(function ($query) use ($search) {
                    $query->orWhere('TB_USERS.fname', 'LIKE', "%{$search}%")
                        ->orWhere('TB_USERS.lname', 'LIKE', "%{$search}%")
                        ->orWhere('TB_USER_COMPANY.sub_type_user', 'LIKE', "%{$search}%")
                        ->orWhere('TB_PHONE.phone_user', 'LIKE', "%{$search}%")
                        ->orWhere('TB_EMAIL.email_user', 'LIKE', "%{$search}%");
                })
                ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_USERS.user_id')
                ->join('TB_PHONE', 'TB_PHONE.user_id', '=', 'TB_USERS.user_id')
                ->join('TB_EMAIL', 'TB_EMAIL.user_id', '=', 'TB_USERS.user_id')
                ->offset($start)
                ->limit($length)
                ->get();

            $user_id = null;
            foreach ($users as $user) {
                if ($user_id != $user->user_id) {
                    $user_id = $user->user_id;
                    $data[] = [
                        'user_id' => $user->user_id,
                        'fname' => $user->fname,
                        'lname' => $user->lname,
                        'sub_type_user' => $user->sub_type_user,
                        'block' => $user->block,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                        'online' => $user->online,
                        'email' => TB_EMAIL::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
                        'phone' => TB_PHONE::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
                    ];
                }
            }
            return $data;
        } else if ($type == 'CUSTOMER') {
            $users = DB::table('TB_USERS')->where([
                ['TB_USERS.user_id', '!=', Auth::user()->user_id],
                ['TB_USERS.type_user', '=', $type],
                ['TB_USER_CUSTOMER.company_id', '=', $company_id],
            ])
                ->where(function ($query) use ($search) {
                    $query->orWhere('TB_USERS.fname', 'LIKE', "%{$search}%")
                        ->orWhere('TB_USERS.lname', 'LIKE', "%{$search}%")
                        ->orWhere('TB_PHONE.phone_user', 'LIKE', "%{$search}%")
                        ->orWhere('TB_EMAIL.email_user', 'LIKE', "%{$search}%");
                })
                ->join('TB_USER_CUSTOMER', 'TB_USER_CUSTOMER.user_id', '=', 'TB_USERS.user_id')
                ->join('TB_PHONE', 'TB_PHONE.user_id', '=', 'TB_USERS.user_id')
                ->join('TB_EMAIL', 'TB_EMAIL.user_id', '=', 'TB_USERS.user_id')
                ->offset($start)
                ->limit($length)
                ->get();

            $user_id = null;
            foreach ($users as $user) {
                if ($user_id != $user->user_id) {
                    $user_id = $user->user_id;
                    $data[] = [
                        'user_id' => $user->user_id,
                        'fname' => $user->fname,
                        'lname' => $user->lname,
                        'block' => $user->block,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                        'online' => $user->online,
                        'email' => TB_EMAIL::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
                        'phone' => TB_PHONE::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
                    ];
                }
            }
            return $data;
        }
    }

    public function countUserOnline($type, $company_id = null)
    {
        // TODO: Implement countUserOnline() method.
        if ($company_id == 1) {
            return DB::select('SELECT if(TB_USERS.online,?,?) as online,COUNT(user_id) as count FROM TB_USERS
                                    WHERE type_user = ?
                                    GROUP BY TB_USERS.online', ['online', 'offline', $type]);
        } else {
            if ($type == 'COMPANY') {
                return DB::select('SELECT if(TB_USERS.online,?,?) as online,COUNT(TB_USERS.user_id) as count FROM TB_USERS
                                        INNER JOIN TB_USER_COMPANY ON TB_USER_COMPANY.user_id = TB_USERS.user_id
                                        WHERE type_user = ? AND TB_USER_COMPANY.company_id = ? AND TB_USERS.user_id != ?
                                        GROUP BY TB_USERS.online', ['online', 'offline', $type, $company_id, Auth::user()->user_id]);
            } else if ($type == 'CUSTOMER') {
                return DB::select('SELECT if(TB_USERS.online,?,?) as online,COUNT(TB_USERS.user_id) as count FROM TB_USERS
                                        INNER JOIN TB_USER_CUSTOMER ON TB_USER_CUSTOMER.user_id = TB_USERS.user_id
                                        WHERE type_user = ? AND TB_USER_CUSTOMER.company_id = ?
                                        GROUP BY TB_USERS.online', ['online', 'offline', $type, $company_id]);
            }
        }
        return;
    }

    public function countUser($type, $company_id)
    {
        if ($company_id == 1) {
            return DB::select('SELECT COUNT(user_id) as count FROM TB_USERS
                                    WHERE type_user = ?', [$type]);
        } else {
            if ($type == 'COMPANY') {
                return DB::select('SELECT COUNT(TB_USERS.user_id) as count FROM TB_USERS
                                        INNER JOIN TB_USER_COMPANY ON TB_USER_COMPANY.user_id = TB_USERS.user_id
                                        WHERE type_user = ? AND TB_USER_COMPANY.company_id = ? AND TB_USERS.user_id != ?', [$type, $company_id, Auth::user()->user_id]);
            } else if ($type == 'CUSTOMER') {
                return DB::select('SELECT COUNT(TB_USERS.user_id) as count FROM TB_USERS
                                        INNER JOIN TB_USER_CUSTOMER ON TB_USER_CUSTOMER.user_id = TB_USERS.user_id
                                        WHERE type_user = ? AND TB_USER_CUSTOMER.company_id = ?', [$type, $company_id]);
            }
        }
        return;
    }

    public function create(array $attributes)
    {
        // TODO: Implement create() method.
        DB::beginTransaction();
        try {
            $password = str_random(10);
            $user = TB_USERS::create([
                'username' => $attributes['username'],
                'fname' => $attributes['fname'],
                'lname' => $attributes['lname'],
                'password' => Hash::make($password),
                'type_user' => $attributes['type_user'],
            ]);

            // $user_address = Address_users::create([
            //     'user_id' => $user->user_id,
            //     'address_detail' => $attributes['address'],
            //     'district_id' => $attributes['district'],
            //     'amphure_id' => $attributes['amphure'],
            //     'province_id' => $attributes['province'],
            // ]);

            USER_FIRST_CREATE::insert([
                'user_id' => $user->user_id,
                'token' => str_random(30),
            ]);

            if ($attributes['type_user'] == "ADMIN") {
                if ($user->user_id) {
                    TB_USER_COMPANY::create([
                        'user_id' => $user->user_id,
                        'company_id' => '1',
                        'sub_type_user' => 'ADMIN',
                    ]);

                    TB_EMAIL::create([
                        'user_id' => $user->user_id,
                        'email_user' => $attributes['email_user'],
                        'is_verify' => false,
                        'is_primary' => true,
                    ]);

                    TB_PHONE::create([
                        'user_id' => $user->user_id,
                        'phone_user' => $attributes['phone_user'],
                        'is_verify' => false,
                        'is_primary' => true,
                    ]);
                }
            } else if ($attributes['type_user'] == "COMPANY") {
                if ($user->user_id) {

                    if (!empty($attributes['admincheck'])) {
                        if($attributes['admincheck'] == "true")
                        {
                            TB_USER_COMPANY::create([
                                'user_id' => $user->user_id,
                                'company_id' => $attributes['company_id'],
                                'sub_type_user' => $attributes['sub_type_user'],
                                'is_user_main' => true,
                            ]);
                        }
                    }
                    else
                    {
                        TB_USER_COMPANY::create([
                            'user_id' => $user->user_id,
                            'company_id' => $attributes['company_id'],
                            'sub_type_user' => $attributes['sub_type_user'],
                        ]);
                    }


                    TB_EMAIL::create([
                        'user_id' => $user->user_id,
                        'email_user' => $attributes['email_user'],
                        'is_verify' => false,
                        'is_primary' => true,
                    ]);

                    TB_PHONE::create([
                        'user_id' => $user->user_id,
                        'phone_user' => $attributes['phone_user'],
                        'is_verify' => false,
                        'is_primary' => true,
                    ]);
                }
            } else if ($attributes['type_user'] == "CUSTOMER") {
                if ($user->user_id) {
                    TB_USER_CUSTOMER::create([
                        'user_id' => $user->user_id,
                        'company_id' => $attributes['company_id'],
                    ]);

                    TB_EMAIL::create([
                        'user_id' => $user->user_id,
                        'email_user' => $attributes['email_user'],
                        'is_verify' => false,
                        'is_primary' => true,
                    ]);

                    TB_PHONE::create([
                        'user_id' => $user->user_id,
                        'phone_user' => $attributes['phone_user'],
                        'is_primary' => true,
                    ]);
                }
            }

            $name = $attributes['fname'] . " " . $attributes['lname'];
            $email = $attributes['email_user'];

            $verification_code = str_random(30); //Generate verification code

            DB::table('USER_VERIFICATIONS')->insert(['user_id'=>$user->user_id,'token'=>$verification_code]);
            $subject = "Please verify your email address."; // หัวข้อเมล์
            // //ส่ง Email run queue
            // dispatch(new SendEmailJob($subject,$name,$email,$verification_code,$attributes['username'],$password));

            Mail::send('auth.verify', ['name' => $name, 'verification_code' => $verification_code,'email' => $email,'username'=> $attributes['username'],'password'=>$password],
                function($mail) use ($email, $name, $subject){
                    $mail->from(getenv('MAIL_USERNAME'), "From KU-CLOUD");
                    $mail->to($email, $name);
                    $mail->subject($subject);
            });

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function update(array $attributes)
    {
        // TODO: Implement update() method.
        DB::beginTransaction();
        try {
            $user = TB_USERS::where('user_id', $attributes['user_id'])
                ->update([
                    'username' => $attributes['username'],
                    'fname' => $attributes['fname'],
                    'lname' => $attributes['lname'],
                ]);

            if (!empty($attributes['phone_user'])) {
                foreach ($attributes['phone_user'] as $value) {
                    TB_PHONE::firstOrCreate([
                        'user_id' => $attributes['user_id'],
                        'phone_user' => $value,
                    ]);
                }
            }

            if (!empty($attributes['email_user'])) {
                foreach ($attributes['email_user'] as $value) {
                    TB_EMAIL::firstOrCreate([
                        'user_id' => $attributes['user_id'],
                        'email_user' => $value,
                    ]);
                }
            }

            if (!empty($attributes['type_user'])) {

                if ($attributes['type_user'] == "COMPANY") {
                    TB_USER_COMPANY::where('user_id', $attributes['user_id'])
                        ->update([
                            'sub_type_user' => $attributes['sub_type_user'],
                        ]);

                    if (!empty($attributes['company_id'])) {
                        TB_USER_COMPANY::where('user_id', $attributes['user_id'])
                            ->update([
                                'company_id' => $attributes['company_id'],
                            ]);
                    }

                } else if ($attributes['type_user'] == "CUSTOMER") {
                    if (!empty($attributes['company_id'])) {
                        TB_USER_CUSTOMER::where('user_id', $attributes['user_id'])
                            ->update([
                                'company_id' => $attributes['company_id'],
                            ]);
                    }
                }

            }

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function delete($user_id, $type_user)
    {
        DB::beginTransaction();
        try {
            if (!empty($type_user)) {

                if($type_user == "ADMIN")
                {

                }
                else if ($type_user == "COMPANY") 
                {
                    $userCompany = TB_USER_COMPANY::where('user_id', $user_id)
                    ->delete();      
                } 
                else if ($type_user == "CUSTOMER") 
                {
                    $userCustomer = TB_USER_CUSTOMER::where('user_id', $user_id)
                        ->delete();
                }

                $email = true;
                while ($email) {
                    $email = TB_EMAIL::where('user_id', $user_id)
                        ->delete();
                }
        
                $phone = true;
                while ($phone) {
                    $phone = TB_PHONE::where('user_id', $user_id)
                        ->delete();
                }

                $address_user = true;
                while ($address_user) {
                    $address_user = Address_users::where('user_id', $user_id)
                        ->delete();
                }
        
                $user = TB_USERS::where('user_id', $user_id)
                    ->delete();

            }

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function deleteEmailUser(array $attributes)
    {
        DB::beginTransaction();
        try {
            $data = TB_EMAIL::where([
                ['email_user', '=', $attributes['email_user']],
                ['is_primary', '=', false],
            ])->delete();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function deletePhoneUser(array $attributes)
    {
        DB::beginTransaction();
        try {
            $data = TB_PHONE::where([
                ['phone_user', '=', $attributes['phone_user']],
                ['is_primary', '=', false],
            ])->delete();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function getAllEmailCustomer()
    {
        // TODO: Implement getCustomerNoCompany() method.
        $company_id = Auth::user()->user_company()->first()->company_id;
        $data = DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,TB_EMAIL.email_user FROM TB_USERS
        INNER JOIN TB_EMAIL ON TB_EMAIL.user_id = TB_USERS.user_id
        LEFT JOIN TB_USER_CUSTOMER ON TB_USER_CUSTOMER.user_id = TB_USERS.user_id
        LEFT JOIN TB_COMPANY ON TB_COMPANY.company_id = TB_USER_CUSTOMER.company_id
        WHERE TB_USERS.type_user = ?  AND TB_EMAIL.is_primary = ? AND (TB_COMPANY.company_id IS NULL OR  TB_COMPANY.company_id != ?)', ['CUSTOMER', true, $company_id]);
        return $data;
    }

    public function getAllEmailCustomerInCompany()
    {
        // TODO: Implement getCustomerNoCompany() method.
        $company_id = Auth::user()->user_company()->first()->company_id;
        $data = DB::select('SELECT TB_USERS.user_id,TB_USERS.fname,TB_USERS.lname,TB_EMAIL.email_user FROM TB_USERS
        INNER JOIN TB_EMAIL ON TB_EMAIL.user_id = TB_USERS.user_id
        LEFT JOIN TB_USER_CUSTOMER ON TB_USER_CUSTOMER.user_id = TB_USERS.user_id
        LEFT JOIN TB_COMPANY ON TB_COMPANY.company_id = TB_USER_CUSTOMER.company_id
        WHERE TB_USERS.type_user = ?  AND TB_EMAIL.is_primary = ? AND TB_COMPANY.company_id = ?', ['CUSTOMER', true, $company_id]);
        return $data;
    }

    public function getAllUsernameCustomerInCompany(){
        $company_id = Auth::user()->user_company()->first()->company_id;
        $data = TB_USERS::where('company_id','=',$company_id)
                ->join('TB_USER_CUSTOMER','TB_USER_CUSTOMER.user_id','=','TB_USERS.user_id')
                ->join('TB_EMAIL','TB_EMAIL.user_id','TB_USERS.user_id')
                ->get(['TB_USERS.user_id','TB_USERS.username','TB_EMAIL.email_user']);
        return $data;
    }

    public function addCustomerInCompany(array $userList)
    {
        DB::beginTransaction();
        try {
            foreach ($userList as $user_id) {
                TB_USER_CUSTOMER::firstOrCreate([
                    'user_id' => $user_id,
                    'company_id' => Auth::user()->user_company()->first()->company_id,
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function getCustomerByCompany()
    {
        $data = TB_USERS::where([
            ['company_id', '=', Auth::user()->user_company()->first()->company_id],
            ['is_approved', '=', true],
            ['is_primary', '=', true],
            ['is_verify', '=', true],
        ])
            ->join('TB_EMAIL', 'TB_EMAIL.user_id', '=', 'TB_USERS.user_id')
            ->join('TB_USER_CUSTOMER', 'TB_USER_CUSTOMER.user_id', '=', 'TB_USERS.user_id')->get();

        return response()->json(compact('data'), 200);
    }

    public function isBlockUser($user_id,$isBlock)
    {
        try {
            $userInDB = TB_USERS::where('user_id',$user_id)->first();
            if($userInDB->type_user === "ADMIN" || $userInDB->type_user  === "COMPANY"){
                $user = TB_USERS::where('user_id', $user_id)
                    ->update(['block' =>  $isBlock]);
            }
            else if($userInDB->type_user  === "CUSTOMER"){
                $user = TB_USER_CUSTOMER::where('user_id', $user_id)
                    ->update(['is_block' => $isBlock]);
            }

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
        DB::commit();
    }

    //Custom function
    public function getTypeById($user_id)
    {
        $data = TB_USERS::select('type_user')->where('user_id', $user_id)->first();
        return $data;
    }
    public function getCompanyIdByUserId($user_id)
    {
        $data = TB_USER_COMPANY::select('company_id')->where('user_id', $user_id)->first();
        return $data;
    }

    public function getUserById($user_id)
    {
        $data = TB_USERS::where('user_id', $user_id)->first();
        return $data;
    }
}
