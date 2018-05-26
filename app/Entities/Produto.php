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
 * @property \Illuminate\Database\Eloquent\Collection $clientes
 * @package App\Entities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\ClientesProduto[] $clientesProduto
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Produto ativos()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Produto inativos()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Produto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Produto whereDescricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Produto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Produto whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Produto whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Produto whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Produto whereValor($value)
 * @mixin \Eloquent
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
