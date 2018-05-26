<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 26 May 2018 00:17:17 -0300.
 */

namespace App\Entities;

use App\Entities\Entity as Eloquent;

/**
 * Class Cliente
 *
 * @property int $id
 * @property string $email
 * @property string $ra
 * @property string $senha
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $cartoes
 * @property \Illuminate\Database\Eloquent\Collection $produtos
 *
 * @package App\Entities
 */
class Cliente extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	public static $snakeAttributes = false;

	protected $casts = [
		'status' => 'int'
	];

	protected $hidden = [
		'senha'
	];

	protected $fillable = [
		'email',
		'ra',
		'senha',
		'status'
	];

	public function cartoes()
	{
		return $this->hasMany(\App\Entities\Cartao::class);
	}

	public function produtos()
	{
		return $this->belongsToMany(\App\Entities\Produto::class, 'clientes_produtos')
					->withPivot('id', 'status', 'pedido_id', 'administrador_id')
					->withTimestamps();
	}
}
