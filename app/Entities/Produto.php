<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 26 May 2018 00:17:17 -0300.
 */

namespace App\Entities;

use App\Entities\Entity as Eloquent;
use App\Traits\StatusScope;

/**
 * Class Produto
 *
 * @property int $id
 * @property string $nome
 * @property string $descricao
 * @property float $valor
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $clientes
 *
 * @package App\Entities
 */
class Produto extends Eloquent
{
    use StatusScope;
	public static $snakeAttributes = false;

	protected $casts = [
		'valor' => 'float',
		'status' => 'int'
	];

	protected $fillable = [
		'nome',
		'descricao',
		'valor',
		'status'
	];

	public function clientesProduto()
	{
		return $this->hasMany(ClientesProduto::class);
	}
}
