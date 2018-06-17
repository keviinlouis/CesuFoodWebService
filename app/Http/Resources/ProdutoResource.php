<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 27/05/2018
 * Time: 01:30
 */

namespace App\Http\Resources;


use App\Entities\Produto;

class ProdutoResource extends Resource
{
    private $clienteLogado;

    public function __construct($resource)
    {
        parent::__construct($resource);
        if(auth()->user()->isCliente()){
            $this->clienteLogado = auth()->user()->load('favoritos');
        }

    }

    /**
     * @param Produto $resource
     * @return array
     */
    public function toResource($resource)
    {
        $data = [
            'id' => $resource->getKey(),
            'nome' => $resource->nome,
            'descricao' => $resource->descricao,
            'valor' => $resource->valor,
            'status' => $resource->status,
            'categoria' => new CategoriaResource($resource->categoria),
            'fotos' => $resource->url_fotos,
            'is_destaque' => $resource->is_destaque
        ];

        if($this->clienteLogado){
            $data['is_favoritado'] = !!$this->clienteLogado->favoritos->where('id', $resource->getKey())->first();
        }

        return $data;
    }
}
