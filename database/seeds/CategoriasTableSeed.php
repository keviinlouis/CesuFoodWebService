<?php

use Illuminate\Database\Seeder;

class CategoriasTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'nome' => 'Salgados'
            ],
            [
                'id' => 2,
                'nome' => 'Doces'
            ],
            [
                'id' => 3,
                'nome' => 'Refrigerantes'
            ],
            [
                'id' => 4,
                'nome' => 'Sucos'
            ],
            [
                'id' => 5,
                'nome' => 'Frutas'
            ]
        ];

        DB::table('categorias')->insert($data);
    }
}
