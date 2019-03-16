<?php

use App\TB_COMPANY;
use App\TB_DASHBOARDS;
use App\TB_DATA_ANALYSIS;
use App\TB_EMAIL;
use App\TB_PHONE;
use App\TB_USERS;
use App\TB_USER_COMPANY;
use App\TB_USER_CUSTOMER;
use Illuminate\Database\Migrations\Migration;

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
                'company_id' => '1',
                'company_name' => 'KU_CLOUD',
                'alias' => 'KU_CLOUD',
                'note' => 'KU_CLOUD',
                'folder_log' => 'KU_CLOUD',
            ],
            [
                'company_id' => '2',
                'company_name' => 'TEST',
                'alias' => 'TEST',
                'note' => 'TEST',
                'folder_log' => 'COMPANY_2',
            ],

        ];

        TB_COMPANY::insert($company);

        $users = [
            [
                'user_id' => 1,
                'username' => 'admin',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'fname' => 'ADMIN',
                'lname' => 'ADMIN',
                'type_user' => 'ADMIN',
            ],
            [
                'user_id' => 2,
                'username' => 'company',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'fname' => 'COMPANY',
                'lname' => 'COMPANY',
                'type_user' => 'COMPANY',
            ],
            [
                'user_id' => 3,
                'username' => 'customer',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'fname' => 'CUSTOMER',
                'lname' => 'CUSTOMER',
                'type_user' => 'CUSTOMER',
            ],
        ];

        TB_USERS::insert($users);

        $email_list = [
            [
                'user_id' => 1,
                'email_user' => 'admin@hotmail.com',
                'is_verify' => true,
                'is_primary' => true,
            ],
            [
                'user_id' => 2,
                'email_user' => 'company@hotmail.com',
                'is_verify' => true,
                'is_primary' => true,
            ],
            [
                'user_id' => 3,
                'email_user' => 'customer@hotmail.com',
                'is_verify' => true,
                'is_primary' => true,
            ],
        ];

        TB_EMAIL::insert($email_list);

        $phone_list = [
            [
                'user_id' => 1,
                'phone_user' => '0818515125',
                'is_primary' => true,
                'is_verify' => true,
            ],
            [
                'user_id' => 2,
                'phone_user' => '0818515126',
                'is_primary' => true,
                'is_verify' => true,
            ],
            [
                'user_id' => 3,
                'phone_user' => '0818515127',
                'is_primary' => true,
                'is_verify' => true,
            ],
        ];

        TB_PHONE::insert($phone_list);

        TB_USER_COMPANY::insert([
            'user_id' => 1,
            'is_user_main' => true,
            'company_id' => 1,
            'sub_type_user' => 'ADMIN',
        ]);

        TB_USER_COMPANY::insert([
            'user_id' => 2,
            'is_user_main' => true,
            'company_id' => 2,
            'sub_type_user' => 'ADMIN',
        ]);

        TB_USER_CUSTOMER::insert([
            'user_id' => 3,
            'company_id' => 2,
        ]);

        TB_DASHBOARDS::insert([
            'dashboard_id' => 1,
            'user_id' => 2,
            'name' => 'สถานีตัวอย่าง',
            'dashboard' => '[]',
        ]);

        // TB_STATIC_COMPANY::insert([
        //     'static_id' => 1,
        //     'company_id' => 2,
        // ]);

        TB_DATA_ANALYSIS::create([
            'user_id' => 2,
            'name' => 'weather.nominal.arff',
            'path_file' => 'weather.nominal.arff',
            'is_success' => true,
        ]);

        TB_DATA_ANALYSIS::create([
            'user_id' => 2,
            'name' => 'cpu.arff',
            'path_file' => 'cpu.arff',
            'is_success' => true,
        ]);

        TB_DATA_ANALYSIS::create([
            'user_id' => 2,
            'name' => 'glass.arff',
            'path_file' => 'glass.arff',
            'is_success' => true,
        ]);

        TB_DATA_ANALYSIS::create([
            'user_id' => 2,
            'name' => 'weather.numeric.arff',
            'path_file' => 'weather.numeric.arff',
            'is_success' => true,
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
