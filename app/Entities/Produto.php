<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 26 May 2018 00:17:17 -0300.
 */

namespace App\Entities;

use App\Entities\Entity as Eloquent;
use App\Traits\Files;
use App\Traits\StatusScope;


/**
 * App\Entities\Produto
 *
 * @property int $id
 * @property string $nome
 * @property string $descricao
 * @property float $valor
 * @property int $status
 * @property int $categoria_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Entities\Categoria $categoria
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\ClientesProduto[] $clientesProduto
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Arquivo[] $fotos
 * @property-read mixed $url_fotos
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Produto ativos()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Produto inativos()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Produto whereCategoriaId($value)
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
    use StatusScope, Files;
    const FOTO = 'PRODUTO_FOTO';
    public static $snakeAttributes = false;

	protected $casts = [
		'valor' => 'float',
		'status' => 'int',
		'categoria_id' => 'int'
	];

	protected $fillable = [
		'nome',
		'descricao',
		'valor',
		'status',
        'categoria_id'
	];

	public function clientesProduto()
	{
		return $this->hasMany(ClientesProduto::class);
	}

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
	}

    public function fotos()
    {
        return $this->morphMany(Arquivo::class, 'entidade');
	}

    public function getUrlFotosAttribute()
    {
        $urls = [];

        $this->fotos->each(function(Arquivo $arquivo) use (&$urls){
            $urls[] = $arquivo->url_thumb;
        });

        if(count($urls) <= 0){
            $urls[] = asset('assets/images/produto-sem-imagem.png');
        }

        return collect($urls);
	}
}
