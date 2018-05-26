<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToClientesProdutosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('clientes_produtos', function(Blueprint $table)
		{
			$table->foreign('administrador_id', 'fk_clientes_produtos_administradores1')->references('id')->on('administradores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('cliente_id', 'fk_clientes_produtos_clientes')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('pedido_id', 'fk_clientes_produtos_pedidos1')->references('id')->on('pedidos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('produto_id', 'fk_clientes_produtos_produtos1')->references('id')->on('produtos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('clientes_produtos', function(Blueprint $table)
		{
			$table->dropForeign('fk_clientes_produtos_administradores1');
			$table->dropForeign('fk_clientes_produtos_clientes');
			$table->dropForeign('fk_clientes_produtos_pedidos1');
			$table->dropForeign('fk_clientes_produtos_produtos1');
		});
	}

}
