<?php

use Faker\Generator as Faker;

$factory->define(App\TB_PHONE::class, function (Faker $faker) {
    return [
       'phone_user'=> str_replace(' ','',$faker->unique()->mobileNumber),
       'is_primary' => true
    ];
});
