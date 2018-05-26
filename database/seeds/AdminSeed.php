<?php

use Illuminate\Database\Seeder;

class AdminSeed extends Seeder
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
                'nome' => 'Administrador Teste',
                'email' => 'master@mail.com',
                'senha' => Hash::make('123456'),
                'cargo' => \App\Entities\Administrador::MASTER,
                'status' => \App\Entities\Administrador::ATIVO,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($data as $item) {
            DB::table('administradores')->updateOrInsert($item);
        }
    }
}
