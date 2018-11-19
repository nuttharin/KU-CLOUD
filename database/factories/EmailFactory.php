<?php

use Faker\Generator as Faker;

$factory->define(App\TB_EMAIL::class, function (Faker $faker) {
    return [
       'email_user'=> $faker->unique()->safeEmail,
       'is_verify'=> true,
       'is_primary' => true,
    ];
});