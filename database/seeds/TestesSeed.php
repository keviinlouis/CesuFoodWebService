<?php

use Illuminate\Database\Seeder;

class TestesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $this->exampleSeed();
    }

    /**
     * @throws Exception
     */
    public function exampleSeed()
    {
        factory(\App\Entities\Categoria::class, 5)->create()->each(function(\App\Entities\Categoria $categoria){
            $categoria->produtos()->saveMany(factory(\App\Entities\Produto::class, rand(1, 5))->make());
        });
    }
}
