<?php

use Faker\Generator as Faker;

$factory->define(App\TB_COMAPNY::class, function (Faker $faker) {
    return [
       'company_name'=> $factory->company,
       'alias'=> $factory->company,
       'address'=> $factory->address,
    ];
});