<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 26 May 2018 00:17:17 -0300.
 */

namespace App\Entities;

use App\Entities\User as Eloquent;
use App\Traits\StatusScope;

/**
 * Class ClienteController
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
 * @property-read \Illuminate\Database\Eloquent\Collection|ClientesProduto[] $clientesProdutos
 * @property-read \Illuminate\Database\Eloquent\Collection|Pedido[] $pedidos
 * @property-read string $status_label
 * @property-read \App\Entities\Arquivo $fotoPerfil
 * @property-read string $url_foto_perfil
 * @property-read string $url_foto_perfil_thumb
 * @property-read Pedido $pedido_aberto
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente ativos()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente inativos()
 * @method static \Illuminate\Database\Query\Builder|Cliente onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereRa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereSenha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Cliente withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Cliente withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Entities\Pedido $pedidoAberto
 */
class Cliente extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes, StatusScope;
    const FOTO_PERFIL = 'FOTO_PERFIL_CLIENTE';
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

    function getClassAuth(): string
    {
        return self::class;
    }

    public function cartoes()
	{
		return $this->hasMany(Cartao::class);
	}

    public function clientesProdutos()
    {
        return $this->hasMany(ClientesProduto::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
	}

    public function pedidoAberto()
    {
        return $this->hasOne(Pedido::class)->where('status', Pedido::ABERTO);
    }

    public function fotoPerfil()
    {
        return $this->morphOne(Arquivo::class, 'entidade')->where('tipo', self::FOTO_PERFIL);
	}

    public function getUrlFotoPerfilAttribute()
    {
        if(!$this->fotoPerfil){
            return asset('assets/images/imagem-perfil.jpg');
        }

        return $this->fotoPerfil->url;
	}

    public function getUrlFotoPerfilThumbAttribute()
    {
        if(!$this->fotoPerfil){
            return asset('assets/images/imagem-perfil.jpg');
        }

        return $this->fotoPerfil->url_thumb;
    }

    public function getPedidoAbertoAttribute()
    {
        $pedido = $this->pedidoAberto()->first();

        if(!$pedido){
            $pedido = $this->pedidos()->create([
                'status' => Pedido::ABERTO
            ]);
        }

        return $pedido;
    }
}
