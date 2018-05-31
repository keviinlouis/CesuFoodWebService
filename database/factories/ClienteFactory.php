<?php

use Faker\Factory as Faker;

$faker = Faker::create('pt_BR');

$factory->define(App\Entities\Cliente::class, function () use ($faker) {
    $data = [
        'email' => $faker->email,
        'ra' => rand(10000000, 99999999),
        'senha' => '123456',
    ];
    return $data;
});
