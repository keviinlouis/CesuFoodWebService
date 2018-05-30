<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 26 May 2018 00:17:17 -0300.
 */

namespace App\Entities;

use App\Entities\Entity as Eloquent;
use App\Traits\Files;
use App\Traits\StatusScope;
use QRCode;

/**
 * Class ClientesProduto
 *
 * @property int $id
 * @property int $status
 * @property int $cliente_id
 * @property int $produto_id
 * @property int $pedido_id
 * @property string $hash
 * @property int $administrador_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property Administrador $administrador
 * @property Cliente $cliente
 * @property Pedido $pedido
 * @property Produto $produto
 * @package App\Entities
 * @method static \Illuminate\Database\Eloquent\Builder|ClientesProduto ativos()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientesProduto inativos()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientesProduto whereAdministradorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientesProduto whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientesProduto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientesProduto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientesProduto wherePedidoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientesProduto whereProdutoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientesProduto whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientesProduto whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $status_label
 * @property float $valor
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ClientesProduto whereValor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ClientesProduto whereHash($value)
 */
class ClientesProduto extends Eloquent
{
    use StatusScope, Files;

    const AGUARDANDO_FECHAMENTO = 0;
    const RESERVADO = 1;
    const AGUARDANDO_RETIRADA = 2;
    const FINALIZADO = 3;
    const QR_CODE = 'qr_code';

    public static $snakeAttributes = false;

	protected $casts = [
		'status' => 'int',
        'valor' => 'float',
		'cliente_id' => 'int',
		'produto_id' => 'int',
		'pedido_id' => 'int',
		'administrador_id' => 'int'
	];

	protected $fillable = [
		'status',
        'valor',
		'cliente_id',
		'produto_id',
		'pedido_id',
		'administrador_id',
        'hash'
	];

	public function administrador()
	{
		return $this->belongsTo(Administrador::class, 'administrador_id');
	}

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function pedido()
	{
		return $this->belongsTo(Pedido::class);
	}

	public function produto()
	{
		return $this->belongsTo(Produto::class);
	}

    /**
     * @throws \LaravelQRCode\Exceptions\EmptyTextException
     * @throws \LaravelQRCode\Exceptions\MalformedUrlException
     */
    public function gerarQrCode()
    {
        \Storage::exists($this->getPublicPathFiles())?:\Storage::makeDirectory($this->getPublicPathFiles());

        QRCode::url('http://192.168.100.233/vender/'.$this->hash)
            ->setSize(8)
            ->setMargin(2)
            ->setOutfile($this->getFullPublicPathFiles().'\qr_code.png')
            ->png();
    }

    public function getStatusLabelAttribute()
    {
        switch($this->status){
            case self::AGUARDANDO_FECHAMENTO:
                return 'Aguardando Fechamento';
            case self::RESERVADO:
                return 'Reservado';
            case self::AGUARDANDO_RETIRADA:
                return 'Aguardando Retirada';
            case self::FINALIZADO:
                return 'Finalizado';
            default:
                return '';

        }
    }
}
