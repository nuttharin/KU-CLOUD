<?php

use Faker\Generator as Faker;

$factory->define(App\TB_USER_CUSTOMER::class, function (Faker $faker) {
    return [
        'company_id'=>2,
    ];
});
