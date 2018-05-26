<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 26 May 2018 00:17:16 -0300.
 */

namespace App\Entities;

use App\Entities\Entity as Eloquent;

/**
 * Class Cartao
 *
 * @property int $id
 * @property string $hash
 * @property string $bandeira
 * @property string $ultimos_digitos
 * @property string $nome_completo
 * @property string $data_expiracao
 * @property int $cliente_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property Cliente $cliente
 * @property \Illuminate\Database\Eloquent\Collection $pedidos
 *
 * @package App\Entities
 */
class Cartao extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'cartoes';
	public static $snakeAttributes = false;

	protected $casts = [
		'cliente_id' => 'int'
	];

	protected $fillable = [
		'hash',
		'bandeira',
		'ultimos_digitos',
		'nome_completo',
		'data_expiracao',
		'cliente_id'
	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function pedidos()
	{
		return $this->hasMany(Pedido::class, 'cartao_id');
	}
}
