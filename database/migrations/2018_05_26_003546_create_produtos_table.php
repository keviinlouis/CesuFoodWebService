<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProdutosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('produtos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nome', 191);
			$table->text('descricao', 65535);
			$table->float('valor', 10);
			$table->integer('status')->default(1);
			$table->boolean('is_destaque')->default(0);
            $table->integer('categoria_id')->unsigned()->index('fk_produtos_categorias1_idx');
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
		Schema::drop('produtos');
	}

}
