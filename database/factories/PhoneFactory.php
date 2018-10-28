<?php

use Faker\Generator as Faker;

$factory->define(App\TB_PHONE::class, function (Faker $faker) {
    return [
       'phone_user'=> $faker->unique()->randomNumber($nbDigits = NULL, $strict = false),
    ];
});
