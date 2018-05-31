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
        factory(\App\Entities\Produto::class, 500)->create();

        factory(\App\Entities\Cliente::class)->create(['email' => 'kevin@mail.com']);
    }

}
