<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 26 May 2018 00:17:17 -0300.
 */

namespace App\Entities;

use App\Entities\Entity as Eloquent;
use App\Traits\StatusScope;

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
 * @property Cartao $cartao
 * @property \Illuminate\Database\Eloquent\Collection $clientesProdutos
 * @package App\Entities
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido ativos()
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido inativos()
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereCartaoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido wherePagamentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereValorTotal($value)
 * @mixin \Eloquent
 * @property-read mixed $status_label
 * @property int $cliente_id
 * @property-read \App\Entities\Cliente $cliente
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Pedido whereClienteId($value)
 */
class Pedido extends Eloquent
{
    use StatusScope;

    const ABERTO = 0;
    const FECHADO = 1;
    const EXPIRADO = 2;

    public static $snakeAttributes = false;

	protected $casts = [
		'status' => 'int',
		'valor_total' => 'float',
		'cartao_id' => 'int',
		'cliente_id' => 'int'
	];

	protected $fillable = [
		'status',
		'valor_total',
		'pagamento_id',
		'cartao_id',
		'cliente_id'
	];

	public function cartao()
	{
		return $this->belongsTo(Cartao::class, 'cartao_id');
	}

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

	public function clientesProdutos()
	{
		return $this->hasMany(ClientesProduto::class);
	}

    public function isAberto()
    {
        return $this->isStatus(self::ABERTO);
    }
}
