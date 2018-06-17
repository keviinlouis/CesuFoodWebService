<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientesProdutosFavoritosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes_produtos_favoritos', function(Blueprint $table)
        {
            $table->integer('cliente_id')->unsigned()->index('fk_clientes_produtos_clientes2_idx');
            $table->integer('produto_id')->unsigned()->index('fk_clientes_produtos_produtos2_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clientes_produtos_favoritos');
	}

}
