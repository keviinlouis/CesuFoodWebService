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
            'fotos' => $resource->url_fotos
        ];

        return $data;
    }
}
