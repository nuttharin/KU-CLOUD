<?php

use Faker\Generator as Faker;

$factory->define(App\TB_USER_COMPANY::class, function (Faker $faker) {
    return [
        'company_id' => 2,
        'sub_type_user'=> $faker->randomElement(['ADMIN' ,'NORMAL']),
    ];
});
