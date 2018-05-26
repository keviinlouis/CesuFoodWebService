<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientesProdutosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clientes_produtos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('status')->default(0);
			$table->integer('cliente_id')->unsigned()->index('fk_clientes_produtos_clientes_idx');
			$table->integer('produto_id')->unsigned()->index('fk_clientes_produtos_produtos1_idx');
			$table->integer('pedido_id')->unsigned()->index('fk_clientes_produtos_pedidos1_idx');
			$table->integer('administrador_id')->unsigned()->nullable()->index('fk_clientes_produtos_administradores1_idx');
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
		Schema::drop('clientes_produtos');
	}

}
