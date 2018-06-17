<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToClientesProdutosFavoritosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('clientes_produtos_favoritos', function(Blueprint $table)
		{
            $table->foreign('cliente_id', 'fk_clientes_produtos_clientes2')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('produto_id', 'fk_clientes_produtos_produtos2')->references('id')->on('produtos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('clientes_produtos_favoritos', function(Blueprint $table)
		{
			$table->dropForeign('fk_clientes_produtos_clientes2');
			$table->dropForeign('fk_clientes_produtos_produtos2');
		});
	}

}
