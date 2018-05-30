<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPedidosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pedidos', function(Blueprint $table)
		{
			$table->foreign('cartao_id', 'fk_pedidos_cartoes1')->references('id')->on('cartoes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('cliente_id', 'fk_pedidos_clientes1')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pedidos', function(Blueprint $table)
		{
			$table->dropForeign('fk_pedidos_cartoes1');
			$table->dropForeign('fk_pedidos_clientes1');
		});
	}

}
