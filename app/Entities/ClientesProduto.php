<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 26 May 2018 00:17:17 -0300.
 */

namespace App\Entities;

use App\Entities\Entity as Eloquent;

/**
 * Class ClientesProduto
 *
 * @property int $id
 * @property int $status
 * @property int $cliente_id
 * @property int $produto_id
 * @property int $pedido_id
 * @property int $administrador_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Entities\Administrador $administrador
 * @property \App\Entities\Cliente $cliente
 * @property \App\Entities\Pedido $pedido
 * @property \App\Entities\Produto $produto
 *
 * @package App\Entities
 */
class ClientesProduto extends Eloquent
{
	public static $snakeAttributes = false;

	protected $casts = [
		'status' => 'int',
		'cliente_id' => 'int',
		'produto_id' => 'int',
		'pedido_id' => 'int',
		'administrador_id' => 'int'
	];

	protected $fillable = [
		'status',
		'cliente_id',
		'produto_id',
		'pedido_id',
		'administrador_id'
	];

	public function administrador()
	{
		return $this->belongsTo(\App\Entities\Administrador::class, 'administrador_id');
	}

	public function cliente()
	{
		return $this->belongsTo(\App\Entities\Cliente::class);
	}

	public function pedido()
	{
		return $this->belongsTo(\App\Entities\Pedido::class);
	}

	public function produto()
	{
		return $this->belongsTo(\App\Entities\Produto::class);
	}
}
