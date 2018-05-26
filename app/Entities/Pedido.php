<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 26 May 2018 00:17:17 -0300.
 */

namespace App\Entities;

use App\Entities\Entity as Eloquent;

/**
 * Class Pedido
 *
 * @property int $id
 * @property int $status
 * @property float $valor_total
 * @property string $pagamento_id
 * @property int $cartao_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Entities\Cartao $cartao
 * @property \Illuminate\Database\Eloquent\Collection $clientesProdutos
 *
 * @package App\Entities
 */
class Pedido extends Eloquent
{
	public static $snakeAttributes = false;

	protected $casts = [
		'status' => 'int',
		'valor_total' => 'float',
		'cartao_id' => 'int'
	];

	protected $fillable = [
		'status',
		'valor_total',
		'pagamento_id',
		'cartao_id'
	];

	public function cartao()
	{
		return $this->belongsTo(\App\Entities\Cartao::class, 'cartao_id');
	}

	public function clientesProdutos()
	{
		return $this->hasMany(\App\Entities\ClientesProduto::class);
	}
}
