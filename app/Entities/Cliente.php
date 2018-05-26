<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 26 May 2018 00:17:17 -0300.
 */

namespace App\Entities;

use App\Entities\User as Eloquent;
use App\Traits\StatusScope;

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
 * @property \Illuminate\Database\Eloquent\Collection $cartoes
 * @property \Illuminate\Database\Eloquent\Collection $produtos
 * @package App\Entities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\ClientesProduto[] $clientesProduto
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Pedido[] $pedidos
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Cliente ativos()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Cliente inativos()
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Cliente onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Cliente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Cliente whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Cliente whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Cliente whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Cliente whereRa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Cliente whereSenha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Cliente whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Cliente whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Cliente withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Cliente withoutTrashed()
 * @mixin \Eloquent
 */
class Cliente extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes, StatusScope;
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
		return $this->hasMany(Cartao::class);
	}

    public function clientesProduto()
    {
        return $this->hasMany(ClientesProduto::class);
    }

    public function pedidos()
    {
        return $this->hasManyThrough(Pedido::class, Cartao::class, 'cliente_id', 'cartao_id');
	}

    function getClassAuth(): string
    {
        return self::class;
    }
}
