<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\TB_USERS::class,250)->create()->each(function ($user) {
            $user->phone()->save(factory(App\TB_PHONE::class)->make());
            $user->email()->save(factory(App\TB_EMAIL::class)->make());
            if($user->type_user == "ADMIN"){
                App\TB_USER_COMPANY::create([
                    'user_id' => $user->user_id,
                    'company_id' => 1,
                ]);
            }
            else if($user->type_user == "COMPANY"){
                App\TB_USER_COMPANY::create([
                    'user_id' => $user->user_id,
                    'company_id' => 2,
                ]);
            }
            else if($user->type_user == "CUSTOMER"){
                App\TB_USER_CUSTOMER::create([
                    'user_id' => $user->user_id,
                    'company_id' => 2,
                ]);
            }
            // else if($user->type_user == "CUSTOMER"){
            //     $user->user_customer()->save(factory(App\TB_USER_CUSTOMER::class)->make());
            // }
        });
    }
}
