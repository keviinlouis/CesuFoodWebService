<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePedidosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pedidos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('status')->default(0);
			$table->float('valor_total', 10)->default(0);
			$table->text('pagamento_id', 65535)->nullable();
			$table->integer('cartao_id')->unsigned()->nullable()->index('fk_pedidos_cartoes1_idx');
			$table->integer('cliente_id')->unsigned()->index('fk_pedidos_clientes1_idx');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pedidos');
	}

}
