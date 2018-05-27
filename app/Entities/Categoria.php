<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 26 May 2018 00:17:17 -0300.
 */

namespace App\Entities;

use App\Entities\Entity as Eloquent;
use App\Traits\StatusScope;


/**
 * App\Entities\Categoria
 *
 * @property int $id
 * @property string $nome
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Produto[] $produtos
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Categoria ativos()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Categoria inativos()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Categoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Categoria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Categoria whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Categoria whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Categoria whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Categoria extends Eloquent
{
    use StatusScope;
	public static $snakeAttributes = false;

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'nome',
		'status'
	];

	public function produtos()
	{
		return $this->hasMany(Produto::class);
	}
}
