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
use App\TB_STATIC;
use App\TB_STATIC_COMPANY;

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
                'is_primary'=>true
            ],
            [
                'user_id'=>2,
                'email_user'=>'company@hotmail.com',
                'is_verify'=>true,
                'is_primary'=>true
            ],
            [
                'user_id'=>3,
                'email_user'=>'customer@hotmail.com',
                'is_verify'=>true,
                'is_primary'=>true
            ]
        ];

        TB_EMAIL::insert($email_list);

        $phone_list = [
            [
                'user_id'=>1,
                'phone_user'=>'0818515125',
                'is_primary'=>true,
                'is_verify'=>true
            ],
            [
                'user_id'=>2,
                'phone_user'=>'0818515126',
                'is_primary'=>true,
                'is_verify'=>true
            ],
            [
                'user_id'=>3,
                'phone_user'=>'0818515127',
                'is_primary'=>true,
                'is_verify'=>true
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

        TB_STATIC::insert([
            'static_id'=>1,
            'name'=>'test',
            'dashboard'=>'[{"x":0,"y":0,"width":12,"height":1,"widget":{"type":"TextBox","timeInterval":null,"textbox":"สถานีตัวอย่าง","fontsize":"35"}},{"x":0,"y":1,"width":4,"height":4,"widget":{"type":"Gauges","timeInterval":"1","title_name":"ความชื้น","opts":{"angle":0,"lineWidth":0.23,"radiusScale":1,"pointer":{"length":0.6,"strokeWidth":0.035,"color":"#000000"},"limitMax":false,"limitMin":false,"colorStart":"#6FADCF","colorStop":"#8FC0DA","strokeColor":"#E0E0E0","generateGradient":true,"highDpiSupport":true,"staticLabels":{"font":"10px Poppins","labels":[0,100],"color":"#000000","fractionDigits":0}},"limitMin":"0","limitMax":"100","unit":"H"}},{"x":4,"y":1,"width":4,"height":4,"widget":{"type":"TextValue","timeInterval":"0.01","title_name":"ความเร็วลม","unit":"m/s","rgb":"#ff0000"}},{"x":8,"y":1,"width":4,"height":4,"widget":{"type":"text-line","timeInterval":"4500","title_name":"สมุทรปราการ","unit":"rh","rgb":"#0080c0"}},{"x":0,"y":5,"width":12,"height":7,"widget":{"type":"Map","timeInterval":"","title_name":"ประเทศไทย"}},{"x":0,"y":12,"width":12,"height":7,"widget":{"type":"MutiLine","timeInterval":"3","title_name":"อุณหภูมิ","datasets":[{"label":"กรุงเทพ","backgroundColor":"rgba(255,255,255,0.0)","borderColor":"#00fa32","borderWidth":2},{"label":"สระบุรี","backgroundColor":"rgba(255,255,255,0.0)","borderColor":"#ff00cc","borderWidth":2}]}}]',  
        ]);

        TB_STATIC_COMPANY::insert([
            'static_id'=>1,
            'company_id'=>2,
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
