<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 26 May 2018 00:17:16 -0300.
 */

namespace App\Entities;

use App\Entities\User as Eloquent;
use App\Traits\StatusScope;

/**
 * Class Administrador
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $senha
 * @property int $cargo
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection $clientesProdutos
 * @package App\Entities
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrador ativos()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrador inativos()
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Administrador onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Administrador withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Administrador withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrador whereCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrador whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrador whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrador whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrador whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrador whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrador whereSenha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrador whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrador whereUpdatedAt($value)
 */
class Administrador extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes, StatusScope;
    const MASTER = 0;
    const FUNCIONARIO = 1;

    const ATIVO = 1;
    const INATIVO = 0;

    public static $snakeAttributes = false;

	protected $table = 'administradores';

	protected $casts = [
		'cargo' => 'int',
		'status' => 'int'
	];

	protected $hidden = [
		'senha'
	];

	protected $fillable = [
		'nome',
		'email',
		'senha',
		'cargo',
		'status'
	];

	public function clientesProdutos()
	{
		return $this->hasMany(ClientesProduto::class, 'administrador_id');
	}

    function getClassAuth(): string
    {
        return self::class;
    }

    public function isMaster()
    {
        return $this->cargo == self::MASTER;
    }
}
