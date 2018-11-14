<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\TB_COMPANY;
use App\TB_PHONE;
use App\TB_USERS;
use App\TB_EMAIL;
use App\TB_USER_COMPANY;
use App\TB_USER_CUSTOMER;

class SetupFirst extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $company = [
            [
                'company_id'=>'1',
                'company_name'=>'KU_CLOUD',
                'alias'=>'KU_CLOUD',
                'address'=>'กำแพงแสน',
                'note'=>'KU_CLOUD',
                'folder_log'=>'KU_CLOUD'
            ],
            [
                'company_id'=>'2',
                'company_name'=>'TEST',
                'alias'=>'TEST',
                'address'=>'TEST',
                'note'=>'TEST',
                'folder_log'=>'COMPANY_2'
            ]     
            
        ];


        TB_COMPANY::insert($company);

        $users = [
            [
                'user_id'=>1,
                'password'=>'$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'fname'=>'ADMIN',
                'lname'=>'ADMIN',
                'type_user'=>'ADMIN',
            ],
            [
                'user_id'=>2,
                'password'=>'$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'fname'=>'COMPANY',
                'lname'=>'COMPANY',
                'type_user'=>'COMPANY',
            ],
            [
                'user_id'=>3,
                'password'=>'$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'fname'=>'CUSTOMER',
                'lname'=>'CUSTOMER',
                'type_user'=>'CUSTOMER',
            ]
        ];

        TB_USERS::insert($users);

        $email_list = [
            [
                'user_id'=>1,
                'email_user'=>'admin@hotmail.com',
                'is_verify'=>true,
            ],
            [
                'user_id'=>2,
                'email_user'=>'company@hotmail.com',
                'is_verify'=>true,
            ],
            [
                'user_id'=>3,
                'email_user'=>'customer@hotmail.com',
                'is_verify'=>true,
            ]
        ];

        TB_EMAIL::insert($email_list);

        $phone_list = [
            [
                'user_id'=>1,
                'phone_user'=>'0818515125',
            ],
            [
                'user_id'=>2,
                'phone_user'=>'0818515126',
            ],
            [
                'user_id'=>3,
                'phone_user'=>'0818515127',
            ]
        ];

        TB_PHONE::insert($phone_list);

        TB_USER_COMPANY::insert([
            'user_id'=>1,
            'is_user_main'=>true,
            'company_id'=>1,
            'sub_type_user'=>'ADMIN'
        ]);

        TB_USER_COMPANY::insert([
            'user_id'=>2,
            'is_user_main'=>true,
            'company_id'=>2,
            'sub_type_user'=>'ADMIN'
        ]);

        TB_USER_CUSTOMER::insert([
            'user_id'=>3,
            'company_id'=>2
        ]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
