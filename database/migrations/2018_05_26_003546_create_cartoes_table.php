<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartoesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cartoes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('hash', 65535);
			$table->string('bandeira', 45);
			$table->string('ultimos_digitos', 4);
			$table->text('nome_completo', 65535);
			$table->string('data_expiracao', 5);
			$table->integer('cliente_id')->unsigned()->index('fk_cartoes_clientes1_idx');
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cartoes');
	}

}
