<?php

use Faker\Factory as Faker;

$faker = Faker::create('pt_BR');

$factory->define(App\Entities\Categoria::class, function () use ($faker) {
    $data = [
        'nome' => $faker->name
    ];
    return $data;
});

$factory->define(App\Entities\Produto::class, function () use ($faker) {
    if(\App\Entities\Categoria::count() < 5){
        factory(\App\Entities\Categoria::class, 10)->create();
    }
    $data = [
        'nome' => $faker->name,
        'descricao' => $faker->realText(),
        'valor' => $faker->randomFloat(2, 10, 100),
        'categoria_id' => \App\Entities\Categoria::inRandomOrder()->first()->getKey(),
        'is_destaque' => rand(0, 3) == 1
    ];
    return $data;
});
