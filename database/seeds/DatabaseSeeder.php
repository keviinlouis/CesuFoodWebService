<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeed::class);
        $this->call(CategoriasTableSeed::class);

        if(env('APP_ENV') != 'production'){
            $this->call(TestesSeed::class);
        }
    }
}
